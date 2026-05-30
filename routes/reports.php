<?php

use App\Http\Controllers\reports\DeliverymanReportController;
use App\Http\Controllers\reports\profitController;
use App\Http\Controllers\reports\balanceSheetReport;
use App\Http\Controllers\reports\comparisonReportController;
use App\Http\Controllers\reports\customerBalanceReportController;
use App\Http\Controllers\reports\CustomerProductReportController as ReportsCustomerProductReportController;
use App\Http\Controllers\reports\CustomersReportController;
use App\Http\Controllers\reports\dailycashbookController;
use App\Http\Controllers\reports\loadsheetController;
use App\Http\Controllers\reports\OrderbookerReportController;
use App\Http\Controllers\reports\OrderbookerSalesReport;
use App\Http\Controllers\reports\productSummaryReport;
use App\Http\Controllers\reports\purchaseGstReportController;
use App\Http\Controllers\reports\purchaseProductsReportController;
use App\Http\Controllers\reports\purchaseReportController;
use App\Http\Controllers\reports\saleProductsReportController;
use App\Http\Controllers\reports\salesGstReportController;
use App\Http\Controllers\reports\salesManReportController;
use App\Http\Controllers\reports\salesReportController;
use App\Http\Controllers\reports\salesWHTReportController as ReportsSalesWHTReportController;
use App\Http\Controllers\reports\stockMovementReportController;
use App\Http\Controllers\reports\TransporterReportController;
use App\Http\Controllers\salesWHTReportController;
use App\Http\Middleware\adminCheck;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', adminCheck::class)->group(function () {

    Route::get('/reports/profit', [profitController::class, 'index'])->name('reportProfit');
    Route::get('/reports/profitData/{from}/{to}', [profitController::class, 'data'])->name('reportProfitData');
    Route::get('/reports/profitPrint/{from}/{to}', [profitController::class, 'print'])->name('reportProfitPrint');

    Route::get('/reports/loadsheet', [loadsheetController::class, 'index'])->name('reportLoadsheet');
    Route::get('/reports/loadsheetData', [loadsheetController::class, 'data'])->name('reportLoadsheetData');

    Route::get('/reports/salesGst', [salesGstReportController::class, 'index'])->name('reportSalesGst');
    Route::get('/reports/salesGstData/{from}/{to}', [salesGstReportController::class, 'data'])->name('reportSalesGstData');
    Route::get('/reports/salesGstPrint/{from}/{to}', [salesGstReportController::class, 'print'])->name('reportSalesGstPrint');

    Route::get('/reports/salesWHT', [ReportsSalesWHTReportController::class, 'index'])->name('reportSalesWHT');
    Route::get('/reports/salesWHTData/{from}/{to}', [ReportsSalesWHTReportController::class, 'data'])->name('reportSalesWHTData');
    Route::get('/reports/salesWHTPrint/{from}/{to}', [ReportsSalesWHTReportController::class, 'print'])->name('reportSalesWHTPrint');

    Route::get('/reports/purchasesGst', [purchaseGstReportController::class, 'index'])->name('reportPurchasesGst');
    Route::get('/reports/purchasesGstData/{from}/{to}', [purchaseGstReportController::class, 'data'])->name('reportPurchasesGstData');
    Route::get('/reports/purchasesGstPrint/{from}/{to}', [purchaseGstReportController::class, 'print'])->name('reportPurchasesGstPrint');

    Route::get('/reports/purchaseProducts', [purchaseProductsReportController::class, 'index'])->name('reportPurchaseProducts');
    Route::get('/reports/purchaseProductsData/{from}/{to}/{catID}', [purchaseProductsReportController::class, 'data'])->name('reportPurchaseProductsData');
    Route::get('/reports/purchaseProductsPrint/{from}/{to}/{catID}', [purchaseProductsReportController::class, 'print'])->name('reportPurchaseProductsPrint');

    Route::get('/reports/saleProducts', [saleProductsReportController::class, 'index'])->name('reportSaleProducts');
    Route::get('/reports/saleProductsData/{from}/{to}', [saleProductsReportController::class, 'data'])->name('reportSaleProductsData');
    Route::get('/reports/saleProductsPrint/{from}/{to}', [saleProductsReportController::class, 'print'])->name('reportSaleProductsPrint');

    Route::get('/reports/productSummary', [productSummaryReport::class, 'index'])->name('reportProductSummary');
    Route::get('/reports/productSummaryPrint', [productSummaryReport::class, 'print'])->name('reportProductSummaryPrint');

    Route::get('/reports/customersBalance', [customerBalanceReportController::class, 'index'])->name('reportCustomersBalance');
    Route::get('/reports/customersBalancePrint', [customerBalanceReportController::class, 'print'])->name('reportCustomersBalancePrint');

    Route::get('/reports/customersReport', [CustomersReportController::class, 'index'])->name('reportCustomersReport');
    Route::get('/reports/customersReportPrint', [CustomersReportController::class, 'print'])->name('reportCustomersReportPrint');

    Route::get('/reports/sales', [salesReportController::class, 'index'])->name('reportSales');
    Route::get('/reports/salesData/{from}/{to}/{type}', [salesReportController::class, 'data'])->name('reportSalesData');
    Route::get('/reports/salesPrint/{from}/{to}/{type}', [salesReportController::class, 'print'])->name('reportSalesPrint');

    Route::get('/reports/purchases', [purchaseReportController::class, 'index'])->name('reportPurchases');
    Route::get('/reports/purchasesData/{from}/{to}', [purchaseReportController::class, 'data'])->name('reportPurchasesData');
    Route::get('/reports/purchasesPrint/{from}/{to}', [purchaseReportController::class, 'print'])->name('reportPurchasesPrint');

    Route::get('/reports/dailycashbook', [dailycashbookController::class, 'index'])->name('reportCashbook');
    Route::get('/reports/dailycashbook/{date}', [dailycashbookController::class, 'details'])->name('reportCashbookData');

    Route::get('/reports/balanceSheet', [balanceSheetReport::class, 'index'])->name('reportBalanceSheet');
    Route::get('/reports/balanceSheet/{type}/{from}/{to}', [balanceSheetReport::class, 'data'])->name('reportBalanceSheetData');
    Route::get('/reports/balanceSheetPrint/{type}/{from}/{to}', [balanceSheetReport::class, 'print'])->name('reportBalanceSheetPrint');

    Route::get('/reports/comparison', [comparisonReportController::class, 'index'])->name('reportComparison');
    Route::get('/reports/comparison/{from1}/{to1}/{from2}/{to2}/{customer}', [comparisonReportController::class, 'data'])->name('reportComparisonData');
    Route::get('/reports/comparisonPrint/{from1}/{to1}/{from2}/{to2}/{customer}', [comparisonReportController::class, 'print'])->name('reportComparisonPrint');

    Route::get('/reports/customer_products', [ReportsCustomerProductReportController::class, 'index'])->name('reportCustomerProducts');
    Route::get('/reports/customer_products/details/{from}/{to}/{customer}', [ReportsCustomerProductReportController::class, 'data'])->name('reportCustomerProductsData');
    Route::get('/reports/customer_products/print/{from}/{to}/{customer}', [ReportsCustomerProductReportController::class, 'print'])->name('reportCustomerProductsPrint');

    Route::get('/reports/orderbooker', [OrderbookerReportController::class, 'index'])->name('reportOrderbooker');
    Route::get('/reports/orderbooker/details/{from}/{to}/{orderbooker}', [OrderbookerReportController::class, 'data'])->name('reportOrderbookerData');
    Route::get('/reports/orderbooker/print/{from}/{to}/{orderbooker}', [OrderbookerReportController::class, 'print'])->name('reportOrderbookerPrint');

    Route::get('/reports/orderbooker_sales', [OrderbookerSalesReport::class, 'index'])->name('reportOrderbookerSales');
    Route::get('/reports/orderbooker_sales/details/{from}/{to}/{orderbooker}', [OrderbookerSalesReport::class, 'data'])->name('reportOrderbookerSalesData');
    Route::get('/reports/orderbooker_sales/print/{from}/{to}/{orderbooker}', [OrderbookerSalesReport::class, 'print'])->name('reportOrderbookerSalesPrint');

    Route::get('/reports/transporter', [TransporterReportController::class, 'index'])->name('reportTransporter');
    Route::get('/reports/transporterData/{from}/{to}/{transporter}', [TransporterReportController::class, 'data'])->name('reportTransporterData');
    Route::get('/reports/transporterPrint/{from}/{to}/{transporter}', [TransporterReportController::class, 'print'])->name('reportTransporterPrint');

    Route::get('/reports/deliveryman', [DeliverymanReportController::class, 'index'])->name('reportDeliveryman');
    Route::get('/reports/deliverymanData/{from}/{to}/{deliveryman}', [DeliverymanReportController::class, 'data'])->name('reportDeliverymanData');
    Route::get('/reports/deliverymanPrint/{from}/{to}/{deliveryman}', [DeliverymanReportController::class, 'print'])->name('reportDeliverymanPrint');

    Route::get('/reports/stockmovementreport', [stockMovementReportController::class, 'index'])->name('reportStockMovement');
    Route::get('/reports/stockmovementreportData', [stockMovementReportController::class, 'data'])->name('reportStockMovementData');
});
