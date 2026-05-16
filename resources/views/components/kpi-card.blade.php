@props(['label', 'value', 'accent' => 'blue', 'trend' => null])

@php
    $accentClasses = [
        'blue' => 'text-blue-300 border-blue-500/30',
        'amber' => 'text-amber-300 border-amber-500/30',
        'emerald' => 'text-emerald-300 border-emerald-500/30',
        'red' => 'text-red-300 border-red-500/30',
    ];
@endphp

<article {{ $attributes->merge(['class' => 'ops-panel rounded-lg p-4']) }}>
    <div class="flex items-start justify-between gap-3">
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $label }}</p>
        <span class="h-2 w-2 rounded-full bg-current {{ $accentClasses[$accent] ?? $accentClasses['blue'] }}"></span>
    </div>
    <div class="mt-3 flex items-end justify-between">
        <p class="text-3xl font-bold {{ $accentClasses[$accent] ?? $accentClasses['blue'] }}">{{ $value }}</p>
        @if($trend)
            <p class="text-xs text-slate-400">{{ $trend }}</p>
        @endif
    </div>
</article>
