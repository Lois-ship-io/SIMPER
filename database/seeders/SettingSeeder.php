<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Peminjaman
            [
                'key' => 'loan_duration_days',
                'value' => '7',
                'type' => 'number',
                'group' => 'borrowing',
                'label' => 'Lama Pinjam (Hari)',
                'description' => 'Durasi maksimal peminjaman buku dalam hari',
            ],
            [
                'key' => 'max_books_per_loan',
                'value' => '3',
                'type' => 'number',
                'group' => 'borrowing',
                'label' => 'Maks. Buku per Peminjaman',
                'description' => 'Jumlah maksimal buku yang bisa dipinjam dalam sekali peminjaman',
            ],
            [
                'key' => 'max_active_loans',
                'value' => '2',
                'type' => 'number',
                'group' => 'borrowing',
                'label' => 'Maks. Peminjaman Aktif',
                'description' => 'Jumlah maksimal peminjaman aktif per anggota',
            ],

            // Denda
            [
                'key' => 'fine_per_day',
                'value' => '1000',
                'type' => 'number',
                'group' => 'fine',
                'label' => 'Denda per Hari (Rp)',
                'description' => 'Besaran denda per hari per buku keterlambatan',
            ],
            [
                'key' => 'max_fine_per_book',
                'value' => '50000',
                'type' => 'number',
                'group' => 'fine',
                'label' => 'Maks. Denda per Buku (Rp)',
                'description' => 'Batas maksimal denda per buku',
            ],

            // Aplikasi
            [
                'key' => 'app_name',
                'value' => 'SIMPER',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Aplikasi',
                'description' => 'Nama aplikasi yang ditampilkan',
            ],
            [
                'key' => 'school_name',
                'value' => 'SMA Negeri 1 Contoh',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Nama Sekolah',
                'description' => 'Nama sekolah untuk kop surat dan laporan',
            ],
            [
                'key' => 'school_address',
                'value' => 'Jl. Pendidikan No. 1, Kota Contoh',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Alamat Sekolah',
                'description' => 'Alamat sekolah untuk kop surat dan laporan',
            ],
            [
                'key' => 'school_phone',
                'value' => '021-1234567',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Telepon Sekolah',
                'description' => 'Nomor telepon sekolah',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
