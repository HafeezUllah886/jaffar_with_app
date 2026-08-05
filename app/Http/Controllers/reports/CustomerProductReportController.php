<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\sale_details;
use Illuminate\Http\Request;

class CustomerProductReportController extends Controller
{
    public function index()
    {
        $customers = accounts::customer()->get();
        return view('reports.customer_product_report.index', compact('customers'));
    }

    public function data($from, $to, $customer)
    {
        $customer = Accounts::find($customer);

    if (!$customer) {
        return redirect()->back()->with('error', 'Customer not found.');
    }

    $sales = $customer->sale()->whereBetween('date', [$from, $to])->pluck('id'); // Get sale IDs in range

    $salesDetails = sale_details::whereIn('salesID', $sales)
        ->groupBy('productID')
        ->selectRaw('
            productID,
            AVG(price) as avg_price,
            AVG(tp) as avg_tp,
            SUM(qty * unitValue) as total_qty,
            SUM(bonus) as total_bonus,
            SUM(discount) as total_discount,
            SUM(ti) as total_ti,
            SUM(gstValue) as total_gst
        ')
        ->with('product') // Load product relationship
        ->get();



        return view('reports.customer_product_report.details', compact('salesDetails', 'from', 'to', 'customer'));
    }

    public function print($from, $to, $customer)
    {
        $customer = Accounts::find($customer);

        if (!$customer) {
            return redirect()->back()->with('error', 'Customer not found.');
        }

        $sales = $customer->sale()->whereBetween('date', [$from, $to])->pluck('id'); // Get sale IDs in range

        $salesDetails = sale_details::whereIn('salesID', $sales)
            ->groupBy('productID')
            ->selectRaw('productID, AVG(price) as avg_price, AVG(tp) as avg_tp, SUM(qty * unitValue) as total_qty, SUM(bonus) as total_bonus, SUM(discount) as total_discount, SUM(ti) as total_ti, SUM(gstValue) as total_gst')
            ->with('product') // Load product relationship
            ->get();

        return view('reports.customer_product_report.print', compact('salesDetails', 'from', 'to', 'customer'));
    }
}
