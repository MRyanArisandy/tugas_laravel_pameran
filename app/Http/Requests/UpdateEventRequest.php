<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Semua field bersifat opsional (sometimes) karena ini adalah update parsial.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nama_event'    => ['sometimes', 'required', 'string', 'max:255'],
            'tanggal_event' => ['sometimes', 'required', 'date'],
            'lokasi'        => ['sometimes', 'required', 'string', 'max:255'],
            'kapasitas'     => ['sometimes', 'required', 'integer', 'min:1'],
        ];
    }
}
