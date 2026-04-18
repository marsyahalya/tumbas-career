<?php

namespace App\Http\Requests;

use App\Models\RiderProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRiderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'application_status' => [
                'required',
                Rule::in([
                    'submitted',
                    'document_verification',
                    'interview',
                    'final_approval',
                    'accepted',
                    'rejected',
                ]),
            ],
            'interview_message' => [
                'required_if:application_status,interview',
                'nullable',
                'string',
                'max:1000'
            ],
            'contract_start_date' => ['nullable', 'date'],
            'contract_end_date' => ['nullable', 'date', 'after_or_equal:contract_start_date'],
            'employment_status' => ['nullable', 'in:active,inactive,alumni'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'application_status.in' => 'Status tidak valid. Pilihan: document_verification, interview, final_approval, accepted, rejected.',
        ];
    }
}
