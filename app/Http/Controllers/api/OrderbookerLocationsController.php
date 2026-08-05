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
            'locations' => 'required|array|min:1',
            'locations.*.latitude' => 'required|numeric',
            'locations.*.longitude' => 'required|numeric',
            'locations.*.time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 422);
        }

        try {

            foreach ($request->locations as $location) {
                OrderbookerLocations::create(
                    [
                        'latitude' => $location['latitude'],
                        'longitude' => $location['longitude'],
                        'date' => date('Y-m-d'),
                        'time' => date('H:i:s'),
                        'userID' => auth()->id(),
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Location stored successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
