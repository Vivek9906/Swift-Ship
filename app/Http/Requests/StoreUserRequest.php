<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->canManage();
    }

    public function rules(): array
    {
        $customer = $this->route('customer');
        $userId = is_string($customer) ? $customer : $customer?->id;

        return [
            'name'   => ['required', 'string', 'max:100'],
            'email'  => ['required', 'email', 'max:255', $userId ? "unique:users,email,{$userId},_id" : 'unique:users,email'],
            'phone'  => ['nullable', 'string', 'regex:/^(\+91|91)?[6-9]\d{9}$/'],
            'city'   => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes'  => ['nullable', 'string', 'max:1000'],
        ];
    }
}
