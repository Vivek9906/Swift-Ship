@extends('layouts.app')
@section('title', 'My Profile')
@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <h2 class="text-xl font-bold text-white">My Profile</h2>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-5 py-3 text-sm text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="ops-panel rounded-lg p-6">
        <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="ops-input" required>
                    @error('name')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="ops-input" required>
                    @error('email')<p class="text-xs text-red-400 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="ops-input">
                </div>
            </div>
            <div class="pt-4 border-t border-slate-800">
                <button type="submit" class="ops-button">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- Change Password --}}
    <div class="ops-panel rounded-lg p-6">
        <h3 class="font-semibold text-white mb-4">Change Password</h3>
        <form method="POST" action="{{ route('customer.profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="change_password" value="1">
            <div>
                <label class="block text-xs font-semibold text-slate-400 mb-1.5">Current Password</label>
                <input type="password" name="current_password" class="ops-input" autocomplete="current-password">
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">New Password</label>
                    <input type="password" name="password" class="ops-input" autocomplete="new-password">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="ops-input" autocomplete="new-password">
                </div>
            </div>
            <button type="submit" class="ops-button-secondary">Update Password</button>
        </form>
    </div>
</div>
@endsection
