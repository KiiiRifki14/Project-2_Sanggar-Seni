<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class PublicController extends Controller
{
    public function landing()
    {
        $upcomingEvents = Event::aktif()
            ->where('tanggal_event', '>=', now()->toDateString())
            ->orderBy('tanggal_event')
            ->take(3)
            ->get();

        $completedEvents = Event::where('status', 'selesai')->count();

        return view('welcome', compact('upcomingEvents', 'completedEvents'));
    }
}
