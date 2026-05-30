<?php

namespace App\Http\Controllers;

use App\Models\orderbooker_target;
use App\Http\Controllers\Controller;
use App\Models\sale_details;
use App\Models\sales;
use App\Models\User;
use Illuminate\Http\Request;

class OrderbookerTargetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->status ?? "Pending";
        $orderbookerID = $request->orderbookerID ?? User::where('role', 'Orderbooker')->first()->id;
      $target = orderbooker_target::query();
      if($status != "All")
      {
        $target->where('status', $status);
      }
      if($orderbookerID != "All")
      {
        $target->where('orderbookerID', $orderbookerID);
      }
      $targets = $target->get();
        $orderbookers = User::where('role', 'Orderbooker')->get();

        foreach($targets as $target)
        {
            $sales = sales::with('details')->where('orderbookerID', $target->orderbookerID)->whereBetween('date', [$target->start_date, $target->end_date])->pluck('id')->toArray();
            $details = sale_details::whereIn('salesID', $sales)->get();
            $total_ltrs = 0;
            foreach($details as $detail)
            {
                $qty = $detail->qty;
                $ltr = $detail->product->volume / 1000;

                $total_ltrs += $qty * $ltr;
            }



            if($total_ltrs >= $target->target)
            {
                $target->status = "Completed";
            }
            else
            {
                $target->status = "Pending";
            }

            if($total_ltrs < $target->target && $target->end_date < date('Y-m-d'))
            {
                $target->status = "Failed";
            }
            $target->save();

            $target->achieved = $total_ltrs;
        }
        
        return view('orderbooker_target.index', compact('targets', 'orderbookers', 'status', 'orderbookerID'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'orderbookerID' => 'required',
            'target' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);
        orderbooker_target::create(
            [
                'orderbookerID' => $request->orderbookerID,
                'target' => $request->target,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
            ]
        );
        return redirect()->back()->with('success', 'Target created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(orderbooker_target $orderbooker_target)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orderbooker_target $orderbooker_target)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, orderbooker_target $orderbooker_target)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $orderbooker_target = orderbooker_target::find($id);
        $orderbooker_target->delete();
        session()->forget('confirmed_password');
        return to_route('orderbooker_targets.index')->with("success", "Target Deletes");
    }
}
