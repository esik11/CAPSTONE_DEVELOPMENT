<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'specialization' => ['nullable', 'string', 'max:255'],
            'license_number' => ['nullable', 'string', 'max:255'],
            'ptr_number' => ['nullable', 'string', 'max:255'],
            's2_number' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],
            'clinic_address' => ['nullable', 'string'],
        ];
    }
}
