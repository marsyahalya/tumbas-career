<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRiderProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isRider();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Data diri
            'full_name'         => ['required', 'string', 'max:255'],
            'phone_number'      => ['required', 'string', 'regex:/^\+?[0-9]{9,15}$/'],
            'birth_date'        => ['required', 'date', 'before:today'],
            'gender'            => ['required', 'in:male,female'],
            'address'           => ['required', 'string', 'max:500'],
            'city'              => ['required', 'string', 'max:255'],
            'selected_area_id'  => ['required', 'exists:areas,id'],

            // Pengalaman kerja (array, max 3 item)
            'experiences'                       => ['nullable', 'array', 'max:3'],
            'experiences.*.company_name'        => ['nullable', 'string', 'max:255'],
            'experiences.*.position'            => ['nullable', 'string', 'max:500'],
            'experiences.*.start_date'          => ['required_with:experiences.*.company_name', 'date'],
            'experiences.*.end_date'            => ['nullable', 'date', 'after_or_equal:experiences.*.start_date'],

            // Dokumen
            'cv'    => ['required', 'file', 'mimes:pdf', 'max:5120'],  // max 5MB
            'photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],      // max 1MB
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
            'experiences.*.end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
        ];
    }
}
