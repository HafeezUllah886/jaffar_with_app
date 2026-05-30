<?php

namespace App\Http\Controllers;

use App\Models\transporter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransporterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transporters = transporter::all();
        return view('transporter.index', compact('transporters'));
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
        $transporter = new transporter();
        $transporter->name = $request->name;
        $transporter->contact = $request->contact;
        $transporter->address = $request->address;
        $transporter->save();
        return redirect()->route('transporter.index')->with('success', 'Transporter created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(transporter $transporter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transporter $transporter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transporter $transporter)
    {
        $transporter->name = $request->name;
        $transporter->contact = $request->contact;
        $transporter->address = $request->address;
        $transporter->save();
        return redirect()->route('transporter.index')->with('success', 'Transporter updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transporter $transporter)
    {
        //
    }
}
