@extends('layouts.app')

@section('title', 'Add Shipment')

@section('content')
<form method="POST" action="{{ route('shipments.store') }}" class="ops-panel max-w-5xl space-y-6 rounded-lg p-5">
    @include('shipments._form', ['shipment' => new App\Models\Shipment])
</form>
@endsection
