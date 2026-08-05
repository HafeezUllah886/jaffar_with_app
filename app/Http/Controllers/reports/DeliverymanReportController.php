<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\deliveryman;
use App\Models\sales;
use Illuminate\Http\Request;

class DeliverymanReportController extends Controller
{
    public function index()
    {
        $deliverymen = deliveryman::all();

        return view('reports.deliveryman.index', compact('deliverymen'));
    }

    public function data($from, $to, $deliveryman)
    {
        $sales = sales::where('deliverymanID', $deliveryman)->whereBetween('date', [$from, $to])->get();
        $deliveryman = deliveryman::find($deliveryman);

        return view('reports.deliveryman.details', compact('from', 'to', 'deliveryman', 'sales'));
    }

    public function print($from, $to, $deliveryman)
    {
        $sales = sales::where('deliverymanID', $deliveryman)->whereBetween('date', [$from, $to])->get();
        $deliveryman = deliveryman::find($deliveryman);

        return view('reports.deliveryman.print', compact('from', 'to', 'deliveryman', 'sales'));
    }
}
