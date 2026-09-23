<?php

namespace Database\Seeders;

use App\Models\Rack;
use Illuminate\Database\Seeder;

class RackSeeder extends Seeder
{
    public function run(): void
    {
        $racks = [
            ['code' => 'R-001', 'name' => 'Rak A1', 'location' => 'Lantai 1 - Kiri', 'description' => 'Rak untuk buku fiksi'],
            ['code' => 'R-002', 'name' => 'Rak A2', 'location' => 'Lantai 1 - Kiri', 'description' => 'Rak untuk buku non-fiksi'],
            ['code' => 'R-003', 'name' => 'Rak B1', 'location' => 'Lantai 1 - Tengah', 'description' => 'Rak untuk buku sains'],
            ['code' => 'R-004', 'name' => 'Rak B2', 'location' => 'Lantai 1 - Tengah', 'description' => 'Rak untuk buku teknologi'],
            ['code' => 'R-005', 'name' => 'Rak C1', 'location' => 'Lantai 1 - Kanan', 'description' => 'Rak untuk buku sejarah'],
            ['code' => 'R-006', 'name' => 'Rak C2', 'location' => 'Lantai 1 - Kanan', 'description' => 'Rak untuk buku agama'],
            ['code' => 'R-007', 'name' => 'Rak D1', 'location' => 'Lantai 2 - Kiri', 'description' => 'Rak untuk buku bahasa'],
            ['code' => 'R-008', 'name' => 'Rak D2', 'location' => 'Lantai 2 - Kiri', 'description' => 'Rak untuk buku matematika'],
            ['code' => 'R-009', 'name' => 'Rak E1', 'location' => 'Lantai 2 - Tengah', 'description' => 'Rak untuk ensiklopedia'],
            ['code' => 'R-010', 'name' => 'Rak E2', 'location' => 'Lantai 2 - Kanan', 'description' => 'Rak untuk buku referensi'],
        ];

        foreach ($racks as $rack) {
            Rack::create($rack);
        }
    }
}
