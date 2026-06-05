<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderbookerLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderbookerLocationsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
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
