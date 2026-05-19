<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Carrier;
use App\Models\User;
use Illuminate\Validation\Rule;

class StoreShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->canManage() ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists(user::class, 'id')],
            'carrier_id' => ['required', Rule::exists(Carrier::class, 'id')],
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_city' => ['required', 'string', 'max:100'],
            'receiver_name' => ['required', 'string', 'max:255'],
            'receiver_city' => ['required', 'string', 'max:100'],
            'receiver_address' => ['required', 'string', 'max:1000'],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:99999'],
            'dimensions' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in(['pending', 'in_transit', 'arrived_at_city', 'out_for_delivery', 'delivered', 'delayed', 'failed'])],
            'cost' => ['required', 'numeric', 'min:0'],
            'estimated_delivery' => ['required', 'date'],
        ];
    }
}
