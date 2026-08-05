<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\branches;
use App\Models\obsolete_stock;
use App\Models\products;
use App\Models\purchase;
use App\Models\purchase_details;
use App\Models\returnsDetails;
use App\Models\sale_details;
use App\Models\stock;
use App\Models\stockAdjustment;
use App\Models\warehouses;
use Illuminate\Http\Request;

class stockMovementReportController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.stockMovement.index');
    }

    public function data(Request $request)
    {
        $from = $request->from ?? firstDayOfMonth();
        $to = $request->to ?? now();
     
        $products = products::all();

        foreach($products as $product){

            $opening_stock = stock::where('productID', $product->id)->where('date', '<', $from)->sum('cr') - stock::where('productID', $product->id)->where('date', '<', $from)->sum('db');
            
            $credit = stock::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('cr');
            $debit = stock::where('productID', $product->id)->whereBetween('date', [$from, $to])->sum('db');

            $closing_stock = $opening_stock + $credit - $debit;
            $current_stock = getStock($product->id);
            $current_value = productStockValue($product->id);
            if($current_stock > 0){
                $value_per_pc = $current_value / $current_stock;
                $closing_value = $closing_stock * $value_per_pc;
            }else{
                $value_per_pc = 0;
                $closing_value = 0;
            }

            $product->opening_stock = $opening_stock;
            $product->stock_in = $credit;
            $product->stock_out = $debit;
            $product->closing_stock = $closing_stock;
            $product->current_stock = $current_stock;
            $product->current_value = $current_value;
            $product->closing_value = $closing_value;
        }
        return view('reports.stockMovement.details', compact('products', 'from', 'to'));
    }
}
