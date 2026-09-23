<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            PublisherSeeder::class,
            RackSeeder::class,
            SettingSeeder::class,
        ]);

        \App\Models\Member::factory(50)->create();
        \App\Models\Book::factory(100)->create();
    }
}
