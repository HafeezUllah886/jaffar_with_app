<?php
namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\User;
use App\Models\sale_details;
use App\Models\sales;
use Illuminate\Http\Request;

class OrderbookerSalesReport extends Controller
{
    public function index()
    {
        $orderbookers = User::where('role', 'orderbooker')->get();
        return view('reports.orderbooker_sales.index', compact('orderbookers'));
    }

    public function data(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $orderbooker = $request->orderbooker;

        $sales = sales::where('orderbookerID', $orderbooker)->whereBetween('date', [$from, $to])->pluck('id')->toArray();

        $products = sale_details::whereIn('salesID', $sales)->groupBy('productID')->selectRaw('sum(qty) as total_quantity, sum(ti) as total_amount, productID')->get();

        $products = $products->map(function ($product) {
            $product_details = products::where('id', $product->productID)->first();
            $product->name = $product_details->name;
            $product->code = $product_details->code;
            $product->category = $product_details->category->name;
            $product->vendor = $product_details->vendor;
            $product->pack_size = $product_details->volume;
            $product->total_volume = $product->total_quantity * $product->pack_size;
            return $product;
        });

        $orderbooker = User::where('id', $orderbooker)->first();
        return view('reports.orderbooker_sales.details', compact('from', 'to', 'orderbooker', 'products'));
    }
    

    public function print($from, $to, $orderbooker)
    {
        $sales = sales::where('orderbookerID', $orderbooker)->whereBetween('date', [$from, $to])->pluck('id')->toArray();

        $products = sale_details::whereIn('salesID', $sales)->groupBy('productID')->selectRaw('sum(qty) as total_quantity, sum(ti) as total_amount, productID')->get();

        $products = $products->map(function ($product) {
            $product_details = products::where('id', $product->productID)->first();
            $product->name = $product_details->name;
            $product->code = $product_details->code;
            $product->category = $product_details->category->name;
            $product->vendor = $product_details->vendor;
            $product->pack_size = $product_details->volume;
            $product->total_volume = $product->total_quantity * $product->pack_size;
            return $product;
        });

        $orderbooker = User::where('id', $orderbooker)->first();

        return view('reports.orderbooker_sales.print', compact('from', 'to', 'orderbooker', 'products'));
    }
}
