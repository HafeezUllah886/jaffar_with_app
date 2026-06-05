<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderbookerLocations;
use Illuminate\Http\Request;

class OrderbookerLocationsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $orderbookerLocation = OrderbookerLocations::create([
            'userID' => $request->user()->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,

        ]);

        return response()->json([
            'message' => 'Orderbooker location created successfully',
            'orderbookerLocation' => $orderbookerLocation,
        ], 200);
    }
}
