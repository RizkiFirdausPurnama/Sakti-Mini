<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah ke true
    }

    public function rules(): array
    {
        return [
            'nim' => ['required', 'string', 'unique:mahasiswas,nim'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:mahasiswas,email'],
            'prodi' => ['required', 'string'],
            'angkatan' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2030'],
            'status' => ['required', 'in:aktif,cuti,lulus,dropout'],
        ];
    }
}