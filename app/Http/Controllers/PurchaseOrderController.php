<?php

namespace App\Http\Controllers;

use App\Models\purchase_order;
use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\products;
use App\Models\purchase_order_details;
use App\Models\units;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start = $request->start ?? now()->toDateString();
        $end = $request->end ?? now()->toDateString();

        $orders = purchase_order::whereBetween("date", [$start, $end])->orderby('id', 'desc')->get();
        return view('purchase_order.index', compact('orders', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = products::orderby('name', 'asc')->get();
        $units = units::all();
        $vendors = accounts::vendor()->get();
        return view('purchase_order.create', compact('products', 'units', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try
        {
            if($request->isNotFilled('id'))
            {
                throw new Exception('Please Select Atleast One Product');
            }
            DB::beginTransaction();
            $ref = getRef();
            $order = purchase_order::create(
                [
                  'vendorID'        => $request->vendorID,
                  'date'            => $request->date,
                  'notes'           => $request->notes,
                ]
            );

            $ids = $request->id;

            $total = 0;
            foreach($ids as $key => $id)
            {
                $unit = units::find($request->unit[$key]);
                $qty = ($request->qty[$key] * $unit->value);
                $price = $request->price[$key];
                $amount = $price * $qty;
                $total += $amount;

                purchase_order_details::create(
                    [
                        'orderID'       => $order->id,
                        'productID'     => $id,
                        'price'         => $price,
                        'qty'           => $qty,
                        'amount'        => $amount,
                        'unitID'        => $unit->id,
                        'unitValue'     => $unit->value,
                    ]
                );
            }

            $order->update(
                [
                    'net'       => $total,
                ]
            );
            DB::commit();
            return back()->with('success', "Purchase Order Created");

        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = purchase_order::findOrFail($id);
        return view('purchase_order.view', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = purchase_order::findOrFail($id);
        $products = products::orderby('name', 'asc')->get();
        $units = units::all();
        $vendors = accounts::vendor()->get();
        return view('purchase_order.edit', compact('products', 'units', 'vendors', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try
        {
            if($request->isNotFilled('id'))
            {
                throw new Exception('Please Select Atleast One Product');
            }
            DB::beginTransaction();
            $order = purchase_order::findOrFail($id);
            $order->details()->delete();

            $order->update(
                [
                    'vendorID'        => $request->vendorID,
                    'date'            => $request->date,
                    'notes'           => $request->notes,
                  ]
            );

            $ids = $request->id;

            $total = 0;
            dashboard();
            foreach($ids as $key => $id)
            {
                $unit = units::find($request->unit[$key]);
                $qty = $request->qty[$key] * $unit->value;
                $price = $request->price[$key];
                $amount = $price * $qty;
                $total += $amount;

                purchase_order_details::create(
                    [
                        'orderID'       => $order->id,
                        'productID'     => $id,
                        'price'         => $price,
                        'qty'           => $qty,
                        'amount'        => $amount,
                        'unitID'        => $unit->id,
                        'unitValue'     => $unit->value,
                    ]
                );
            }


            $order->update(
                [
                    'net'       => $total,
                ]
            );
            DB::commit();
            return back()->with('success', "Purchase Order Updated");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try
        {
            DB::beginTransaction();
            $order = purchase_order::findOrFail($id);
           
            $order->details()->delete();
            $order->delete();
            DB::commit();
            session()->forget('confirmed_password');
            return redirect()->route('purchase_order.index')->with('success', "Purchase Order Deleted");
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            session()->forget('confirmed_password');
            return redirect()->route('purchase_order.index')->with('error', $e->getMessage());
        }
    }
}
