<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            ['name' => 'Gramedia Pustaka Utama', 'address' => 'Jakarta', 'phone' => '021-53650110', 'email' => 'info@gramedia.com'],
            ['name' => 'Erlangga', 'address' => 'Jakarta', 'phone' => '021-8717006', 'email' => 'info@erlangga.co.id'],
            ['name' => 'Mizan', 'address' => 'Bandung', 'phone' => '022-7834310', 'email' => 'info@mizan.com'],
            ['name' => 'Penerbit Republika', 'address' => 'Jakarta', 'phone' => '021-7803747', 'email' => 'info@republika.co.id'],
            ['name' => 'Bentang Pustaka', 'address' => 'Yogyakarta', 'phone' => '0274-889836', 'email' => 'info@bentangpustaka.com'],
            ['name' => 'Kompas Media', 'address' => 'Jakarta', 'phone' => '021-5347710', 'email' => 'info@kompas.com'],
            ['name' => 'Yudhistira', 'address' => 'Jakarta', 'phone' => '021-8401255', 'email' => 'info@yudhistira.com'],
            ['name' => 'Tiga Serangkai', 'address' => 'Solo', 'phone' => '0271-714344', 'email' => 'info@tigaserangkai.co.id'],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }
    }
}
