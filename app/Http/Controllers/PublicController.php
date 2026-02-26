<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Galeri;

class PublicController extends Controller
{
    public function landing()
    {
        $kelas = Kelas::where('is_active', true)->take(6)->get();
        $galeri = Galeri::where('is_published', true)->latest()->take(8)->get();
        return view('public.landing', compact('kelas', 'galeri'));
    }

    public function galeri()
    {
        $galeri = Galeri::where('is_published', true)->latest()->paginate(12);
        return view('public.galeri', compact('galeri'));
    }

    public function katalog()
    {
        $kelas = Kelas::where('is_active', true)->get();
        return view('public.katalog', compact('kelas'));
    }
}
