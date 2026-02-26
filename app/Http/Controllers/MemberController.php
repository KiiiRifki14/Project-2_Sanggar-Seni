<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;
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
        // ★ Fix #4: Eager Loading
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
            'name' => 'required|string|max:255',
            'no_whatsapp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:100',
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

    // ★ Fix #3: DB::transaction + lockForUpdate untuk cek kuota
    // ★ Fix #4: Form Request untuk validasi
    public function storeLes(StorePendaftaranRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            // Lock kelas row untuk cek kuota (prevent race condition / overbooking)
            $kelas = Kelas::lockForUpdate()->find($validated['kelas_id']);

            if (!$kelas || !$kelas->is_active) {
                return back()->with('error', 'Kelas tidak tersedia atau sudah ditutup.')->withInput();
            }

            $userId = Auth::id();

            // Cek kuota masih tersedia
            $jumlahSiswa = PendaftaranLes::where('kelas_id', $kelas->id)
                ->whereIn('status', ['menunggu', 'diterima'])
                ->count();

            if ($jumlahSiswa >= $kelas->kuota) {
                return back()->with('error', 'Maaf, kuota kelas ini sudah penuh.')->withInput();
            }

            // Cek duplikasi pendaftaran
            $exists = PendaftaranLes::where('user_id', $userId)
                ->where('kelas_id', $validated['kelas_id'])
                ->whereIn('status', ['menunggu', 'diterima'])
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

    // ★ Fix #3: DB::transaction + lockForUpdate untuk anti-bentrok
    // ★ Fix #4: Form Request untuk validasi
    public function storeBooking(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            // Anti-bentrok dengan pessimistic locking
            $bentrok = ReservasiPentas::lockForUpdate()
                ->where('tanggal_pentas', $validated['tanggal_pentas'])
                ->where('status', 'disetujui')
                ->where(function ($q) use ($validated) {
                    $q->where('waktu_mulai', '<', $validated['waktu_selesai'])
                        ->where('waktu_selesai', '>', $validated['waktu_mulai']);
                })->exists();

            if ($bentrok) {
                return back()->with('error', 'Maaf, jadwal tersebut sudah terisi. Silakan pilih tanggal/jam lain.')->withInput();
            }

            // Hitung durasi
            $mulai = \Carbon\Carbon::parse($validated['waktu_mulai']);
            $selesai = \Carbon\Carbon::parse($validated['waktu_selesai']);
            $validated['durasi_jam'] = round($selesai->diffInMinutes($mulai) / 60, 1);
            $validated['user_id'] = Auth::id();

            $booking = ReservasiPentas::create($validated);

            // Generate WhatsApp link
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
        // ★ Fix #4: Eager Loading
        $pendaftaran = $user->pendaftaranLes()->with('kelas')->latest()->get();
        $booking = $user->reservasiPentas()->latest()->get();

        return view('member.riwayat', compact('pendaftaran', 'booking'));
    }

    // ★ Fix #2 sudah ada: IDOR protection via where('user_id', auth()->id())
    public function cetakBukti($id)
    {
        $pendaftaran = PendaftaranLes::with(['user', 'kelas'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('member.cetak-bukti', compact('pendaftaran'));
    }
}
