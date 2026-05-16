@extends('layouts.app')

@section('title', 'Carriers')

@section('content')
<div class="space-y-5">
    <form method="GET" class="grid gap-3 sm:grid-cols-4">
        <input name="search" value="{{ request('search') }}" placeholder="Search carrier" class="ops-input">
        <select name="type" class="ops-input">
            <option value="">All modes</option>
            @foreach(['air', 'ground', 'sea'] as $type)
                <option value="{{ $type }}" @selected(request('type') === $type)>{{ str($type)->headline() }}</option>
            @endforeach
        </select>
        <button class="ops-button">Filter</button>
    </form>
    <div class="ops-panel overflow-hidden rounded-lg">
        <table class="w-full min-w-[800px] text-left text-sm">
            <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-400">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Active Shipments</th>
                    <th class="px-4 py-3">On-Time %</th>
                    <th class="px-4 py-3">Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($carriers as $carrier)
                    <tr class="border-b border-slate-800 hover:bg-slate-800/60">
                        <td class="px-4 py-3 font-semibold"><a href="{{ route('carriers.show', $carrier) }}" class="hover:text-blue-200">{{ $carrier->name }}</a></td>
                        <td class="px-4 py-3">{{ str($carrier->type)->headline() }}</td>
                        <td class="px-4 py-3">{{ $carrier->active_shipments }}</td>
                        <td class="px-4 py-3">
                            <div class="h-2 w-44 rounded bg-slate-800"><div class="h-2 rounded bg-emerald-400" style="width: {{ $carrier->on_time_rate }}%"></div></div>
                            <span class="mt-1 block text-xs text-slate-400">{{ $carrier->on_time_rate }}%</span>
                        </td>
                        <td class="px-4 py-3">{{ $carrier->rating }} / 5</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-slate-800 px-4 py-3">{{ $carriers->links() }}</div>
    </div>
</div>
@endsection
