<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email'                 => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone_number'          => ['nullable', 'string', 'max:20'],
            'city'                  => ['nullable', 'string', 'max:100'],
            'address'               => ['nullable', 'string', 'max:500'],
            'education_level'       => ['nullable', 'string', 'max:10'],
            'education_institution' => ['nullable', 'string', 'max:255'],
            'graduation_year'       => ['nullable', 'numeric', 'min:1990', 'max:' . date('Y')],
            'cv'                    => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'photo'                 => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }
}
