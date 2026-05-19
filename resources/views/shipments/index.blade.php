@extends('layouts.app')

@section('title', 'Shipments')

@section('content')
<div class="space-y-5" x-data="{ addOpen: false }">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <form class="grid gap-3 sm:grid-cols-2 lg:grid-cols-6" method="GET">
            <input name="search" value="{{ request('search') }}" placeholder="Search tracking, user, city" class="ops-input lg:col-span-2">
            <select name="status" class="ops-input">
                <option value="">All statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str($status)->headline() }}</option>
                @endforeach
            </select>
            <select name="carrier_id" class="ops-input">
                <option value="">All carriers</option>
                @foreach($carriers as $carrier)
                    <option value="{{ $carrier->id }}" @selected(request('carrier_id') == $carrier->id)>{{ $carrier->name }}</option>
                @endforeach
            </select>
            <select name="city" class="ops-input">
                <option value="">All cities</option>
                @foreach($cities as $city)
                    <option value="{{ $city }}" @selected(request('city') === $city)>{{ $city }}</option>
                @endforeach
            </select>
            <button class="ops-button">Filter</button>
        </form>
        <button class="ops-button" @click="addOpen = true">Add New Shipment</button>
    </div>

    <form id="bulk-form" method="POST" action="{{ route('shipments.bulk') }}" class="ops-panel rounded-lg p-3">
        @csrf
        <div class="flex flex-col gap-3 md:flex-row md:items-center">
            <select name="action" class="ops-input">
                <option value="export">Export CSV</option>
                <option value="delivered">Mark as Delivered</option>
                <option value="reassign">Reassign Carrier</option>
            </select>
            <select name="carrier_id" class="ops-input">
                <option value="">Carrier for reassignment</option>
                @foreach($carriers as $carrier)
                    <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                @endforeach
            </select>
            <button class="ops-button-secondary">Apply Bulk Action</button>
        </div>
    </form>

    <div class="ops-panel overflow-hidden rounded-lg">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-left text-sm">
                <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th class="px-4 py-3"></th>
                        @foreach([
                            'tracking_number' => 'Tracking ID',
                            'user' => 'user',
                            'sender_city' => 'Origin',
                            'receiver_city' => 'Destination',
                            'status' => 'Status',
                            'carrier' => 'Carrier',
                            'estimated_delivery' => 'ETA',
                            'updated_at' => 'Last Update',
                        ] as $sort => $label)
                            <th class="px-4 py-3">
                                <a href="{{ route('shipments.index', array_merge(request()->query(), ['sort' => $sort, 'direction' => request('direction') === 'asc' ? 'desc' : 'asc'])) }}" class="hover:text-blue-200">{{ $label }}</a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($shipments as $shipment)
                        <x-shipment-row :shipment="$shipment" />
                    @empty
                        <tr><td colspan="9" class="px-4 py-8 text-center text-slate-400">No shipments match the current filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-800 px-4 py-3">{{ $shipments->links() }}</div>
    </div>

    <div x-show="addOpen" x-transition class="fixed inset-0 z-50 grid place-items-center bg-black/70 p-4" style="display:none">
        <div class="ops-panel max-h-[90vh] w-full max-w-5xl overflow-y-auto rounded-lg p-5" @click.outside="addOpen = false">
            <div class="mb-5 flex items-center justify-between">
                <h2 class="text-lg font-bold">New Shipment</h2>
                <button class="ops-button-secondary" @click="addOpen = false" type="button">Close</button>
            </div>
            <form method="POST" action="{{ route('shipments.store') }}" class="space-y-6">
                @include('shipments._form', ['shipment' => new App\Models\Shipment])
            </form>
        </div>
    </div>
</div>
@endsection
