@extends('layouts.app')

@section('page_title', 'Contact Leads')

@section('content')
<div class="space-y-6">
  {{-- Header --}}
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-xl font-bold text-white">Contact Leads</h1>
      <p class="text-slate-400 text-sm mt-0.5">Sales inquiries from the public contact form</p>
    </div>
    <a href="{{ route('admin.leads.index', ['status' => '']) }}" class="text-xs text-slate-400 hover:text-amber-400 border border-slate-700 rounded-lg px-3 py-1.5 hover:border-amber-400/40 transition">
      All Leads
    </a>
  </div>

  {{-- Filters --}}
  <form method="GET" class="flex flex-wrap gap-3">
    @foreach(['new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','closed'=>'Closed'] as $val => $label)
    <a href="{{ route('admin.leads.index', ['status' => $val]) }}"
       class="rounded-lg px-4 py-1.5 text-xs font-semibold border transition {{ request('status') === $val ? 'bg-amber-400 text-slate-950 border-amber-400' : 'border-slate-700 text-slate-400 hover:border-amber-400/40 hover:text-amber-400' }}">
      {{ $label }}
    </a>
    @endforeach
  </form>

  {{-- Table --}}
  <div class="rounded-2xl border border-slate-800 bg-slate-900/80 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full min-w-[900px] text-left text-sm">
        <thead class="bg-slate-900 text-xs uppercase tracking-wider text-slate-500 border-b border-slate-800">
          <tr>
            <th class="px-5 py-3">Name / Company</th>
            <th class="px-5 py-3">Contact</th>
            <th class="px-5 py-3">Type</th>
            <th class="px-5 py-3">Volume</th>
            <th class="px-5 py-3">Date</th>
            <th class="px-5 py-3">Status</th>
            <th class="px-5 py-3">Message</th>
          </tr>
        </thead>
        <tbody>
          @forelse($leads as $lead)
          <tr class="border-b border-slate-800 hover:bg-slate-800/40 transition">
            <td class="px-5 py-3">
              <p class="font-semibold text-white">{{ $lead->name }}</p>
              <p class="text-xs text-slate-500">{{ $lead->company }}</p>
            </td>
            <td class="px-5 py-3">
              <p class="text-slate-300 text-xs">{{ $lead->email }}</p>
              <p class="text-slate-500 text-xs">{{ $lead->phone }}</p>
            </td>
            <td class="px-5 py-3 text-slate-400 text-xs">{{ $lead->business_type }}</td>
            <td class="px-5 py-3 text-slate-400 text-xs">{{ $lead->monthly_volume }}</td>
            <td class="px-5 py-3 text-slate-500 text-xs">{{ $lead->created_at->format('M d, Y') }}</td>
            <td class="px-5 py-3">
              <select onchange="updateLeadStatus('{{ $lead->id }}', this.value)"
                class="rounded-lg border border-slate-700 bg-slate-800 text-xs px-2 py-1 text-slate-300 outline-none focus:border-amber-400 transition cursor-pointer">
                @foreach(['new'=>'New','contacted'=>'Contacted','qualified'=>'Qualified','closed'=>'Closed'] as $val => $label)
                <option value="{{ $val }}" {{ $lead->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
              </select>
            </td>
            <td class="px-5 py-3">
              @if($lead->message)
              <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-xs text-slate-500 hover:text-amber-400 transition underline decoration-dotted">View</button>
              <p class="hidden text-xs text-slate-400 mt-1 max-w-[200px]">{{ $lead->message }}</p>
              @else
              <span class="text-slate-700 text-xs">—</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="7" class="px-5 py-12 text-center text-slate-500">No leads yet. Contact form submissions will appear here.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($leads->hasPages())
    <div class="px-5 py-4 border-t border-slate-800">{{ $leads->links() }}</div>
    @endif
  </div>
</div>

@push('scripts')
<script>
async function updateLeadStatus(id, status) {
  const res = await fetch(`/admin/leads/${id}/status`, {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' },
    body: JSON.stringify({ status })
  });
  const data = await res.json();
  if (data.success) {
    // Quick visual feedback
    const badge = event.target;
    badge.style.borderColor = '#f59e0b';
    setTimeout(() => badge.style.borderColor = '', 1500);
  }
}
</script>
@endpush
@endsection
