<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\deepFreezerMovement;
use App\Models\deepFreezers;
use App\Models\deepFreezerScan;
use Illuminate\Http\Request;

class DeepFreezerScaneController extends Controller
{
    public function scan(Request $request)
    {
        $code = $request->code;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $freezer = deepFreezers::where('code', $code)->first();
        if ($freezer) {
            if ($freezer->status != 'At Market') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Freezer is In-House',
                    'data' => null,
                ], 404);
            } else {
                $last_movement = deepFreezerMovement::where('deep_freezer_id', $freezer->id)->orderBy('id', 'desc')->first();
                $customer = accounts::find($last_movement->customer_id);
                $distance = getDistance($latitude, $longitude, $customer->lat, $customer->long);
                if ($distance > 100) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Location Mismatch. Distance:  '.$distance.' Meters',
                        'data' => null,
                    ], 404);
                }
                $scan = deepFreezerScan::create(
                    [
                        'deep_freezer_id' => $freezer->id,
                        'user_id' => auth()->user()->id,
                        'scan_time' => now(),
                        'lat' => $latitude,
                        'long' => $longitude,
                        'customer_id' => $customer->id,
                        'customer_lat' => $customer->lat,
                        'customer_long' => $customer->long,
                        'distance' => getDistance($latitude, $longitude, $customer->lat, $customer->long),
                    ]
                );

                return response()->json([
                    'status' => 'success',
                    'message' => 'Freezer scanned successfully',
                    'data' => $scan,
                ], 200);
            }

        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Freezer not found',
                'data' => null,
            ], 404);
        }
    }

    public function index()
    {
        $scans = deepFreezerScan::with('deepFreezer')->where('user_id', auth()->user()->id)->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Scans retrieved successfully',
            'data' => $scans,
        ], 200);
    }
}
