<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Personel;
use App\Models\Vendor;
use App\Models\Event;
use App\Models\Jadwal;
use App\Models\Absensi;
use App\Models\SewaKostum;
use App\Models\Negosiasi;
use App\Models\KeuanganEvent;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ══════════════════════════════════════════
        //  USERS
        // ══════════════════════════════════════════

        User::create([
            'name'        => 'Pak Yat (Manajer)',
            'email'       => 'admin@arthub.com',
            'password'    => 'admin123',
            'role'        => 'admin',
            'no_whatsapp' => '628123456789',
            'alamat'      => 'Jl. Seni Budaya No. 1, Bandung',
        ]);

        User::create([
            'name'        => 'Siti Nurhaliza',
            'email'       => 'siti@email.com',
            'password'    => 'member123',
            'role'        => 'member',
            'no_whatsapp' => '628111222333',
            'alamat'      => 'Jl. Merdeka No. 10, Bandung',
        ]);

        User::create([
            'name'        => 'Budi Santoso',
            'email'       => 'budi@email.com',
            'password'    => 'member123',
            'role'        => 'member',
            'no_whatsapp' => '628444555666',
            'alamat'      => 'Jl. Pahlawan No. 5, Sumedang',
        ]);

        // ══════════════════════════════════════════
        //  PERSONEL (12 Penari + Pemusik)
        // ══════════════════════════════════════════

        // 5 Penari Putra
        $penariPutra = [
            ['nama' => 'Ahmad Rizki', 'no_whatsapp' => '628101010101'],
            ['nama' => 'Deni Saputra', 'no_whatsapp' => '628101010102'],
            ['nama' => 'Fajar Nugraha', 'no_whatsapp' => '628101010103'],
            ['nama' => 'Gilang Pratama', 'no_whatsapp' => '628101010104'],
            ['nama' => 'Hendra Wijaya', 'no_whatsapp' => '628101010105'],
        ];

        foreach ($penariPutra as $p) {
            Personel::create(array_merge($p, [
                'jenis_kelamin' => 'L',
                'peran'         => 'penari',
            ]));
        }

        // 7 Penari Putri
        $penariPutri = [
            ['nama' => 'Intan Permata', 'no_whatsapp' => '628202020201'],
            ['nama' => 'Jasmine Aulia', 'no_whatsapp' => '628202020202'],
            ['nama' => 'Kartika Dewi', 'no_whatsapp' => '628202020203'],
            ['nama' => 'Lestari Wulan', 'no_whatsapp' => '628202020204'],
            ['nama' => 'Maya Anggraini', 'no_whatsapp' => '628202020205'],
            ['nama' => 'Nadia Safitri', 'no_whatsapp' => '628202020206'],
            ['nama' => 'Olivia Rahma', 'no_whatsapp' => '628202020207'],
        ];

        foreach ($penariPutri as $p) {
            Personel::create(array_merge($p, [
                'jenis_kelamin' => 'P',
                'peran'         => 'penari',
            ]));
        }

        // Pemusik
        $pemusik = [
            ['nama' => 'Sutarjo', 'jenis_kelamin' => 'L', 'no_whatsapp' => '628303030301'],
            ['nama' => 'Wawan Setiawan', 'jenis_kelamin' => 'L', 'no_whatsapp' => '628303030302'],
            ['nama' => 'Yudi Hermawan', 'jenis_kelamin' => 'L', 'no_whatsapp' => '628303030303'],
            ['nama' => 'Zahra Melati', 'jenis_kelamin' => 'P', 'no_whatsapp' => '628303030304'],
        ];

        foreach ($pemusik as $p) {
            Personel::create(array_merge($p, [
                'peran' => 'pemusik',
            ]));
        }

        // ══════════════════════════════════════════
        //  VENDORS
        // ══════════════════════════════════════════

        $v1 = Vendor::create([
            'nama_vendor' => 'Toko Kostum Mang Ujang',
            'kontak'      => '628555111222',
            'alamat'      => 'Jl. Braga No. 45, Bandung',
            'catatan'     => 'Vendor langganan, bisa negosiasi harga khusus untuk pelanggan tetap.',
        ]);

        $v2 = Vendor::create([
            'nama_vendor' => 'Sanggar Busana Nusantara',
            'kontak'      => '628555333444',
            'alamat'      => 'Jl. Asia Afrika No. 78, Bandung',
            'catatan'     => 'Spesialis kostum tari tradisional, koleksi lengkap.',
        ]);

        $v3 = Vendor::create([
            'nama_vendor' => 'CV Gemilang Properti',
            'kontak'      => '628555666777',
            'alamat'      => 'Jl. Cihampelas No. 12, Bandung',
            'catatan'     => 'Menyediakan properti panggung dan alat musik.',
        ]);

        // ══════════════════════════════════════════
        //  EVENT 1: Pernikahan
        // ══════════════════════════════════════════

        $event1 = Event::create([
            'nama_event'    => 'Pementasan Tari Jaipong — Pernikahan Keluarga Andi',
            'jenis_acara'   => 'pernikahan',
            'klien'         => 'Keluarga Andi Suryadi',
            'lokasi'        => 'Gedung Serbaguna Padjadjaran, Bandung',
            'tanggal_event' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'waktu_mulai'   => '19:00',
            'waktu_selesai' => '21:00',
            'status'        => 'persiapan',
            'status_bayar'  => 'sudah_dp',
            'nominal_dp'    => 3000000,
        ]);

        // Jadwal Multi-Track Event 1
        Jadwal::create([
            'event_id'    => $event1->id,
            'judul'       => 'Latihan Gerak Dasar Jaipong',
            'track'       => 'penari',
            'tanggal'     => Carbon::now()->addDays(3)->format('Y-m-d'),
            'waktu_mulai' => '16:00',
            'waktu_selesai' => '18:00',
            'lokasi'      => 'Aula Sanggar Art-Hub',
        ]);

        Jadwal::create([
            'event_id'    => $event1->id,
            'judul'       => 'Latihan Formasi & Ekspresi',
            'track'       => 'penari',
            'tanggal'     => Carbon::now()->addDays(5)->format('Y-m-d'),
            'waktu_mulai' => '16:00',
            'waktu_selesai' => '18:00',
            'lokasi'      => 'Aula Sanggar Art-Hub',
        ]);

        Jadwal::create([
            'event_id'    => $event1->id,
            'judul'       => 'Latihan Iringan Gamelan',
            'track'       => 'pemusik',
            'tanggal'     => Carbon::now()->addDays(4)->format('Y-m-d'),
            'waktu_mulai' => '14:00',
            'waktu_selesai' => '16:00',
            'lokasi'      => 'Ruang Musik Sanggar',
        ]);

        Jadwal::create([
            'event_id'    => $event1->id,
            'judul'       => 'Latihan Tempo & Dinamika',
            'track'       => 'pemusik',
            'tanggal'     => Carbon::now()->addDays(6)->format('Y-m-d'),
            'waktu_mulai' => '14:00',
            'waktu_selesai' => '16:00',
            'lokasi'      => 'Ruang Musik Sanggar',
        ]);

        Jadwal::create([
            'event_id'       => $event1->id,
            'judul'          => '🔗 Gladi Bersih (Latihan Gabungan Penari + Pemusik)',
            'track'          => 'gabungan',
            'tanggal'        => Carbon::now()->addDays(8)->format('Y-m-d'),
            'waktu_mulai'    => '15:00',
            'waktu_selesai'  => '18:00',
            'lokasi'         => 'Aula Sanggar Art-Hub',
            'is_merge_point' => true,
            'catatan'        => 'Instruksi Pak Yat: Pastikan semua penari dan pemusik hadir! Latihan full costume.',
        ]);

        // Negosiasi Event 1
        Negosiasi::create([
            'event_id'        => $event1->id,
            'tanggal'         => Carbon::now()->subDays(14)->format('Y-m-d'),
            'harga_penawaran' => 8000000,
            'pihak'           => 'klien',
            'catatan'         => 'Penawaran awal dari keluarga Andi.',
        ]);

        Negosiasi::create([
            'event_id'        => $event1->id,
            'tanggal'         => Carbon::now()->subDays(12)->format('Y-m-d'),
            'harga_penawaran' => 12000000,
            'pihak'           => 'sanggar',
            'catatan'         => 'Counter offer — termasuk 12 penari dan iringan gamelan lengkap.',
        ]);

        Negosiasi::create([
            'event_id'        => $event1->id,
            'tanggal'         => Carbon::now()->subDays(10)->format('Y-m-d'),
            'harga_penawaran' => 10000000,
            'pihak'           => 'klien',
            'catatan'         => 'Final offer dari klien, deal di 10 juta.',
            'is_deal'         => true,
        ]);

        // Sewa Kostum Event 1
        SewaKostum::create([
            'event_id'        => $event1->id,
            'vendor_id'       => $v1->id,
            'nama_kostum'     => 'Set Kostum Jaipong 12 penari',
            'jumlah'          => 12,
            'biaya_sewa'      => 1800000,
            'tanggal_ambil'   => Carbon::now()->addDays(7)->format('Y-m-d'),
            'tanggal_kembali' => Carbon::now()->addDays(11)->format('Y-m-d'),
            'status'          => 'dipesan',
        ]);

        SewaKostum::create([
            'event_id'        => $event1->id,
            'vendor_id'       => $v3->id,
            'nama_kostum'     => 'Set Gamelan Degung',
            'jumlah'          => 1,
            'biaya_sewa'      => 500000,
            'tanggal_ambil'   => Carbon::now()->addDays(9)->format('Y-m-d'),
            'tanggal_kembali' => Carbon::now()->addDays(11)->format('Y-m-d'),
            'status'          => 'dipesan',
        ]);

        // Keuangan Event 1
        KeuanganEvent::create([
            'event_id'            => $event1->id,
            'harga_deal'          => 10000000,
            'estimasi_konsumsi'   => 600000,
            'estimasi_transport'  => 400000,
            'estimasi_sewa_kostum' => 2300000,
            'estimasi_honor'      => 4800000,
            'real_konsumsi'       => 0,
            'real_transport'      => 0,
            'real_sewa_kostum'    => 2300000,
            'real_honor'          => 0,
        ]);

        // ══════════════════════════════════════════
        //  EVENT 2: Festival (Selesai)
        // ══════════════════════════════════════════

        $event2 = Event::create([
            'nama_event'    => 'Tampil di Festival Seni Budaya Bandung 2025',
            'jenis_acara'   => 'festival',
            'klien'         => 'Dinas Kebudayaan Kota Bandung',
            'lokasi'        => 'Lapangan Gasibu, Bandung',
            'tanggal_event' => Carbon::now()->subDays(30)->format('Y-m-d'),
            'waktu_mulai'   => '10:00',
            'waktu_selesai' => '12:00',
            'status'        => 'selesai',
            'status_bayar'  => 'lunas',
            'nominal_dp'    => 5000000,
        ]);

        Negosiasi::create([
            'event_id'        => $event2->id,
            'tanggal'         => Carbon::now()->subDays(60)->format('Y-m-d'),
            'harga_penawaran' => 15000000,
            'pihak'           => 'sanggar',
            'catatan'         => 'Paket full: Tari Merak + Gamelan Degung.',
            'is_deal'         => true,
        ]);

        SewaKostum::create([
            'event_id'        => $event2->id,
            'vendor_id'       => $v2->id,
            'nama_kostum'     => 'Set Kostum Tari Merak 7 putri',
            'jumlah'          => 7,
            'biaya_sewa'      => 2100000,
            'tanggal_ambil'   => Carbon::now()->subDays(32)->format('Y-m-d'),
            'tanggal_kembali' => Carbon::now()->subDays(28)->format('Y-m-d'),
            'status'          => 'dikembalikan',
        ]);

        KeuanganEvent::create([
            'event_id'            => $event2->id,
            'harga_deal'          => 15000000,
            'estimasi_konsumsi'   => 800000,
            'estimasi_transport'  => 500000,
            'estimasi_sewa_kostum' => 2100000,
            'estimasi_honor'      => 6000000,
            'real_konsumsi'       => 750000,
            'real_transport'      => 450000,
            'real_sewa_kostum'    => 2100000,
            'real_honor'          => 6000000,
        ]);
    }
}
