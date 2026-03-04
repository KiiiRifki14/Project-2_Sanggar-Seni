<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function dashboard()
    {
        // For personel view: show upcoming schedules
        // We show all jadwals (both tracks + gabungan) since member
        // can see overall schedule.
        $upcomingJadwals = Jadwal::upcoming()
            ->with('event')
            ->take(10)
            ->get();

        // Count merge points coming up
        $mergePointCount = Jadwal::mergePoints()
            ->where('tanggal', '>=', now()->toDateString())
            ->where('tanggal', '<=', now()->addDays(3)->toDateString())
            ->count();

        return view('member.dashboard', compact('upcomingJadwals', 'mergePointCount'));
    }

    public function jadwalSaya(Request $request)
    {
        $eventId = $request->query('event_id');

        $events = \App\Models\Event::aktif()->orderBy('tanggal_event', 'desc')->get();

        $jadwals = Jadwal::upcoming()
            ->with('event')
            ->when($eventId, fn($q) => $q->where('event_id', $eventId))
            ->get();

        return view('member.jadwal-saya', compact('jadwals', 'events', 'eventId'));
    }

    public function absensiSaya(Request $request)
    {
        $eventId = $request->query('event_id');
        $events = \App\Models\Event::orderBy('tanggal_event', 'desc')->get();

        // Show all absensis for viewing
        $absensis = Absensi::with(['jadwal.event', 'personel'])
            ->when($eventId, fn($q) => $q->whereHas('jadwal', fn($j) => $j->where('event_id', $eventId)))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.absensi-saya', compact('absensis', 'events', 'eventId'));
    }

    public function profil()
    {
        return view('member.profil', ['user' => Auth::user()]);
    }

    public function updateProfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'no_whatsapp'  => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
        ]);
        $user->update($data);
        return redirect()->route('member.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
