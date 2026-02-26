<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\PendaftaranLes;
use App\Models\ReservasiPentas;
use App\Enums\PendaftaranStatus;
use App\Enums\BookingStatus;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──
        User::create([
            'name'         => 'Guru Seni Art-Hub',
            'email'        => 'admin@arthub.com',
            'password'     => bcrypt('admin123'),
            'role'         => 'admin',
            'no_whatsapp'  => '628123456789',
            'alamat'       => 'Jl. Seni Budaya No. 1, Bandung',
        ]);

        // ── Sample Members ──
        $member1 = User::create([
            'name'         => 'Siti Nurhaliza',
            'email'        => 'siti@email.com',
            'password'     => bcrypt('member123'),
            'role'         => 'member',
            'no_whatsapp'  => '628111222333',
            'alamat'       => 'Jl. Merdeka No. 10, Bandung',
        ]);

        $member2 = User::create([
            'name'         => 'Budi Santoso',
            'email'        => 'budi@email.com',
            'password'     => bcrypt('member123'),
            'role'         => 'member',
            'no_whatsapp'  => '628444555666',
            'alamat'       => 'Jl. Pahlawan No. 5, Sumedang',
        ]);

        // ── Kelas ──
        $kelas1 = Kelas::create([
            'nama_kelas' => 'Tari Jaipong Dasar',
            'kategori'   => 'tari',
            'deskripsi'  => 'Belajar dasar-dasar tari Jaipong khas Jawa Barat. Cocok untuk pemula usia 7-15 tahun.',
            'jadwal'     => 'Senin & Rabu, 15:00 - 17:00 WIB',
            'biaya'      => 250000,
            'kuota'      => 20,
        ]);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'Gamelan Degung',
            'kategori'   => 'musik',
            'deskripsi'  => 'Kursus alat musik Gamelan Degung khas Sunda. Teknik menabuh dan bermain ansambel.',
            'jadwal'     => 'Selasa & Kamis, 14:00 - 16:00 WIB',
            'biaya'      => 300000,
            'kuota'      => 15,
        ]);

        Kelas::create([
            'nama_kelas' => 'Tari Topeng Cirebon',
            'kategori'   => 'tari',
            'deskripsi'  => 'Mendalami seni tari topeng tradisional Cirebon. Level menengah.',
            'jadwal'     => 'Jumat, 15:00 - 17:30 WIB',
            'biaya'      => 275000,
            'kuota'      => 12,
        ]);

        Kelas::create([
            'nama_kelas' => 'Angklung Ensemble',
            'kategori'   => 'musik',
            'deskripsi'  => 'Bermain angklung secara berkelompok. Harmoni, tempo, dan koordinasi.',
            'jadwal'     => 'Sabtu, 09:00 - 11:00 WIB',
            'biaya'      => 200000,
            'kuota'      => 25,
        ]);

        Kelas::create([
            'nama_kelas' => 'Teater Tradisional',
            'kategori'   => 'teater',
            'deskripsi'  => 'Workshop teater tradisional, sandiwara, longser, dan seni peran klasik.',
            'jadwal'     => 'Sabtu, 13:00 - 15:30 WIB',
            'biaya'      => 225000,
            'kuota'      => 18,
        ]);

        // ── Sample Pendaftaran (★ Enum Status) ──
        PendaftaranLes::create([
            'user_id'        => $member1->id,
            'kelas_id'       => $kelas1->id,
            'tempat_lahir'   => 'Bandung',
            'tanggal_lahir'  => '2012-05-15',
            'asal_sekolah'   => 'SDN 1 Bandung',
            'nama_orang_tua' => 'Hj. Euis Komariah',
            'no_hp_ortu'     => '628999888777',
            'status'         => PendaftaranStatus::DITERIMA->value,
        ]);

        PendaftaranLes::create([
            'user_id'        => $member2->id,
            'kelas_id'       => $kelas2->id,
            'tempat_lahir'   => 'Sumedang',
            'tanggal_lahir'  => '2010-08-20',
            'asal_sekolah'   => 'SMPN 2 Sumedang',
            'nama_orang_tua' => 'Pak Dedi Suryadi',
            'no_hp_ortu'     => '628777666555',
            'status'         => PendaftaranStatus::MENUNGGU->value,
        ]);

        // ── Sample Booking (★ Enum Status) ──
        ReservasiPentas::create([
            'user_id'         => $member1->id,
            'jenis_acara'     => 'pernikahan',
            'tanggal_pentas'  => now()->addDays(14)->format('Y-m-d'),
            'waktu_mulai'     => '19:00',
            'waktu_selesai'   => '22:00',
            'durasi_jam'      => 3,
            'lokasi_acara'    => 'Gedung Serbaguna Bandung, Jl. Asia Afrika No. 50',
            'deskripsi_acara' => 'Pementasan tari Jaipong untuk resepsi pernikahan.',
            'status'          => BookingStatus::DISETUJUI->value,
        ]);

        ReservasiPentas::create([
            'user_id'         => $member2->id,
            'jenis_acara'     => 'festival',
            'tanggal_pentas'  => now()->addDays(30)->format('Y-m-d'),
            'waktu_mulai'     => '10:00',
            'waktu_selesai'   => '12:00',
            'durasi_jam'      => 2,
            'lokasi_acara'    => 'Alun-alun Sumedang',
            'deskripsi_acara' => 'Festival Seni Budaya Sumedang.',
            'status'          => BookingStatus::MENUNGGU->value,
        ]);
    }
}
