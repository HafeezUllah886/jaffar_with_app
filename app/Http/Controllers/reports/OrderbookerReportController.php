<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\sales;
use App\Models\User;
use Illuminate\Http\Request;

class OrderbookerReportController extends Controller
{
    public function index()
    {
        $orderbookers = User::where('role', 'orderbooker')->get();
        return view('reports.orderbooker.index', compact('orderbookers'));
    }

    public function data(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $orderbooker = $request->orderbooker;

        $sales = sales::with('details')->where('orderbookerID', $orderbooker)->whereBetween('date', [$from, $to])->get();

        $orderbooker = User::where('id', $orderbooker)->first();
        return view('reports.orderbooker.details', compact('from', 'to', 'orderbooker', 'sales'));
    }
}
