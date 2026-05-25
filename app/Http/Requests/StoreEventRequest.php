<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'nama_event'    => ['required', 'string', 'max:255'],
            'tanggal_event' => ['required', 'date'],
            'lokasi'        => ['required', 'string', 'max:255'],
            'kapasitas'     => ['required', 'integer', 'min:1'],
        ];
    }
}
