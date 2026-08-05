<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\purchase;
use App\Models\transporter;
use Illuminate\Http\Request;

class TransporterReportController extends Controller
{
    public function index()
    {
        $transporters = transporter::all();
        return view('reports.transporter.index', compact('transporters'));
    }

    public function data($from, $to, $transporter)
    {
        $transporter = transporter::find($transporter);
        $purchases = purchase::where('transporterID', $transporter->id)->whereBetween('date', [$from, $to])->get();
        return view('reports.transporter.details', compact('purchases', 'from', 'to', 'transporter'));
    }
    
    public function print($from, $to, $transporter)
    {
        $transporter = transporter::find($transporter);
        $purchases = purchase::where('transporterID', $transporter->id)->whereBetween('date', [$from, $to])->get();
        return view('reports.transporter.print', compact('purchases', 'from', 'to', 'transporter'));
    }
}
