<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\deepFreezerMovement;
use App\Models\deepFreezers;
use Illuminate\Http\Request;

class DeepFreezerMovementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = deepFreezerMovement::with('deep_freezer', 'customer')->orderBy('id', 'desc')->get();

        return view('deep_freezer_movements.index', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = accounts::Customer()->get();
        $freezers = deepFreezers::all();

        return view('deep_freezer_movements.create', compact('customers', 'freezers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $movement = deepFreezerMovement::create([
            'customer_id' => $request->customer_id,
            'deep_freezer_id' => $request->deep_freezer_id,
            'vehicleNo' => $request->vehicleNo,
            'driver' => $request->driver,
            'doc_no' => $request->doc_no,
            'date' => $request->date,
            'type' => $request->type,
            'reason' => $request->reason,
            'remarks' => $request->remarks,
        ]);

        $freezer = deepFreezers::find($request->deep_freezer_id);
        if ($request->type == 'Issue') {
            $freezer->update(['status' => 'At Market']);
        } elseif ($request->type == 'Collect') {
            $freezer->update(['status' => 'In-House']);
        }

        return redirect()->route('deep_freezer_movements.index')->with('success', 'Movement Recorded');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    public function print($id)
    {
        $movement = deepFreezerMovement::with('deep_freezer', 'customer')->findOrFail($id);

        return view('deep_freezer_movements.print', compact('movement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
