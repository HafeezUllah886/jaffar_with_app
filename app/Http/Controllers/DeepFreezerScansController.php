<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\deepFreezerScan;
use App\Models\User;
use Illuminate\Http\Request;

class DeepFreezerScansController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->from_date ?? date('Y-m-d');
        $toDate = $request->to_date ?? date('Y-m-d');

        $query = deepFreezerScan::with(['deepFreezer', 'user', 'customer'])->whereBetween('scan_time', [$fromDate, $toDate]);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $scans = $query->get();

        $orderbookers = User::where('role', 'Orderbooker')->get();
        $customers = accounts::where('type', 'Customer')->get();

        return view('deep_freezer_scans.index', compact('scans', 'orderbookers', 'customers'));
    }
}
