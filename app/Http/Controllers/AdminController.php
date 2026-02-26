<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;
use App\Models\Galeri;

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

        // Cek bentrok jika menyetujui
        if ($validated['status'] === 'disetujui') {
            $bentrok = ReservasiPentas::where('id', '!=', $id)
                ->where('tanggal_pentas', $booking->tanggal_pentas)
                ->where('status', 'disetujui')
                ->where(function ($q) use ($booking) {
                    $q->where('waktu_mulai', '<', $booking->waktu_selesai)
                        ->where('waktu_selesai', '>', $booking->waktu_mulai);
                })->exists();

            if ($bentrok) {
                return back()->with('error', 'Tidak bisa menyetujui — jadwal bentrok dengan booking lain yang sudah disetujui.');
            }
        }

        $booking->update($validated);

        $label = $validated['status'] === 'disetujui' ? 'disetujui' : 'ditolak';
        return back()->with('success', "Booking berhasil {$label}.");
    }

    // ── Kelola Galeri ──
    public function galeri()
    {
        $galeri = Galeri::latest()->paginate(12);
        return view('admin.galeri', compact('galeri'));
    }

    public function storeGaleri(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4,webm|max:20480',
            'tipe' => 'required|in:foto,video',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/galeri'), $filename);

        Galeri::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'file_path' => 'uploads/galeri/' . $filename,
            'tipe' => $validated['tipe'],
        ]);

        return back()->with('success', 'Konten galeri berhasil ditambahkan!');
    }

    public function deleteGaleri($id)
    {
        $galeri = Galeri::findOrFail($id);
        $path = public_path($galeri->file_path);
        if (file_exists($path)) {
            unlink($path);
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
        $pendaftaran->delete();
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
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

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
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

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
