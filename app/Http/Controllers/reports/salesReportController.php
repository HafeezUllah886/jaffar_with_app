<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\sales;
use Illuminate\Http\Request;

class salesReportController extends Controller
{
    public function index()
    {
        return view('reports.sales.index');
    }

    public function data($from, $to, $type)
    {
        if($type == "All")
        {
            $sales = sales::with('customer', 'details')->whereBetween('date', [$from, $to])->get();
        }
        else
        {
            $customers = accounts::where('type', 'Customer')->where('c_type', $type)->pluck('id')->toArray();
            $sales = sales::with('customer', 'details')->whereIn('customerID', $customers)->whereBetween('date', [$from, $to])->get();
        }

        
        foreach($sales as $sale)
        {
            $pdiscount = 0;
            foreach($sale->details as $detail)
            {
                $pdiscount += $detail->discount * $detail->qty;
            }
            $sale->pdiscount = $pdiscount;
        }


        return view('reports.sales.details', compact('from', 'to', 'sales', 'type'));
    }

    public function print($from, $to, $type)
    {
        if($type == "All")
        {
            $sales = sales::with('customer', 'details')->whereBetween('date', [$from, $to])->get();
        }
        else
        {
            $customers = accounts::where('type', 'Customer')->where('c_type', $type)->pluck('id')->toArray();
            $sales = sales::with('customer', 'details')->whereIn('customerID', $customers)->whereBetween('date', [$from, $to])->get();
        }

        
        foreach($sales as $sale)
        {
            $pdiscount = 0;
            foreach($sale->details as $detail)
            {
                $pdiscount += $detail->discount * $detail->qty;
            }
            $sale->pdiscount = $pdiscount;
        }

        return view('reports.sales.print', compact('from', 'to', 'sales'));
    }
}
