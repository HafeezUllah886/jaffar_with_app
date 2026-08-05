<?php

namespace App\Http\Controllers;

use App\Models\deliveryman;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliverymanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliverymen = deliveryman::all();
        return view('deliveryman.index', compact('deliverymen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $deliveryman = new deliveryman();
        $deliveryman->name = $request->name;
        $deliveryman->contact = $request->contact;
        $deliveryman->save();
        return redirect()->route('deliveryman.index')->with('success', 'Delivery Man created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(deliveryman $deliveryman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deliveryman $deliveryman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, deliveryman $deliveryman)
    {
        $deliveryman->name = $request->name;
        $deliveryman->contact = $request->contact;
        $deliveryman->save();

        return redirect()->route('deliveryman.index')->with('success', 'Delivery Man Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deliveryman $deliveryman)
    {
        //
    }
}
