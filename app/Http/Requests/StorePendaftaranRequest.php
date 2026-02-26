<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id'       => 'required|exists:kelas,id',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'asal_sekolah'   => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'no_hp_ortu'     => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'kelas_id.required'       => 'Pilihan kelas wajib diisi.',
            'kelas_id.exists'         => 'Kelas yang dipilih tidak ditemukan.',
            'tempat_lahir.required'   => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'asal_sekolah.required'   => 'Asal sekolah wajib diisi.',
            'nama_orang_tua.required' => 'Nama orang tua wajib diisi.',
            'no_hp_ortu.required'     => 'Nomor HP orang tua wajib diisi.',
        ];
    }
}
