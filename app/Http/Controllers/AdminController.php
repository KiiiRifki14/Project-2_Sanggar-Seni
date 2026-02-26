<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;
use App\Models\Galeri;
use App\Enums\PendaftaranStatus;
use App\Enums\BookingStatus;
use App\Http\Requests\StoreGaleriRequest;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = PendaftaranLes::where('status', PendaftaranStatus::DITERIMA)->count();
        $totalMember = User::where('role', 'member')->count();
        $pendaftaranBaru = PendaftaranLes::where('status', PendaftaranStatus::MENUNGGU)->count();
        $bookingBaru = ReservasiPentas::where('status', BookingStatus::MENUNGGU)->count();
        $totalGaleri = Galeri::count();

        $pendaftaranTerbaru = PendaftaranLes::with(['user', 'kelas'])
            ->where('status', PendaftaranStatus::MENUNGGU)->latest()->take(5)->get();
        $bookingTerbaru = ReservasiPentas::with('user')
            ->where('status', BookingStatus::MENUNGGU)->latest()->take(5)->get();

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

    public function processLes(Request $request, string $id)
    {
        $pendaftaran = PendaftaranLes::findOrFail($id);
        $validated = $request->validate([
            'status'        => 'required|in:diterima,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $pendaftaran->update($validated);

        $label = $validated['status'] === PendaftaranStatus::DITERIMA->value ? 'disetujui' : 'ditolak';
        return back()->with('success', "Pendaftaran berhasil {$label}.");
    }

    // ── Validasi Booking Pentas ──
    public function validasiBooking()
    {
        $booking = ReservasiPentas::with('user')->latest()->paginate(15);
        return view('admin.validasi-booking', compact('booking'));
    }

    public function processBooking(Request $request, string $id)
    {
        $booking = ReservasiPentas::findOrFail($id);
        $validated = $request->validate([
            'status'        => 'required|in:disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        if ($validated['status'] === BookingStatus::DISETUJUI->value) {
            $result = DB::transaction(function () use ($booking, $validated, $id) {
                $locked = ReservasiPentas::lockForUpdate()->find($id);

                $bentrok = ReservasiPentas::where('id', '!=', $id)
                    ->where('tanggal_pentas', $locked->tanggal_pentas)
                    ->where('status', BookingStatus::DISETUJUI)
                    ->where(function ($q) use ($locked) {
                        $q->where('waktu_mulai', '<', $locked->waktu_selesai)
                            ->where('waktu_selesai', '>', $locked->waktu_mulai);
                    })->exists();

                if ($bentrok) return 'bentrok';
                $locked->update($validated);
                return 'ok';
            });

            if ($result === 'bentrok') {
                return back()->with('error', 'Tidak bisa menyetujui — jadwal bentrok dengan booking lain.');
            }
        } else {
            $booking->update($validated);
        }

        $label = $validated['status'] === BookingStatus::DISETUJUI->value ? 'disetujui' : 'ditolak';
        return back()->with('success', "Booking berhasil {$label}.");
    }

    // ── Kelola Galeri ──
    public function galeri()
    {
        $galeri = Galeri::latest()->paginate(12);
        return view('admin.galeri', compact('galeri'));
    }

    public function storeGaleri(StoreGaleriRequest $request)
    {
        $validated = $request->validated();
        $path = $request->file('file')->store('galeri', 'public');

        Galeri::create([
            'judul'     => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'file_path' => 'storage/' . $path,
            'tipe'      => $validated['tipe'],
        ]);

        return back()->with('success', 'Konten galeri berhasil ditambahkan!');
    }

    public function deleteGaleri(string $id)
    {
        $galeri = Galeri::findOrFail($id);
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
            ->where('status', PendaftaranStatus::DITERIMA)
            ->latest()->paginate(15);
        return view('admin.siswa', compact('siswa'));
    }

    public function deleteSiswa(string $id)
    {
        PendaftaranLes::findOrFail($id)->delete();
        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    // ── Jadwal Pementasan ──
    public function jadwal()
    {
        $jadwal = ReservasiPentas::with('user')
            ->where('status', BookingStatus::DISETUJUI)
            ->orderBy('tanggal_pentas', 'asc')
            ->paginate(15);
        return view('admin.jadwal', compact('jadwal'));
    }

    public function cancelJadwal(string $id)
    {
        $booking = ReservasiPentas::findOrFail($id);
        $booking->update(['status' => BookingStatus::DITOLAK->value, 'catatan_admin' => 'Dibatalkan oleh admin']);
        return back()->with('success', 'Jadwal pementasan berhasil dibatalkan.');
    }

    // ── Laporan ──
    public function laporan(Request $request)
    {
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $siswaAktif = PendaftaranLes::with(['user', 'kelas'])
            ->where('status', PendaftaranStatus::DITERIMA)
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)->get();

        $jadwalPentas = ReservasiPentas::with('user')
            ->where('status', BookingStatus::DISETUJUI)
            ->whereYear('tanggal_pentas', $tahun)
            ->whereMonth('tanggal_pentas', $bulan)->get();

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
            ->where('status', PendaftaranStatus::DITERIMA)
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)->get();

        $jadwalPentas = ReservasiPentas::with('user')
            ->where('status', BookingStatus::DISETUJUI)
            ->whereYear('tanggal_pentas', $tahun)
            ->whereMonth('tanggal_pentas', $bulan)->get();

        $namaBulan = \Carbon\Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        return view('admin.export-laporan', compact('siswaAktif', 'jadwalPentas', 'namaBulan'));
    }
}
