<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index()
    {
        $customers = User::where('role', 'customer')->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Return a single customer as JSON.
     */
    public function show(User $customer)
    {
        return response()->json($customer);
    }

    /**
     * Update the specified customer.
     */
    public function update(Request $request, User $customer)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($customer->id)],
            'role' => ['required', 'string', Rule::in(['customer', 'admin'])],
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }
}
