<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Rack;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $titles = [
            'Laskar Pelangi', 'Bumi Manusia', 'Negeri 5 Menara', 'Sang Pemimpi',
            'Perahu Kertas', 'Dilan 1990', 'Filosofi Teras', 'Atomic Habits',
            'Sapiens', 'Laut Bercerita', 'Cantik Itu Luka', 'Ronggeng Dukuh Paruk',
            'Siti Nurbaya', 'Tenggelamnya Kapal Van Der Wijck', 'Ayat-Ayat Cinta',
            'Ketika Cinta Bertasbih', 'Matematika Dasar', 'Fisika Modern',
            'Kimia Organik', 'Biologi Sel', 'Sejarah Indonesia', 'Bahasa Inggris',
            'Pemrograman Java', 'Algoritma dan Struktur Data', 'Jaringan Komputer',
            'Basis Data', 'Desain Grafis', 'Akuntansi Dasar', 'Ekonomi Mikro',
            'Sosiologi Pendidikan', 'Psikologi Remaja', 'Seni Budaya',
        ];

        $authors = [
            'Andrea Hirata', 'Pramoedya Ananta Toer', 'Ahmad Fuadi',
            'Tere Liye', 'Dee Lestari', 'Pidi Baiq', 'Henry Manampiring',
            'James Clear', 'Yuval Noah Harari', 'Leila S. Chudori',
            'Eka Kurniawan', 'Ahmad Tohari', 'Marah Rusli', 'Hamka',
            'Habiburrahman El Shirazy', 'Prof. Dr. Sukirno', 'Dr. Halliday',
        ];

        $totalQty = fake()->numberBetween(3, 20);

        return [
            'book_code' => 'BK' . fake()->unique()->numerify('########'),
            'isbn' => fake()->unique()->isbn13(),
            'title' => fake()->randomElement($titles) . ' ' . fake()->optional(0.3)->word(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'author' => fake()->randomElement($authors),
            'publisher_id' => Publisher::inRandomOrder()->first()?->id,
            'publish_year' => fake()->numberBetween(2010, 2026),
            'rack_id' => Rack::inRandomOrder()->first()?->id,
            'total_qty' => $totalQty,
            'available_qty' => fake()->numberBetween(1, $totalQty),
            'description' => fake()->paragraph(3),
            'status' => 'available',
        ];
    }
}
