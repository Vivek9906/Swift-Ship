<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = User::whereIn('role', ['customer', 'user'])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        $customers->getCollection()->each(function (User $user) {
            $user->setAttribute('shipments_count', $user->shipments()->count());
        });

        return view('customers.index', compact('customers'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        if (!empty($validated['phone']) && preg_match('/^(\+91|91)?([6-9]\d{9})$/', $validated['phone'], $matches)) {
            $validated['phone'] = '+91' . $matches[2];
        }

        if (isset($validated['status'])) {
            $validated['is_active'] = $validated['status'] === 'active';
            unset($validated['status']);
        }

        $validated['role'] = 'customer';
        User::create($validated);

        return back()->with('status', 'user added.');
    }

    public function show(User $customer): View
    {
        $customer->load(['shipments.carrier']);
        $stats = [
            'total' => $customer->shipments->count(),
            'delivered' => $customer->shipments->where('status', 'delivered')->count(),
            'pending' => $customer->shipments->whereIn('status', ['pending', 'in_transit', 'out_for_delivery'])->count(),
        ];

        $user = $customer; // for view compatibility
        return view('customers.show', compact('user', 'stats'));
    }

    public function update(StoreUserRequest $request, User $customer): RedirectResponse
    {
        $validated = $request->validated();
        if (!empty($validated['phone']) && preg_match('/^(\+91|91)?([6-9]\d{9})$/', $validated['phone'], $matches)) {
            $validated['phone'] = '+91' . $matches[2];
        }

        if (isset($validated['status'])) {
            $validated['is_active'] = $validated['status'] === 'active';
            unset($validated['status']);
        }

        $customer->update($validated);

        return back()->with('status', 'user updated.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403);
        $customer->delete();

        return redirect()->route('customers.index')->with('status', 'Customer deleted.');
    }
}
