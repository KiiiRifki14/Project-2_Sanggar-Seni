<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Jadwal;
use App\Models\Personel;
use App\Models\Absensi;
use App\Models\Vendor;
use App\Models\SewaKostum;
use App\Models\Negosiasi;
use App\Models\KeuanganEvent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /* ══════════════════════════════════════════
     *  DASHBOARD
     * ══════════════════════════════════════════ */

    public function dashboard()
    {
        $totalEvent        = Event::count();
        $eventAktif        = Event::aktif()->count();
        $totalPersonel     = Personel::where('is_active', true)->count();
        $totalVendor       = Vendor::count();

        // Upcoming merge points (H-2 notifications)
        $mergePoints = Jadwal::mergePoints()
            ->where('tanggal', '>=', now()->toDateString())
            ->where('tanggal', '<=', now()->addDays(3)->toDateString())
            ->with('event')
            ->orderBy('tanggal')
            ->get();

        // Kostum deadlines approaching
        $deadlineKostum = SewaKostum::whereIn('status', ['dipesan', 'diambil'])
            ->whereNotNull('tanggal_kembali')
            ->where('tanggal_kembali', '<=', now()->addDays(3)->toDateString())
            ->with(['event', 'vendor'])
            ->orderBy('tanggal_kembali')
            ->get();

        // Upcoming events
        $upcomingEvents = Event::aktif()
            ->where('tanggal_event', '>=', now()->toDateString())
            ->orderBy('tanggal_event')
            ->take(5)
            ->get();

        // Financial summary
        $totalLaba = KeuanganEvent::all()->sum(fn($k) => $k->real_laba);

        return view('admin.dashboard', compact(
            'totalEvent',
            'eventAktif',
            'totalPersonel',
            'totalVendor',
            'mergePoints',
            'deadlineKostum',
            'upcomingEvents',
            'totalLaba'
        ));
    }

    /* ══════════════════════════════════════════
     *  EVENT MANAGEMENT
     * ══════════════════════════════════════════ */

    public function kelolaEvent()
    {
        $events = Event::orderBy('tanggal_event', 'desc')->get();
        return view('admin.kelola-event', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $data = $request->validate([
            'nama_event'    => 'required|string|max:255',
            'jenis_acara'   => 'required|in:pernikahan,festival,penyambutan,budaya,lainnya',
            'klien'         => 'required|string|max:255',
            'lokasi'        => 'required|string',
            'tanggal_event' => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai'  => 'required',
            'status'        => 'nullable|in:persiapan,berlangsung,selesai,batal',
            'status_bayar'  => 'nullable|in:belum_dp,sudah_dp,lunas',
            'nominal_dp'    => 'nullable|numeric|min:0',
            'catatan'       => 'nullable|string',
        ]);

        $event = Event::create($data);

        // Auto-create keuangan record
        KeuanganEvent::create(['event_id' => $event->id]);

        return redirect()->route('admin.kelola-event')->with('success', 'Event berhasil ditambahkan!');
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $data = $request->validate([
            'nama_event'    => 'required|string|max:255',
            'jenis_acara'   => 'required|in:pernikahan,festival,penyambutan,budaya,lainnya',
            'klien'         => 'required|string|max:255',
            'lokasi'        => 'required|string',
            'tanggal_event' => 'required|date',
            'waktu_mulai'   => 'required',
            'waktu_selesai'  => 'required',
            'status'        => 'nullable|in:persiapan,berlangsung,selesai,batal',
            'status_bayar'  => 'nullable|in:belum_dp,sudah_dp,lunas',
            'nominal_dp'    => 'nullable|numeric|min:0',
            'catatan'       => 'nullable|string',
        ]);
        $event->update($data);

        return redirect()->route('admin.kelola-event')->with('success', 'Event berhasil diperbarui!');
    }

    public function deleteEvent($id)
    {
        Event::findOrFail($id)->delete();
        return redirect()->route('admin.kelola-event')->with('success', 'Event berhasil dihapus!');
    }

    /* ══════════════════════════════════════════
     *  JADWAL MULTI-TRACK
     * ══════════════════════════════════════════ */

    public function jadwal(Request $request)
    {
        $eventId = $request->query('event_id');
        $events  = Event::orderBy('tanggal_event', 'desc')->get();

        $jadwals = collect();
        $selectedEvent = null;

        if ($eventId) {
            $selectedEvent = Event::find($eventId);
            $jadwals = Jadwal::where('event_id', $eventId)
                ->orderBy('tanggal')
                ->orderBy('waktu_mulai')
                ->get();
        }

        return view('admin.jadwal', compact('events', 'jadwals', 'selectedEvent', 'eventId'));
    }

    public function storeJadwal(Request $request)
    {
        $data = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'judul'          => 'required|string|max:255',
            'track'          => 'required|in:penari,pemusik,gabungan',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required',
            'waktu_selesai'  => 'required',
            'lokasi'         => 'nullable|string|max:255',
            'catatan'        => 'nullable|string',
            'is_merge_point' => 'nullable|boolean',
        ]);

        // Auto-detect merge point for "gabungan" track
        if ($data['track'] === 'gabungan') {
            $data['is_merge_point'] = true;
        }

        $data['is_merge_point'] = $data['is_merge_point'] ?? false;

        Jadwal::create($data);

        return redirect()->route('admin.jadwal', ['event_id' => $data['event_id']])
            ->with('success', 'Jadwal latihan berhasil ditambahkan!');
    }

    public function updateJadwal(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $data = $request->validate([
            'judul'          => 'required|string|max:255',
            'track'          => 'required|in:penari,pemusik,gabungan',
            'tanggal'        => 'required|date',
            'waktu_mulai'    => 'required',
            'waktu_selesai'  => 'required',
            'lokasi'         => 'nullable|string|max:255',
            'catatan'        => 'nullable|string',
            'is_merge_point' => 'nullable|boolean',
        ]);

        if ($data['track'] === 'gabungan') {
            $data['is_merge_point'] = true;
        }
        $data['is_merge_point'] = $data['is_merge_point'] ?? false;

        $jadwal->update($data);

        return redirect()->route('admin.jadwal', ['event_id' => $jadwal->event_id])
            ->with('success', 'Jadwal latihan berhasil diperbarui!');
    }

    public function deleteJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $eventId = $jadwal->event_id;
        $jadwal->delete();
        return redirect()->route('admin.jadwal', ['event_id' => $eventId])
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    /* ══════════════════════════════════════════
     *  ABSENSI
     * ══════════════════════════════════════════ */

    public function absensi(Request $request)
    {
        $jadwalId = $request->query('jadwal_id');
        $eventId  = $request->query('event_id');

        $events  = Event::orderBy('tanggal_event', 'desc')->get();
        $jadwals = collect();
        $absensis = collect();
        $personels = collect();
        $selectedJadwal = null;

        if ($eventId) {
            $jadwals = Jadwal::where('event_id', $eventId)
                ->orderBy('tanggal')
                ->orderBy('waktu_mulai')
                ->get();
        }

        if ($jadwalId) {
            $selectedJadwal = Jadwal::with('event')->find($jadwalId);

            if ($selectedJadwal) {
                // Get relevant personels based on track
                $track = $selectedJadwal->track;
                if ($track === 'gabungan') {
                    $personels = Personel::where('is_active', true)->orderBy('peran')->orderBy('nama')->get();
                } else {
                    $personels = Personel::where('is_active', true)
                        ->where('peran', $track === 'penari' ? 'penari' : 'pemusik')
                        ->orderBy('nama')
                        ->get();
                }

                // Get existing attendance records
                $absensis = Absensi::where('jadwal_id', $jadwalId)->get()->keyBy('personel_id');

                // Auto-create missing attendance records
                foreach ($personels as $p) {
                    if (!$absensis->has($p->id)) {
                        Absensi::create([
                            'jadwal_id'   => $jadwalId,
                            'personel_id' => $p->id,
                            'status'      => 'absen',
                        ]);
                    }
                }

                $absensis = Absensi::where('jadwal_id', $jadwalId)->with('personel')->get();
            }
        }

        return view('admin.absensi', compact('events', 'jadwals', 'absensis', 'personels', 'selectedJadwal', 'eventId', 'jadwalId'));
    }

    public function updateAbsensi(Request $request)
    {
        $data = $request->validate([
            'absensi'          => 'required|array',
            'absensi.*.id'     => 'required|exists:absensis,id',
            'absensi.*.status' => 'required|in:hadir,izin,absen',
            'jadwal_id'        => 'required',
            'event_id'         => 'required',
        ]);

        foreach ($data['absensi'] as $item) {
            Absensi::where('id', $item['id'])->update(['status' => $item['status']]);
        }

        return redirect()->route('admin.absensi', [
            'event_id'  => $data['event_id'],
            'jadwal_id' => $data['jadwal_id'],
        ])->with('success', 'Absensi berhasil diperbarui!');
    }

    /* ══════════════════════════════════════════
     *  PERSONEL MANAGEMENT
     * ══════════════════════════════════════════ */

    public function kelolaPersonel()
    {
        $personels = Personel::orderBy('peran')->orderBy('jenis_kelamin')->orderBy('nama')->get();
        $countPenariL  = Personel::where('peran', 'penari')->where('jenis_kelamin', 'L')->where('is_active', true)->count();
        $countPenariP  = Personel::where('peran', 'penari')->where('jenis_kelamin', 'P')->where('is_active', true)->count();
        $countPemusik  = Personel::where('peran', 'pemusik')->where('is_active', true)->count();

        return view('admin.kelola-personel', compact('personels', 'countPenariL', 'countPenariP', 'countPemusik'));
    }

    public function storePersonel(Request $request)
    {
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'peran'         => 'required|in:penari,pemusik',
            'no_whatsapp'   => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
        ]);
        Personel::create($data);
        return redirect()->route('admin.kelola-personel')->with('success', 'Personel berhasil ditambahkan!');
    }

    public function updatePersonel(Request $request, $id)
    {
        $personel = Personel::findOrFail($id);
        $data = $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'peran'         => 'required|in:penari,pemusik',
            'no_whatsapp'   => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'is_active'     => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->has('is_active');
        $personel->update($data);
        return redirect()->route('admin.kelola-personel')->with('success', 'Personel berhasil diperbarui!');
    }

    public function deletePersonel($id)
    {
        Personel::findOrFail($id)->delete();
        return redirect()->route('admin.kelola-personel')->with('success', 'Personel berhasil dihapus!');
    }

    /* ══════════════════════════════════════════
     *  VENDOR MANAGEMENT
     * ══════════════════════════════════════════ */

    public function kelolaVendor()
    {
        $vendors = Vendor::orderBy('nama_vendor')->get();
        return view('admin.kelola-vendor', compact('vendors'));
    }

    public function storeVendor(Request $request)
    {
        $data = $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'kontak'      => 'required|string|max:50',
            'alamat'      => 'nullable|string',
            'catatan'     => 'nullable|string',
        ]);
        Vendor::create($data);
        return redirect()->route('admin.kelola-vendor')->with('success', 'Vendor berhasil ditambahkan!');
    }

    public function updateVendor(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $data = $request->validate([
            'nama_vendor' => 'required|string|max:255',
            'kontak'      => 'required|string|max:50',
            'alamat'      => 'nullable|string',
            'catatan'     => 'nullable|string',
        ]);
        $vendor->update($data);
        return redirect()->route('admin.kelola-vendor')->with('success', 'Vendor berhasil diperbarui!');
    }

    public function deleteVendor($id)
    {
        Vendor::findOrFail($id)->delete();
        return redirect()->route('admin.kelola-vendor')->with('success', 'Vendor berhasil dihapus!');
    }

    /* ══════════════════════════════════════════
     *  SEWA KOSTUM
     * ══════════════════════════════════════════ */

    public function sewaKostum(Request $request)
    {
        $eventId = $request->query('event_id');
        $events  = Event::orderBy('tanggal_event', 'desc')->get();
        $vendors = Vendor::orderBy('nama_vendor')->get();

        $sewas = SewaKostum::with(['event', 'vendor'])
            ->when($eventId, fn($q) => $q->where('event_id', $eventId))
            ->orderBy('tanggal_kembali')
            ->get();

        return view('admin.sewa-kostum', compact('events', 'vendors', 'sewas', 'eventId'));
    }

    public function storeSewaKostum(Request $request)
    {
        $data = $request->validate([
            'event_id'        => 'required|exists:events,id',
            'vendor_id'       => 'required|exists:vendors,id',
            'nama_kostum'     => 'required|string|max:255',
            'jumlah'          => 'required|integer|min:1',
            'biaya_sewa'      => 'required|numeric|min:0',
            'tanggal_ambil'   => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'status'          => 'nullable|in:dipesan,diambil,dikembalikan,terlambat',
            'catatan'         => 'nullable|string',
        ]);
        SewaKostum::create($data);

        // Auto-update real_sewa_kostum in keuangan
        $this->syncSewaToKeuangan($data['event_id']);

        return redirect()->route('admin.sewa-kostum', ['event_id' => $data['event_id']])
            ->with('success', 'Sewa kostum berhasil dicatat!');
    }

    public function updateSewaKostum(Request $request, $id)
    {
        $sewa = SewaKostum::findOrFail($id);
        $data = $request->validate([
            'vendor_id'       => 'required|exists:vendors,id',
            'nama_kostum'     => 'required|string|max:255',
            'jumlah'          => 'required|integer|min:1',
            'biaya_sewa'      => 'required|numeric|min:0',
            'tanggal_ambil'   => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'status'          => 'nullable|in:dipesan,diambil,dikembalikan,terlambat',
            'catatan'         => 'nullable|string',
        ]);
        $sewa->update($data);

        $this->syncSewaToKeuangan($sewa->event_id);

        return redirect()->route('admin.sewa-kostum', ['event_id' => $sewa->event_id])
            ->with('success', 'Sewa kostum berhasil diperbarui!');
    }

    public function deleteSewaKostum($id)
    {
        $sewa = SewaKostum::findOrFail($id);
        $eventId = $sewa->event_id;
        $sewa->delete();

        $this->syncSewaToKeuangan($eventId);

        return redirect()->route('admin.sewa-kostum', ['event_id' => $eventId])
            ->with('success', 'Sewa kostum berhasil dihapus!');
    }

    /**
     * Auto-sync total sewa kostum to keuangan_events.real_sewa_kostum
     */
    private function syncSewaToKeuangan(string $eventId): void
    {
        $totalSewa = SewaKostum::where('event_id', $eventId)->sum('biaya_sewa');
        $keuangan = KeuanganEvent::firstOrCreate(['event_id' => $eventId]);
        $keuangan->update(['real_sewa_kostum' => $totalSewa]);
    }

    /* ══════════════════════════════════════════
     *  NEGOSIASI
     * ══════════════════════════════════════════ */

    public function negosiasi(Request $request)
    {
        $eventId = $request->query('event_id');
        $events  = Event::orderBy('tanggal_event', 'desc')->get();

        $negosiasis = Negosiasi::with('event')
            ->when($eventId, fn($q) => $q->where('event_id', $eventId))
            ->orderBy('tanggal')
            ->get();

        return view('admin.negosiasi', compact('events', 'negosiasis', 'eventId'));
    }

    public function storeNegosiasi(Request $request)
    {
        $data = $request->validate([
            'event_id'         => 'required|exists:events,id',
            'tanggal'          => 'required|date',
            'harga_penawaran'  => 'required|numeric|min:0',
            'pihak'            => 'required|in:klien,sanggar',
            'catatan'          => 'nullable|string',
        ]);

        Negosiasi::create($data);

        return redirect()->route('admin.negosiasi', ['event_id' => $data['event_id']])
            ->with('success', 'Penawaran berhasil dicatat!');
    }

    public function setDeal($id)
    {
        $nego = Negosiasi::findOrFail($id);

        // Reset old deals for this event
        Negosiasi::where('event_id', $nego->event_id)->update(['is_deal' => false]);

        // Set this as the deal
        $nego->update(['is_deal' => true]);

        // Sync to keuangan
        $keuangan = KeuanganEvent::firstOrCreate(['event_id' => $nego->event_id]);
        $keuangan->update(['harga_deal' => $nego->harga_penawaran]);

        return redirect()->route('admin.negosiasi', ['event_id' => $nego->event_id])
            ->with('success', 'Harga deal berhasil ditetapkan: Rp ' . number_format($nego->harga_penawaran, 0, ',', '.'));
    }

    /* ══════════════════════════════════════════
     *  KEUANGAN
     * ══════════════════════════════════════════ */

    public function keuangan(Request $request)
    {
        $eventId = $request->query('event_id');
        $events  = Event::orderBy('tanggal_event', 'desc')->get();

        $keuangan     = null;
        $selectedEvent = null;

        if ($eventId) {
            $selectedEvent = Event::find($eventId);
            $keuangan = KeuanganEvent::firstOrCreate(['event_id' => $eventId]);
        }

        return view('admin.keuangan', compact('events', 'keuangan', 'selectedEvent', 'eventId'));
    }

    public function updateKeuangan(Request $request, $id)
    {
        $keuangan = KeuanganEvent::findOrFail($id);
        $data = $request->validate([
            'harga_deal'          => 'nullable|numeric|min:0',
            'estimasi_konsumsi'   => 'nullable|numeric|min:0',
            'estimasi_transport'  => 'nullable|numeric|min:0',
            'estimasi_sewa_kostum' => 'nullable|numeric|min:0',
            'estimasi_honor'      => 'nullable|numeric|min:0',
            'real_konsumsi'       => 'nullable|numeric|min:0',
            'real_transport'      => 'nullable|numeric|min:0',
            'real_sewa_kostum'    => 'nullable|numeric|min:0',
            'real_honor'          => 'nullable|numeric|min:0',
        ]);

        $keuangan->update(array_map(fn($v) => $v ?? 0, $data));

        return redirect()->route('admin.keuangan', ['event_id' => $keuangan->event_id])
            ->with('success', 'Data keuangan berhasil diperbarui!');
    }
}
