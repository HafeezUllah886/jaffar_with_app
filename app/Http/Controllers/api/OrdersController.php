<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\order_details;
use App\Models\orders;
use App\Models\products;
use App\Models\units;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index($status, $from, $to, Request $request)
    {

        $from = $from ?? firstDayOfMonth();
        $to = $to ?? now()->toDateString();
        $status = $status ?? 'Pending';

        $data = orders::with('details.product', 'details.unit')->where('orderbookerID', $request->user()->id)
            ->where('status', $status)
            ->whereBetween('date', [$from, $to])->orderBy('id', 'desc')->get();

        $orders = $data->map(function ($order) {
            return [
                'order_id' => $order->id,
                'customer' => [
                    'title' => $order->customer->title,
                    'contact' => $order->customer->contact,
                    'cnic' => $order->customer->cnic,
                    'address' => $order->customer->address,
                    'ntn' => $order->customer->ntn,
                    'strn' => $order->customer->strn,
                ],
                'date' => $order->date,
                'net' => $order->net,
                'wh' => $order->wh,
                'whValue' => $order->whValue,
                'status' => $order->status,
                'notes' => $order->notes,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = products::all();
        $customers = accounts::Customer()->get();
        $units = units::all();

        return view('orders.create', compact('products', 'customers', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'product_ids' => 'required|array',
                'date' => 'required',
                'customerID' => 'required',
                'unit' => 'required|array',
                'qty' => 'required|array',
                'discount' => 'required|array',
                'booker_long' => 'required',
                'booker_lat' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            if (count($request->product_ids) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select at least one product',
                ], 422);
            }

            DB::beginTransaction();

            $customer = accounts::find($request->customerID);
            $distance = getDistance($request->booker_long, $request->booker_lat, $customer->long, $customer->lat);

            $order = orders::create(
                [
                    'orderbookerID' => auth()->user()->id,
                    'customerID' => $request->customerID,
                    'date' => $request->date,
                    'wh' => $request->whTax,
                    'booker_long' => $request->booker_long,
                    'booker_lat' => $request->booker_lat,
                    'customer_long' => $customer->long,
                    'customer_lat' => $customer->lat,
                    'distance' => $distance,
                    'notes' => $request->notes,
                ]
            );

            $orderDetails = [];
            $ids = $request->product_ids;

            $total = 0;
            foreach ($ids as $key => $id) {
                $unit = units::find($request->unit[$key]);
                $product = products::find($id);
                $qty = $request->qty[$key] * $unit->value;
                $price = $product->price - $request->discount[$key];
                $amount = $qty * $price;
                $total += $amount;
                $details = order_details::create(
                    [
                        'orderID' => $order->id,
                        'productID' => $id,
                        'price' => $product->price,
                        'qty' => $qty,
                        'discount' => $request->discount[$key],
                        'bonus' => $request->bonus[$key] ?? 0,
                        'amount' => $amount,
                        'date' => $request->date,
                        'unitID' => $unit->id,
                        'unitValue' => $unit->value,
                    ]
                );
                $orderDetails[] = $details;
            }

            $whValue = $request->whTax * $total / 100;
            $net = $total + $whValue;
            $order->update(
                [
                    'net' => $net,
                    'whValue' => $whValue,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => [
                    'order' => $order,
                    'order_details' => $orderDetails,
                ],
            ], 201);

        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate request
            $validator = Validator::make($request->all(), [
                'product_ids' => 'required|array',
                'date' => 'required',
                'customerID' => 'required',
                'unit' => 'required|array',
                'qty' => 'required|array',
                'discount' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors(),
                ], 422);
            }

            if (count($request->product_ids) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select at least one product',
                ], 422);
            }

            DB::beginTransaction();
            $order = orders::findorFail($id);

            $order->details()->delete();

            $order->update([
                'customerID' => $request->customerID,
                'date' => $request->date,
                'wh' => $request->whTax,
                'notes' => $request->notes,
            ]);

            $orderDetails = [];
            $ids = $request->product_ids;

            $total = 0;
            foreach ($ids as $key => $prod_id) {
                $unit = units::find($request->unit[$key]);
                $product = products::find($prod_id);
                $qty = $request->qty[$key] * $unit->value;
                $price = $product->price - $request->discount[$key];
                $amount = $qty * $price;
                $total += $amount;
                $details = order_details::create(
                    [
                        'orderID' => $order->id,
                        'productID' => $prod_id,
                        'price' => $product->price,
                        'qty' => $qty,
                        'discount' => $request->discount[$key],
                        'bonus' => $request->bonus[$key] ?? 0,
                        'amount' => $amount,
                        'date' => $request->date,
                        'unitID' => $unit->id,
                        'unitValue' => $unit->value,
                    ]
                );
                $orderDetails[] = $details;
            }

            $whValue = $request->whTax * $total / 100;
            $net = $total + $whValue;
            $order->update(
                [
                    'net' => $net,
                    'whValue' => $whValue,
                ]
            );

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Order Updated successfully',
                'data' => [
                    'order' => $order,
                    'order_details' => $orderDetails,
                ],
            ], 200);

        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function showSingleOrder(Request $request, $id)
    {
        $order = orders::with('details.product', 'details.unit', 'customer')->find($id);

        if (! $order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $orderData = [
            'order_id' => $order->id,
            'customer' => [
                'id' => $order->customer->id,
                'title' => $order->customer->title,
                'contact' => $order->customer->contact,
                'cnic' => $order->customer->cnic,
                'address' => $order->customer->address,
                'ntn' => $order->customer->ntn,
                'strn' => $order->customer->strn,
            ],
            'customerID' => $order->customerID,
            'date' => $order->date,
            'net' => $order->net,
            'wh' => $order->wh,
            'whValue' => $order->whValue,
            'status' => $order->status,
            'notes' => $order->notes,
            'products' => $order->details->map(function ($detail) {
                return [
                    'product_id' => $detail->productID,
                    'product_name' => $detail->product->name,
                    'product_code' => $detail->product->code,
                    'unit_id' => $detail->unit->id,
                    'unit_name' => $detail->unit->name,
                    'unit_value' => $detail->unit->value,
                    'qty' => $detail->qty,
                    'price' => $detail->price,
                    'discount' => $detail->discount,
                    'amount' => $detail->amount,
                    'bonus' => $detail->bonus,
                ];
            }),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $orderData,
        ], 200);
    }

    public function dashboardStats()
    {
        $userId = auth()->user()->id;

        $pending = orders::where('orderbookerID', $userId)
            ->where('status', 'Pending')
            ->count();

        $completed = orders::where('orderbookerID', $userId)
            ->where('status', 'Completed')
            ->count();

        return response()->json([
            'status' => 'success',
            'message' => 'Dashboard stats retrieved successfully',
            'data' => [
                'pending' => $pending,
                'completed' => $completed,
            ],
        ], 200);
    }
}
