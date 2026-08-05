<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\categories;
use App\Models\products;
use App\Models\purchase;
use App\Models\purchase_details;
use Illuminate\Http\Request;

class purchaseProductsReportController extends Controller
{
    public function index()
    {
        $categories = categories::all();
        return view('reports.purchaseProducts.index', compact('categories'));
    }

    public function data($from, $to, $catID)
    {
        if($catID == 'all')
        {
            $products = products::all();
        }
        else
        {
            $products = products::where('catID', $catID)->get();
        }

       foreach($products as $product)
       {
            $qty = purchase_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('qty');
            $bonus = purchase_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('bonus');
            $product->qty = $qty;
            $product->bonus = $bonus;
            $product->tVolume = $qty * $product->volume;
            $product->price = avgPurchasePrice($from,$to,$product->id);
       }

        return view('reports.purchaseProducts.details', compact('from', 'to', 'products', 'catID'));
    }

    public function print($from, $to, $catID)
    {
        if($catID == 'All')
        {
            $products = products::all();
        }
        else
        {
            $products = products::where('catID', $catID)->get();
        }

       foreach($products as $product)
       {
            $qty = purchase_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('qty');
            $bonus = purchase_details::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('bonus');
            $product->qty = $qty;
            $product->bonus = $bonus;
            $product->price = avgPurchasePrice($from,$to,$product->id);
       }

        return view('reports.purchaseProducts.print', compact('from', 'to', 'products'));
    }
}
