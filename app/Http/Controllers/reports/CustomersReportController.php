<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    public function index()
    {
        $accounts = accounts::Customer()->where('id', '!=', 2)->get();

        return view('reports.customersReport.details', compact('accounts'));
    }

    public function print()
    {
        $accounts = accounts::Customer()->where('id', '!=', 2)->get();

        return view('reports.customersReport.print', compact('accounts'));
    }
}
