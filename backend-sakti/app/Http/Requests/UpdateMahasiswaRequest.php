<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID mahasiswa dari parameter route
        // Asumsi Route Model Binding aktif (default Laravel)
        $mahasiswaId = $this->route('mahasiswa') ? $this->route('mahasiswa')->id : null;

        return [
            'nim' => [
                'required', 
                'string', 
                Rule::unique('mahasiswas', 'nim')->ignore($mahasiswaId)
            ],
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'email', 
                Rule::unique('mahasiswas', 'email')->ignore($mahasiswaId)
            ],
            'prodi' => ['required', 'string'],
            'angkatan' => ['required', 'integer', 'digits:4', 'min:2000', 'max:2030'],
            'status' => ['required', 'in:aktif,cuti,lulus,dropout'],
        ];
    }
}