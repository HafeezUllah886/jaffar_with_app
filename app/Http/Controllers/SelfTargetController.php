<?php

namespace App\Http\Controllers;

use App\Models\SelfTarget;
use App\Http\Controllers\Controller;
use App\Models\accounts;
use App\Models\categories;
use App\Models\products;
use App\Models\SelfTagetDetails;
use App\Models\SelfTargetDetails;
use App\Models\units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SelfTargetController extends Controller
{
    public function index()
    {
        $targets = SelfTarget::orderBy("endDate", 'desc')->get();
        foreach($targets as $target)
        {
            $totalTarget = 0;
            $totalSold = 0;
            
           foreach($target->details as $product)
           {
                $qtySold = DB::table('purchases')
                ->join('purchase_details', 'purchases.id', '=', 'purchase_details.purchaseID')
                ->where('purchases.vendorID', $target->vendorID)  // Filter by customer ID
                ->where('purchase_details.productID', $product->productID)  // Filter by product ID
                ->whereBetween('purchase_details.date', [$target->startDate, $target->endDate])  // Filter by date range
                ->sum('purchase_details.qty');
                $product->sold = $qtySold;
                $targetQty = $product->qty;

                if($qtySold > $targetQty)
                {
                    $qtySold = $targetQty;
                }
                $product->per = $qtySold / $targetQty * 100;
               

                $totalTarget += $targetQty;
                $totalSold += $qtySold;
           }
           $totalPer = $totalSold / $totalTarget  * 100;
           $target->totalPer = $totalPer;

            if($target->endDate > now())
            {

                $target->campain = "Open";
                $target->campain_color = "success";
            }
            else
            {
                $target->campain = "Closed";
                $target->campain_color = "warning";
            }

            if($totalPer >= 100)
            {
                $target->goal = "Target Achieved";
                $target->goal_color = "success";
            }
            elseif($target->endDate > now() && $totalPer < 100)
            {
                $target->goal = "In Progress";
                $target->goal_color = "info";
            }
            else
            {
                $target->goal = "Not Achieved";
                $target->goal_color = "danger";
            }
        }
        return view('self_target.index', compact('targets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $vendors = accounts::vendor()->get();
        $categories = categories::all();
        return view('self_target.create', compact('categories', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $target = SelfTarget::create(
                [
                    'vendorID'    => $request->vendorID,
                    'startDate'     => $request->startDate,
                    'endDate'       => $request->endDate,
                    'notes'         => $request->notes,
                ]
            );

            $ids = $request->id;

            foreach($ids as $key => $id)
            {
                $unit = units::find($request->unit[$key]);
                $qty = $request->qty[$key] * $unit->value;
                SelfTargetDetails::create(
                    [
                        'targetID'      => $target->id,
                        'productID'     => $id,
                        'qty'           => $qty,
                        'unitID'        => $unit->id,
                    ]
                );
            }
            DB::commit();
            return back()->with("success", "Target Saved");
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return back()->with("error", $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $target = SelfTarget::find($id);
       
            $totalTarget = 0;
            $totalSold = 0;
            
           foreach($target->details as $product)
           {
                $qtySold = DB::table('purchases')
                ->join('purchase_details', 'purchases.id', '=', 'purchase_details.purchaseID')
                ->where('purchases.vendorID', $target->vendorID)  // Filter by customer ID
                ->where('purchase_details.productID', $product->productID)  // Filter by product ID
                ->whereBetween('purchase_details.date', [$target->startDate, $target->endDate])  // Filter by date range
                ->sum('purchase_details.qty');
                
                $targetQty = $product->qty;

                if($qtySold > $targetQty)
                {
                    $qtySold = $targetQty;
                }
                $product->sold = $qtySold;
                $product->per = $qtySold / $targetQty * 100;

                $totalTarget += $targetQty;
                $totalSold += $qtySold;
           }
           $totalPer = $totalSold / $totalTarget * 100;
           $target->totalPer = $totalPer;

            if($target->endDate > now())
            {

                $target->campain = "Open";
                $target->campain_color = "success";
            }
            else
            {
                $target->campain = "Closed";
                $target->campain_color = "warning";
            }

            if($totalPer >= 100)
            {
                $target->goal = "Target Achieved";
                $target->goal_color = "success";
            }
            elseif($target->endDate > now() && $totalPer < 100)
            {
                $target->goal = "In Progress";
                $target->goal_color = "info";
            }
            else
            {
                $target->goal = "Not Achieved";
                $target->goal_color = "danger";
            }
        return view('self_target.view', compact('target'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(targets $targets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, targets $targets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $target = SelfTarget::find($id);
        $target->details()->delete();
        $target->delete();
        session()->forget('confirmed_password');
        return to_route('self_targets.index')->with("success", "Target Deletes");
    }

    public function getcat($id)
    {
        $category = categories::find($id);
        
        return $category;
    }

}
