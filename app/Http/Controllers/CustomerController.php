<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = Customer::filter($request->only(['search', 'status']))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $customers->getCollection()->each(function (Customer $customer) {
            $customer->setAttribute('shipments_count', $customer->shipments()->count());
        });

        return view('customers.index', compact('customers'));
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        Customer::create($request->validated());

        return back()->with('status', 'Customer added.');
    }

    public function show(Customer $customer): View
    {
        $customer->load(['shipments.carrier']);
        $stats = [
            'total' => $customer->shipments->count(),
            'delivered' => $customer->shipments->where('status', 'delivered')->count(),
            'pending' => $customer->shipments->whereIn('status', ['pending', 'in_transit', 'out_for_delivery'])->count(),
        ];

        return view('customers.show', compact('customer', 'stats'));
    }

    public function update(StoreCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        return back()->with('status', 'Customer updated.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
        $customer->delete();

        return redirect()->route('customers.index')->with('status', 'Customer deleted.');
    }
}
