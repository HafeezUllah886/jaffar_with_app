<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\sales;
use Illuminate\Http\Request;

class salesWHTReportController extends Controller
{
    public function index()
    {
        return view('reports.salesWHT.index');
    }

    public function data($from, $to)
    {
        $sales = sales::with('customer', 'details')->whereBetween('date', [$from, $to])->get();

        foreach($sales as $sale)
        {
            $totalRP = 0;
            foreach($sale->details as $product)
            {
                $totalRP += ($product->qty + $product->bonus) * $product->tp;
            }
            $sale->totalBill = $totalRP;
        }

        return view('reports.salesWHT.details', compact('from', 'to', 'sales'));
    }

    public function print($from, $to)
    {
        $sales = sales::with('customer', 'details')->whereBetween('date', [$from, $to])->get();

        foreach($sales as $sale)
        {
            $totalRP = 0;
            foreach($sale->details as $product)
            {
                $totalRP += ($product->qty + $product->bonus) * $product->tp;
            }
            $sale->totalBill = $totalRP;
        }

        return view('reports.salesWHT.print', compact('from', 'to', 'sales'));
    }
}
