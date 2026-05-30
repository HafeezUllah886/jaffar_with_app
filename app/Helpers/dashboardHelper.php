<?php

use App\Models\accounts;
use App\Models\purchase;
use App\Models\purchase_details;
use App\Models\sale_details;

function totalSales()
{
    return $sales = round(sale_details::sum('ti'));
}

function totalPurchases()
{
    return round(purchase::sum('net'));
}

function totalSaleGst()
{
    return round(sale_details::sum('gstValue'));
}

function totalPurchaseGst()
{
    return round(purchase_details::sum('gstValue'));
}

function myBalance()
{
    $accounts = accounts::where('type', '!=', 'Customer')->get();
    $balance = 0;
    foreach ($accounts as $account) {
        $balance += getAccountBalance($account->id);
    }

    $customers = accounts::where('type', 'Customer')->get();
    $customersBalance = 0;
    foreach ($customers as $customer) {
        $customersBalance += getAccountBalance($customer->id);
    }

    $accountsBalance = $balance - $customersBalance;
    $stockValue = stockValue();
    $balance = $accountsBalance + $stockValue;

    return round($balance);
}
