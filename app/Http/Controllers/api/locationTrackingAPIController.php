<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderbookerLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class locationTrackingAPIController extends Controller
{
    public function storeLocation(Request $request)
    {
        /* $validator = Validator::make($request->all(), [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        } */

        foreach ($request->locations as $location) {
            OrderbookerLocations::create(
                [
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'date' => date('Y-m-d', strtotime($location['time'])),
                    'time' => date('H:i:s', strtotime($location['time'])),
                    'userID' => auth()->id(),
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Location stored successfully',
        ], 200);

    }
}
