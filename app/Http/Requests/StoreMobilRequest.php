<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMobilRequest extends FormRequest
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
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nama_mobil' => ['required', 'string', 'max:255'],
            'merk'       => ['required', 'string', 'max:255'],
            'tahun'      => ['required', 'integer', 'min:1900', 'max:2100'],
            'harga'      => ['required', 'numeric', 'min:0'],
        ];
    }
}
