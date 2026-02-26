<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jenis_acara'    => 'required|in:pernikahan,penyambutan,festival,lainnya',
            'tanggal_pentas' => 'required|date|after:today',
            'waktu_mulai'    => 'required',
            'waktu_selesai'  => 'required|after:waktu_mulai',
            'lokasi_acara'   => 'required|string',
            'deskripsi_acara' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_acara.required'    => 'Jenis acara wajib dipilih.',
            'jenis_acara.in'          => 'Jenis acara tidak valid.',
            'tanggal_pentas.required' => 'Tanggal pementasan wajib diisi.',
            'tanggal_pentas.after'    => 'Tanggal pementasan harus setelah hari ini.',
            'waktu_mulai.required'    => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required'  => 'Waktu selesai wajib diisi.',
            'waktu_selesai.after'     => 'Waktu selesai harus setelah waktu mulai.',
            'lokasi_acara.required'   => 'Lokasi acara wajib diisi.',
        ];
    }
}
