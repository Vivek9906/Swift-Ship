@extends('layouts.app')

@section('title', 'Edit Shipment')

@section('content')
<form method="POST" action="{{ route('shipments.update', $shipment) }}" class="ops-panel max-w-5xl space-y-6 rounded-lg p-5">
    @include('shipments._form')
</form>
@endsection
