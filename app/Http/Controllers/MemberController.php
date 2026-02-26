<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;
use App\Enums\PendaftaranStatus;
use App\Enums\BookingStatus;
use App\Http\Requests\StorePendaftaranRequest;
use App\Http\Requests\StoreBookingRequest;

class MemberController extends Controller
{
    public function dashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        $totalLes = $user->pendaftaranLes()->count();
        $totalBooking = $user->reservasiPentas()->count();
        $lesTerakhir = $user->pendaftaranLes()->with('kelas')->latest()->take(3)->get();
        $bookingTerakhir = $user->reservasiPentas()->latest()->take(3)->get();

        return view('member.dashboard', compact('user', 'totalLes', 'totalBooking', 'lesTerakhir', 'bookingTerakhir'));
    }

    public function profil()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('member.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'no_whatsapp'   => 'required|string|max:20',
            'alamat'        => 'nullable|string',
            'tempat_lahir'  => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update($validated);
        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function daftarLes()
    {
        $kelas = Kelas::where('is_active', true)->get();
        return view('member.daftar-les', compact('kelas'));
    }

    // ★ DB::transaction + lockForUpdate + PHP Enum
    public function storeLes(StorePendaftaranRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            $kelas = Kelas::lockForUpdate()->find($validated['kelas_id']);

            if (!$kelas || !$kelas->is_active) {
                return back()->with('error', 'Kelas tidak tersedia atau sudah ditutup.')->withInput();
            }

            $userId = Auth::id();

            $jumlahSiswa = PendaftaranLes::where('kelas_id', $kelas->id)
                ->whereIn('status', [PendaftaranStatus::MENUNGGU, PendaftaranStatus::DITERIMA])
                ->count();

            if ($jumlahSiswa >= $kelas->kuota) {
                return back()->with('error', 'Maaf, kuota kelas ini sudah penuh.')->withInput();
            }

            $exists = PendaftaranLes::where('user_id', $userId)
                ->where('kelas_id', $validated['kelas_id'])
                ->whereIn('status', [PendaftaranStatus::MENUNGGU, PendaftaranStatus::DITERIMA])
                ->exists();

            if ($exists) {
                return back()->with('error', 'Anda sudah mendaftar di kelas ini.')->withInput();
            }

            $validated['user_id'] = $userId;
            PendaftaranLes::create($validated);

            return redirect()->route('member.riwayat')->with('success', 'Pendaftaran berhasil dikirim! Status: Menunggu Validasi.');
        });
    }

    public function booking()
    {
        return view('member.booking');
    }

    // ★ DB::transaction + lockForUpdate + PHP Enum
    public function storeBooking(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            $bentrok = ReservasiPentas::lockForUpdate()
                ->where('tanggal_pentas', $validated['tanggal_pentas'])
                ->where('status', BookingStatus::DISETUJUI)
                ->where(function ($q) use ($validated) {
                    $q->where('waktu_mulai', '<', $validated['waktu_selesai'])
                        ->where('waktu_selesai', '>', $validated['waktu_mulai']);
                })->exists();

            if ($bentrok) {
                return back()->with('error', 'Maaf, jadwal tersebut sudah terisi. Silakan pilih tanggal/jam lain.')->withInput();
            }

            $mulai = \Carbon\Carbon::parse($validated['waktu_mulai']);
            $selesai = \Carbon\Carbon::parse($validated['waktu_selesai']);
            $validated['durasi_jam'] = round($selesai->diffInMinutes($mulai) / 60, 1);
            $validated['user_id'] = Auth::id();

            $booking = ReservasiPentas::create($validated);

            /** @var User $user */
            $user = Auth::user();
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

            $adminWa = '628123456789';
            $admin = User::where('role', 'admin')->first();
            if ($admin && $admin->no_whatsapp) {
                $adminWa = $admin->no_whatsapp;
            }
            $waLink = 'https://wa.me/' . $adminWa . '?text=' . urlencode($msg);

            return redirect()->route('member.riwayat')
                ->with('success', 'Pesanan berhasil dikirim! Status: Menunggu Konfirmasi.')
                ->with('wa_link', $waLink);
        });
    }

    public function riwayat()
    {
        /** @var User $user */
        $user = Auth::user();
        $pendaftaran = $user->pendaftaranLes()->with('kelas')->latest()->get();
        $booking = $user->reservasiPentas()->latest()->get();

        return view('member.riwayat', compact('pendaftaran', 'booking'));
    }

    public function cetakBukti(string $id)
    {
        $pendaftaran = PendaftaranLes::with(['user', 'kelas'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('member.cetak-bukti', compact('pendaftaran'));
    }
}
