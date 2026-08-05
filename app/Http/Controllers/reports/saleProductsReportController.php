<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\sale_details;

class saleProductsReportController extends Controller
{
    public function index()
    {
        return view('reports.saleProducts.index');
    }
    public function data($from, $to)
    {
       $products = products::all();

       foreach($products as $product)
       {
            $qty = sale_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('qty');
            $bonus = sale_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('bonus');
            $product->qty = $qty;
            $product->bonus = $bonus;
            $product->tVolume = $qty * $product->volume;
            $product->price = avgSalePrice($from,$to,$product->id);
       }
        return view('reports.saleProducts.details', compact('from', 'to', 'products'));
    }
    public function print($from, $to)
    {
        $products = products::all();

        foreach($products as $product)
        {
            $qty = sale_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('qty');
            $bonus = sale_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('bonus');
            $product->qty = $qty;
            $product->bonus = $bonus;
            $product->price = avgSalePrice($from,$to,$product->id);
        }

        return view('reports.saleProducts.print', compact('from', 'to', 'products'));
    }
}
