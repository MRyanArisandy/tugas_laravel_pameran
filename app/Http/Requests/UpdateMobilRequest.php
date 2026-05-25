<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMobilRequest extends FormRequest
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
            'nama_mobil' => ['sometimes', 'required', 'string', 'max:255'],
            'merk'       => ['sometimes', 'required', 'string', 'max:255'],
            'tahun'      => ['sometimes', 'required', 'integer', 'min:1900', 'max:2100'],
            'harga'      => ['sometimes', 'required', 'numeric', 'min:0'],
        ];
    }
}
