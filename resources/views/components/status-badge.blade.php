@props(['status'])

@php
    $colors = [
        'pending' => 'border-slate-600 bg-slate-700/40 text-slate-200',
        'confirmed' => 'border-sky-500/50 bg-sky-500/15 text-sky-200',
        'picked_up' => 'border-violet-500/50 bg-violet-500/15 text-violet-200',
        'in_transit' => 'border-blue-500/50 bg-blue-500/15 text-blue-200',
        'arrived_at_city' => 'border-cyan-400/50 bg-cyan-400/15 text-cyan-100',
        'out_for_delivery' => 'border-amber-400/60 bg-amber-400/15 text-amber-100',
        'delivered' => 'border-emerald-400/60 bg-emerald-400/15 text-emerald-100',
        'delayed' => 'border-orange-400/60 bg-orange-400/15 text-orange-100',
        'cancelled' => 'border-red-400/60 bg-red-500/15 text-red-200',
        'failed' => 'border-red-400/60 bg-red-400/15 text-red-100',
        'active' => 'border-emerald-400/60 bg-emerald-400/15 text-emerald-100',
        'inactive' => 'border-slate-600 bg-slate-700/40 text-slate-200',
    ];
@endphp

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center rounded border px-2 py-1 text-xs font-semibold uppercase tracking-wide ' .
    ($colors[$status] ?? $colors['inactive'])
]) }}>
    {{ str($status ?: 'inactive')->headline() }}
</span>
