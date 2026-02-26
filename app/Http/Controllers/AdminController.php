<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;
use App\Models\Galeri;
use App\Http\Requests\StoreGaleriRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = PendaftaranLes::where('status', 'diterima')->count();
        $totalMember = User::where('role', 'member')->count();
        $pendaftaranBaru = PendaftaranLes::where('status', 'menunggu')->count();
        $bookingBaru = ReservasiPentas::where('status', 'menunggu')->count();
        $totalGaleri = Galeri::count();

        $pendaftaranTerbaru = PendaftaranLes::with(['user', 'kelas'])
            ->where('status', 'menunggu')->latest()->take(5)->get();
        $bookingTerbaru = ReservasiPentas::with('user')
            ->where('status', 'menunggu')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalMember',
            'pendaftaranBaru',
            'bookingBaru',
            'totalGaleri',
            'pendaftaranTerbaru',
            'bookingTerbaru'
        ));
    }

    // ── Validasi Pendaftaran Les ──
    public function validasiLes()
    {
        $pendaftaran = PendaftaranLes::with(['user', 'kelas'])->latest()->paginate(15);
        return view('admin.validasi-les', compact('pendaftaran'));
    }

    public function processLes(Request $request, $id)
    {
        $pendaftaran = PendaftaranLes::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $pendaftaran->update($validated);

        $label = $validated['status'] === 'diterima' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Pendaftaran berhasil {$label}.");
    }

    // ── Validasi Booking Pentas ──
    public function validasiBooking()
    {
        $booking = ReservasiPentas::with('user')->latest()->paginate(15);
        return view('admin.validasi-booking', compact('booking'));
    }

    public function processBooking(Request $request, $id)
    {
        $booking = ReservasiPentas::findOrFail($id);
        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        // ★ Fix #3: DB Transaction + lockForUpdate untuk cek bentrok
        if ($validated['status'] === 'disetujui') {
            $result = DB::transaction(function () use ($booking, $validated, $id) {
                // Re-fetch with lock to prevent race condition
                $locked = ReservasiPentas::lockForUpdate()->find($id);

                $bentrok = ReservasiPentas::where('id', '!=', $id)
                    ->where('tanggal_pentas', $locked->tanggal_pentas)
                    ->where('status', 'disetujui')
                    ->where(function ($q) use ($locked) {
                        $q->where('waktu_mulai', '<', $locked->waktu_selesai)
                            ->where('waktu_selesai', '>', $locked->waktu_mulai);
                    })->exists();

                if ($bentrok) {
                    return 'bentrok';
                }

                $locked->update($validated);
                return 'ok';
            });

            if ($result === 'bentrok') {
                return back()->with('error', 'Tidak bisa menyetujui — jadwal bentrok dengan booking lain yang sudah disetujui.');
            }
        } else {
            $booking->update($validated);
        }

        $label = $validated['status'] === 'disetujui' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Booking berhasil {$label}.");
    }

    // ── Kelola Galeri ──
    public function galeri()
    {
        $galeri = Galeri::latest()->paginate(12);
        return view('admin.galeri', compact('galeri'));
    }

    // ★ Fix #1 & #3: Storage Facade + Form Request + MIME validation
    public function storeGaleri(StoreGaleriRequest $request)
    {
        $validated = $request->validated();

        // Simpan file menggunakan Storage Facade (lebih aman dari move())
        $path = $request->file('file')->store('galeri', 'public');

        Galeri::create([
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'file_path' => 'storage/' . $path,
            'tipe'      => $validated['tipe'],
        ]);

        return back()->with('success', 'Konten galeri berhasil ditambahkan!');
    }

    public function deleteGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus file dari Storage
        $storagePath = str_replace('storage/', '', $galeri->file_path);
        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }

        $galeri->delete();
        return back()->with('success', 'Item galeri berhasil dihapus.');
    }

    // ── Kelola Siswa ──
    public function siswa()
    {
        $siswa = PendaftaranLes::with(['user', 'kelas'])
            ->where('status', 'diterima')
            ->latest()->paginate(15);
        return view('admin.siswa', compact('siswa'));
    }

    public function deleteSiswa($id)
    {
        $pendaftaran = PendaftaranLes::findOrFail($id);
        $pendaftaran->delete(); // ★ SoftDelete — data masuk recycle bin
        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    // ── Jadwal Pementasan ──
    public function jadwal()
    {
        $jadwal = ReservasiPentas::with('user')
            ->where('status', 'disetujui')
            ->orderBy('tanggal_pentas', 'asc')
            ->paginate(15);
        return view('admin.jadwal', compact('jadwal'));
    }

    public function cancelJadwal($id)
    {
        $booking = ReservasiPentas::findOrFail($id);
        $booking->update(['status' => 'ditolak', 'catatan_admin' => 'Dibatalkan oleh admin']);
        return back()->with('success', 'Jadwal pementasan berhasil dibatalkan.');
    }

    // ── Laporan ──
    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        // ★ Fix #4: Eager Loading untuk performa query
        $siswaAktif = PendaftaranLes::with(['user', 'kelas'])
            ->where('status', 'diterima')
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->get();

        $jadwalPentas = ReservasiPentas::with('user')
            ->where('status', 'disetujui')
            ->whereYear('tanggal_pentas', $tahun)
            ->whereMonth('tanggal_pentas', $bulan)
            ->get();

        $pendaftaranBulanIni = PendaftaranLes::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)->count();
        $bookingBulanIni = ReservasiPentas::whereYear('tanggal_pentas', $tahun)
            ->whereMonth('tanggal_pentas', $bulan)->count();

        return view('admin.laporan', compact(
            'siswaAktif',
            'jadwalPentas',
            'bulan',
            'tahun',
            'pendaftaranBulanIni',
            'bookingBulanIni'
        ));
    }

    public function exportLaporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $siswaAktif = PendaftaranLes::with(['user', 'kelas'])
            ->where('status', 'diterima')
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->get();

        $jadwalPentas = ReservasiPentas::with('user')
            ->where('status', 'disetujui')
            ->whereYear('tanggal_pentas', $tahun)
            ->whereMonth('tanggal_pentas', $bulan)
            ->get();

        $namaBulan = \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        return view('admin.export-laporan', compact('siswaAktif', 'jadwalPentas', 'namaBulan'));
    }
}
