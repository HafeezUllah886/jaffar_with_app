<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrderbookerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderbookers = User::where('role', 'Orderbooker')->get();
        return view('orderbookers.index', compact('orderbookers'));
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
        $request->validate(
            [
                'name' => 'required|unique:users,name',
                'email' => 'required|unique:users,email'
            ]
        );

        User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'password' => Hash::make($request->password),
                'role' => "Orderbooker"
            ]
        );

        return back()->with('success', "Orderbooker Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|unique:users,name,'.$id,
                'email' => 'required|unique:users,email,'.$id
            ]
        );

        $user = User::find($id);

        $user->update(
            [
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
            ]
        );

        if($request->password != "")
        {
            $user->update(
                [
                    'password' => Hash::make($request->password),
                ]
            );
        }

        return back()->with('success', "Orderbooker Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function customers($id)
    {
        $orderbooker = User::findOrFail($id);
        $allCustomers = \App\Models\accounts::where('type', 'Customer')->get();
        $assignedCustomerIds = \App\Models\OrderbookerCustomer::where('orderbooker_id', $id)->pluck('customer_id')->toArray();
        $unassignedCustomers = $allCustomers->whereNotIn('id', $assignedCustomerIds);
        $assignedCustomers = \App\Models\accounts::whereIn('id', $assignedCustomerIds)->get();

        return view('orderbookers.customers', compact('orderbooker', 'unassignedCustomers', 'assignedCustomers'));
    }

    public function assignCustomer(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:accounts,id'
        ]);

        \App\Models\OrderbookerCustomer::firstOrCreate([
            'orderbooker_id' => $id,
            'customer_id' => $request->customer_id
        ]);

        return back()->with('success', 'Customer assigned successfully.');
    }

    public function removeCustomer($id, $customer_id)
    {
        \App\Models\OrderbookerCustomer::where('orderbooker_id', $id)
            ->where('customer_id', $customer_id)
            ->delete();

        return back()->with('success', 'Customer removed successfully.');
    }
}
