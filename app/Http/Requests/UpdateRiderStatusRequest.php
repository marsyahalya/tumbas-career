<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRiderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'application_status'  => ['required', Rule::in(['submit', 'verifikasi_berkas', 'wawancara', 'final_approval'])],
            'interview_message'   => [Rule::requiredIf($this->application_status === 'wawancara'), 'nullable', 'string', 'max:1000'],
            'contract_start_date' => ['nullable', 'date'],
            'contract_end_date'   => ['nullable', 'date', 'after:contract_start_date'],
            'employment_status'   => ['nullable', 'in:terima,ditolak'],
        ];
    }

    public function messages(): array
    {
        return [
            'application_status.in'         => 'Tahapan tidak valid. Pilihan: submit, verifikasi_berkas, wawancara, final_approval.',
            'interview_message.required_if' => 'Pesan wawancara wajib diisi saat memilih tahap wawancara.',
        ];
    }
}
