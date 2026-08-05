<?php

namespace App\Http\Controllers;

use App\Models\deepFreezers;
use Illuminate\Http\Request;

class DeepFreezersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deep_freezers = deepFreezers::all();
        return view('deep_freezer.index', compact('deep_freezers'));
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
        deepFreezers::create(
            [
                'code' => $request->code,
                'type' => $request->type,
                'size' => $request->size,
                'status' => 'Available', // Or whichever status is appropriate
            ]
        );
        return back()->with('success', 'Deep Freezer Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(deepFreezers $deepFreezers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deepFreezers $deepFreezers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $deepFreezer = deepFreezers::find($id);
        $deepFreezer->update(
            [
                'code' => $request->code,
                'type' => $request->type,
                'size' => $request->size,
            ]
        );
        return back()->with('success', 'Deep Freezer Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deepFreezers $deepFreezers)
    {
        //
    }
}
