@csrf
@if($shipment?->exists)
    @method('PUT')
@endif

<div class="grid gap-4 md:grid-cols-2">
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">user</span>
        <select name="user_id" class="ops-input w-full" required>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id', $shipment->user_id) == $user->id)>{{ $user->name }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Carrier</span>
        <select name="carrier_id" class="ops-input w-full" required>
            @foreach($carriers as $carrier)
                <option value="{{ $carrier->id }}" @selected(old('carrier_id', $shipment->carrier_id) == $carrier->id)>
                    {{ $carrier->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Sender</span>
        <input name="sender_name" value="{{ old('sender_name', $shipment->sender_name) }}" class="ops-input w-full"
            required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Receiver</span>
        <input name="receiver_name" value="{{ old('receiver_name', $shipment->receiver_name) }}"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Origin City</span>
        <select name="sender_city" class="ops-input w-full" required>
            @foreach($cities as $city)
                <option value="{{ $city }}" @selected(old('sender_city', $shipment->sender_city) === $city)>{{ $city }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Destination City</span>
        <select name="receiver_city" class="ops-input w-full" required>
            @foreach($cities as $city)
                <option value="{{ $city }}" @selected(old('receiver_city', $shipment->receiver_city) === $city)>{{ $city }}
                </option>
            @endforeach
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Weight kg</span>
        <input type="number" step="0.1" name="weight" value="{{ old('weight', $shipment->weight) }}"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Dimensions</span>
        <input name="dimensions" value="{{ old('dimensions', $shipment->dimensions) }}" class="ops-input w-full"
            required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Status</span>
        <select name="status" class="ops-input w-full" required>
            @foreach($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $shipment->status ?: 'pending') === $status)>
                    {{ str($status)->headline() }}</option>
            @endforeach
        </select>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">Cost INR</span>
        <input type="number" step="0.01" name="cost" value="{{ old('cost', $shipment->cost ?: 850) }}"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1">
        <span class="text-xs font-semibold uppercase text-slate-400">ETA</span>
        <input type="datetime-local" name="estimated_delivery"
            value="{{ old('estimated_delivery', optional($shipment->estimated_delivery)->format('Y-m-d\TH:i')) }}"
            class="ops-input w-full" required>
    </label>
    <label class="space-y-1 md:col-span-2">
        <span class="text-xs font-semibold uppercase text-slate-400">Receiver Address</span>
        <textarea name="receiver_address" rows="3" class="ops-input w-full"
            required>{{ old('receiver_address', $shipment->receiver_address) }}</textarea>
    </label>
</div>

@if($errors->any())
    <div class="rounded border border-red-400/50 bg-red-400/10 p-3 text-sm text-red-100">
        {{ $errors->first() }}
    </div>
@endif

<div class="flex justify-end gap-3">
    <a href="{{ route('shipments.index') }}" class="ops-button-secondary">Cancel</a>
    <button class="ops-button">Save Shipment</button>
</div>