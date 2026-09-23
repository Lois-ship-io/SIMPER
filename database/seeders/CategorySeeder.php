<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku cerita fiksi, novel, dan karya sastra'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku pengetahuan umum dan referensi'],
            ['name' => 'Sains', 'description' => 'Buku ilmu pengetahuan alam dan eksak'],
            ['name' => 'Teknologi', 'description' => 'Buku teknologi informasi dan komputer'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah nasional dan internasional'],
            ['name' => 'Agama', 'description' => 'Buku keagamaan dan spiritual'],
            ['name' => 'Bahasa', 'description' => 'Buku bahasa Indonesia dan asing'],
            ['name' => 'Matematika', 'description' => 'Buku matematika dan statistika'],
            ['name' => 'Sosial', 'description' => 'Buku ilmu sosial dan kemasyarakatan'],
            ['name' => 'Ensiklopedia', 'description' => 'Buku referensi dan ensiklopedia'],
            ['name' => 'Biografi', 'description' => 'Buku biografi dan autobiografi tokoh'],
            ['name' => 'Keterampilan', 'description' => 'Buku keterampilan dan kerajinan'],
        ];

        foreach ($categories as $category) {
            $category['slug'] = \Illuminate\Support\Str::slug($category['name']);
            Category::create($category);
        }
    }
}
