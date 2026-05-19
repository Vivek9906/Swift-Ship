@props(['shipment'])

<tr class="border-b border-slate-800 transition hover:bg-slate-800/60">
    <td class="px-4 py-3">
        <input form="bulk-form" type="checkbox" name="shipment_ids[]" value="{{ $shipment->id }}"
            class="rounded border-slate-600 bg-slate-950 text-blue-500">
    </td>
    <td class="px-4 py-3 font-mono text-blue-200">
        <a href="{{ route('shipments.show', $shipment) }}"
            class="hover:text-blue-100">{{ $shipment->tracking_number }}</a>
    </td>
    <td class="px-4 py-3">{{ $shipment->user?->name ?? 'No user' }}</td>
    <td class="px-4 py-3">{{ $shipment->sender_city }}</td>
    <td class="px-4 py-3">{{ $shipment->receiver_city }}</td>
    <td class="px-4 py-3"><x-status-badge :status="$shipment->status" /></td>
    <td class="px-4 py-3">{{ $shipment->carrier->name ?? 'No Carrier' }}</td>
    <td class="px-4 py-3">{{ $shipment->estimated_delivery?->format('M d, H:i') }}</td>
    <td class="px-4 py-3 text-slate-400">{{ $shipment->updated_at->diffForHumans() }}</td>
</tr>