<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\products;
use App\Models\units;
use Illuminate\Http\Request;

class NonFinancialInfoController extends Controller
{
    public function products(Request $request)
    {
        $products = products::all();
        foreach ($products as $product) {
            $product->stock = getStock($product->id);
        }

        return response()->json([
            'products' => $products,
        ]);
    }

    public function units()
    {
        $units = units::all();

        return response()->json([
            'units' => $units,
        ]);
    }
}
