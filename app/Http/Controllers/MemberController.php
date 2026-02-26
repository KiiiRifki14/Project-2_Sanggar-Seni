<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $totalLes = $user->pendaftaranLes()->count();
        $totalBooking = $user->reservasiPentas()->count();
        $lesTerakhir = $user->pendaftaranLes()->with('kelas')->latest()->take(3)->get();
        $bookingTerakhir = $user->reservasiPentas()->latest()->take(3)->get();

        return view('member.dashboard', compact('user', 'totalLes', 'totalBooking', 'lesTerakhir', 'bookingTerakhir'));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('member.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
        ]);

        auth()->user()->update($validated);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function daftarLes()
    {
        $kelas = Kelas::where('is_active', true)->get();
        return view('member.daftar-les', compact('kelas'));
    }

    public function storeLes(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'asal_sekolah' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',
        ]);

        // Cek duplikasi pendaftaran
        $exists = PendaftaranLes::where('user_id', auth()->id())
            ->where('kelas_id', $validated['kelas_id'])
            ->whereIn('status', ['menunggu', 'diterima'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mendaftar di kelas ini.')->withInput();
        }

        $validated['user_id'] = auth()->id();
        PendaftaranLes::create($validated);

        return redirect()->route('member.riwayat')->with('success', 'Pendaftaran berhasil dikirim! Status: Menunggu Validasi.');
    }

    public function booking()
    {
        return view('member.booking');
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'jenis_acara' => 'required|in:pernikahan,penyambutan,festival,lainnya',
            'tanggal_pentas' => 'required|date|after:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'lokasi_acara' => 'required|string',
            'deskripsi_acara' => 'nullable|string',
        ]);

        // Anti-bentrok: cek jadwal yang sudah disetujui
        $bentrok = ReservasiPentas::where('tanggal_pentas', $validated['tanggal_pentas'])
            ->where('status', 'disetujui')
            ->where(function ($q) use ($validated) {
                $q->where(function ($q2) use ($validated) {
                    $q2->where('waktu_mulai', '<', $validated['waktu_selesai'])
                        ->where('waktu_selesai', '>', $validated['waktu_mulai']);
                });
            })->exists();

        if ($bentrok) {
            return back()->with('error', 'Maaf, jadwal tersebut sudah terisi. Silakan pilih tanggal/jam lain.')->withInput();
        }

        // Hitung durasi
        $mulai = \Carbon\Carbon::parse($validated['waktu_mulai']);
        $selesai = \Carbon\Carbon::parse($validated['waktu_selesai']);
        $validated['durasi_jam'] = round($selesai->diffInMinutes($mulai) / 60, 1);
        $validated['user_id'] = auth()->id();

        $booking = ReservasiPentas::create($validated);

        // Generate WhatsApp link
        $user = auth()->user();
        $jenisLabel = ucfirst($validated['jenis_acara']);
        $msg = "*🎭 Pesanan Baru Art-Hub*\n\n"
            . "📋 *Detail Pesanan:*\n"
            . "Nama: {$user->name}\n"
            . "WA: {$user->no_whatsapp}\n"
            . "Jenis Acara: {$jenisLabel}\n"
            . "Tanggal: {$validated['tanggal_pentas']}\n"
            . "Waktu: {$validated['waktu_mulai']} - {$validated['waktu_selesai']}\n"
            . "Lokasi: {$validated['lokasi_acara']}\n"
            . "Durasi: {$validated['durasi_jam']} jam\n\n"
            . "📌 Mohon segera dikonfirmasi. Terima kasih! 🙏";

        $adminWa = '628123456789'; // Default admin WhatsApp
        $admin = \App\Models\User::where('role', 'admin')->first();
        if ($admin && $admin->no_whatsapp) {
            $adminWa = $admin->no_whatsapp;
        }
        $waLink = 'https://wa.me/' . $adminWa . '?text=' . urlencode($msg);

        return redirect()->route('member.riwayat')
            ->with('success', 'Pesanan berhasil dikirim! Status: Menunggu Konfirmasi.')
            ->with('wa_link', $waLink);
    }

    public function riwayat()
    {
        $user = auth()->user();
        $pendaftaran = $user->pendaftaranLes()->with('kelas')->latest()->get();
        $booking = $user->reservasiPentas()->latest()->get();

        return view('member.riwayat', compact('pendaftaran', 'booking'));
    }

    public function cetakBukti($id)
    {
        $pendaftaran = PendaftaranLes::with(['user', 'kelas'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('member.cetak-bukti', compact('pendaftaran'));
    }
}
