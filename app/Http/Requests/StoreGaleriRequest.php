<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul'    => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file'     => 'required|file|mimes:jpg,jpeg,png,gif,mp4,webm|max:20480',
            'tipe'     => 'required|in:foto,video',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul konten wajib diisi.',
            'file.required'  => 'File wajib diunggah.',
            'file.mimes'     => 'Format file harus: jpg, jpeg, png, gif, mp4, atau webm.',
            'file.max'       => 'Ukuran file maksimal 20MB.',
            'tipe.required'  => 'Tipe konten wajib dipilih.',
            'tipe.in'        => 'Tipe konten harus foto atau video.',
        ];
    }
}
