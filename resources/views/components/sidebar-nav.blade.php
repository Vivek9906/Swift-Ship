@php
    $items = [
        ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z'],
        ['route' => 'shipments.index', 'label' => 'Shipments', 'icon' => 'M4 7h11v10H4V7Zm11 3h3l2 3v4h-5v-7ZM7 19a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm10 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'],
        ['route' => 'tracking.live-map', 'label' => 'Live Map', 'icon' => 'M12 2 5 5v17l7-3 7 3V5l-7-3Zm0 2.2 5 2.1v12.6l-5-2.1V4.2Z'],
        ['route' => 'customers.index', 'label' => 'Customers', 'icon' => 'M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0ZM4 21a8 8 0 0 1 16 0H4Z'],
        ['route' => 'carriers.index', 'label' => 'Carriers', 'icon' => 'M3 6h18v4H3V6Zm2 6h14v6H5v-6Zm3 8h8v2H8v-2Z'],
        ['route' => 'notifications.index', 'label' => 'Alerts', 'icon' => 'M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22Zm7-6V11a7 7 0 0 0-14 0v5l-2 2v1h18v-1l-2-2Z'],
        ['route' => 'settings', 'label' => 'Settings', 'icon' => 'M19.4 13.5a7.7 7.7 0 0 0 0-3l2-1.5-2-3.5-2.4 1a8 8 0 0 0-2.6-1.5L14 2h-4l-.4 3a8 8 0 0 0-2.6 1.5l-2.4-1-2 3.5 2 1.5a7.7 7.7 0 0 0 0 3l-2 1.5 2 3.5 2.4-1a8 8 0 0 0 2.6 1.5l.4 3h4l.4-3a8 8 0 0 0 2.6-1.5l2.4 1 2-3.5-2-1.5ZM12 15.5A3.5 3.5 0 1 1 12 8a3.5 3.5 0 0 1 0 7.5Z'],
    ];
@endphp

<nav class="space-y-1">
    @foreach($items as $item)
        <a href="{{ route($item['route']) }}" class="group flex items-center gap-3 rounded px-3 py-2 text-sm font-semibold transition {{ request()->routeIs($item['route']) ? 'bg-blue-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="{{ $item['icon'] }}"/></svg>
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
