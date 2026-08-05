<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\products;
use App\Models\sale_details;
use Illuminate\Http\Request;

class customerBalanceReportController extends Controller
{
    public function index()
    {
        $accounts = accounts::Customer()->get();

        foreach($accounts as $account)
        {
          $account->balance = getAccountBalance($account->id);
        }

        return view('reports.customerBalances.details', compact('accounts'));
    }

    public function print()
    {
        $accounts = accounts::Customer()->get();

        foreach($accounts as $account)
        {
          $account->balance = getAccountBalance($account->id);
        }

        return view('reports.customerBalances.print', compact('accounts'));
    }


}
