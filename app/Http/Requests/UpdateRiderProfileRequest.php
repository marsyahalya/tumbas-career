<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRiderProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Rider hanya bisa update selama status masih 'submitted'
     */
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->isRider()
            && auth()->user()->riderProfile;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Data diri (semua opsional saat update)
            'full_name'         => ['sometimes', 'string', 'max:255'],
            'phone_number'      => ['sometimes', 'string', 'regex:/^\+?[0-9]{9,15}$/'],
            'birth_date'        => ['sometimes', 'date', 'before:today'],
            'gender'            => ['sometimes', 'in:male,female'],
            'address'           => ['sometimes', 'string', 'max:500'],
            'selected_area_id'     => ['nullable', 'exists:areas,id'],

            // Pengalaman kerja (array, max 3 item)
            'experiences'                       => ['nullable', 'array', 'max:3'],
            'experiences.*.company_name'        => ['nullable', 'string', 'max:255'],
            'experiences.*.position'            => ['nullable', 'string', 'max:500'],
            'experiences.*.start_date'          => ['required_with:experiences.*.company_name', 'date'],
            'experiences.*.end_date'            => ['nullable', 'date', 'after_or_equal:experiences.*.start_date'],

            // Dokumen (opsional saat update)
            'cv'    => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'phone_number.regex'            => 'Nomor HP hanya boleh berisi angka (9-15 digit).',
            'experiences.max'               => 'Maksimal 3 pengalaman kerja.',
            'cv.mimes'                      => 'File CV harus berformat PDF.',
            'cv.max'                        => 'Ukuran file CV maksimal 5MB.',
            'photo.mimes'                   => 'Foto harus berformat JPG atau PNG.',
            'photo.max'                     => 'Ukuran foto maksimal 1MB.',
            'birth_date.before'             => 'Tanggal lahir harus sebelum hari ini.',
        ];
    }
}
