@extends('layouts.app')

@section('title', 'customers')

@section('content')
    <div class="space-y-5" x-data="{ addOpen: false, edit: null }">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" class="grid gap-3 sm:grid-cols-3">
                <input name="search" value="{{ request('search') }}" placeholder="Search user" class="ops-input">
                <select name="status" class="ops-input">
                    <option value="">All statuses</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
                <button class="ops-button">Filter</button>
            </form>
            @if(auth()->user()?->canManage())
                <button class="ops-button" @click="addOpen = true">Add user</button>
            @endif
        </div>

        <div class="ops-panel overflow-hidden rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-left text-sm">
                    <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">City</th>
                            <th class="px-4 py-3">Total Shipments</th>
                            <th class="px-4 py-3">Last Order</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $user)
                            <tr class="border-b border-slate-800 hover:bg-slate-800/60">
                                <td class="px-4 py-3 font-semibold"><span class="hover:text-blue-200">{{ $user->name }}</span></td>
                                <td class="px-4 py-3">{{ $user->email }}</td>
                                <td class="px-4 py-3">{{ $user->phone }}</td>
                                <td class="px-4 py-3">{{ $user->city }}</td>
                                <td class="px-4 py-3">{{ $user->shipments_count }}</td>
                                <td class="px-4 py-3">
                                    {{ optional($user->shipments()->latest()->first())->created_at?->format('M d, Y') ?? 'No orders' }}
                                </td>
                                <td class="px-4 py-3"><x-status-badge :status="$user->status" /></td>
                                <td class="px-4 py-3 text-right">
                                    @if(auth()->user()?->canManage())
                                        <button class="text-sm font-semibold text-blue-300"
                                            @click='edit = @json($user)'>Edit</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-800 px-4 py-3">{{ $customers->links() }}</div>
        </div>

        <div x-show="addOpen || edit" x-transition class="fixed inset-0 z-50 grid place-items-center bg-black/70 p-4"
            style="display:none">
            <form method="POST" :action="edit ? `/admin/customers/${edit.id}` : '{{ route('customers.store') }}'"
                class="ops-panel w-full max-w-2xl space-y-4 rounded-lg p-5" @click.outside="addOpen = false; edit = null">
                @csrf
                <template x-if="edit"><input type="hidden" name="_method" value="PUT"></template>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold" x-text="edit ? 'Edit user' : 'Add user'"></h2>
                    <button type="button" class="ops-button-secondary" @click="addOpen = false; edit = null">Close</button>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <input name="name" class="ops-input" placeholder="Name" :value="edit?.name" required>
                    <input name="email" type="email" class="ops-input" placeholder="Email" :value="edit?.email" required>
                    <input name="phone" class="ops-input" placeholder="Phone" :value="edit?.phone" required>
                    <input name="city" class="ops-input" placeholder="City" :value="edit?.city" required>
                    <select name="status" class="ops-input">
                        <option value="active" :selected="edit?.status === 'active'">Active</option>
                        <option value="inactive" :selected="edit?.status === 'inactive'">Inactive</option>
                    </select>
                    <textarea name="address" class="ops-input md:col-span-2" rows="3" placeholder="Address"
                        x-text="edit?.address" required></textarea>
                    <textarea name="notes" class="ops-input md:col-span-2" rows="3" placeholder="Notes"
                        x-text="edit?.notes"></textarea>
                </div>
                <div class="flex justify-end"><button class="ops-button">Save user</button></div>
            </form>
        </div>
    </div>
@endsection