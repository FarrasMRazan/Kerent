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
    // public function run(): void
    // {
    //     // Buat Admin
    //     \App\Models\User::create([
    //         'name' => 'Admin Utama',
    //         'email' => 'admin@rental.com',
    //         'password' => bcrypt('password'),
    //         'role' => 'admin',
    //     ]);

    //     // Buat Staff
    //     \App\Models\User::create([
    //         'name' => 'Staff Operasional',
    //         'email' => 'staff@rental.com',
    //         'password' => bcrypt('password'),
    //         'role' => 'staff',
    //     ]);

    //     // Buat Client
    //     \App\Models\User::create([
    //         'name' => 'Budi Client',
    //         'email' => 'client@gmail.com',
    //         'password' => bcrypt('password'),
    //         'role' => 'client',
    //     ]);
    // }
    // public function run(): void
    // {
    //     // 1. Buat Kategori Master
    //     $anime = \App\Models\Category::create(['name' => 'Anime', 'slug' => 'anime']);
    //     $game = \App\Models\Category::create(['name' => 'Game', 'slug' => 'game']);

    //     // 2. Buat Data Master Baju Kosplay
    //     \App\Models\Clothe::create([
    //         'category_id' => $game->id,
    //         'character_name' => 'Raiden Shogun',
    //         'series_name' => 'Genshin Impact',
    //         'size' => 'M',
    //         'include_items' => 'Kimono, Obi, Wig, Hairpin',
    //         'price_per_day' => 150000,
    //         'stock' => 3,
    //     ]);

    //     // 3. Buat User untuk 3 Role
    //     \App\Models\User::create([
    //         'name' => 'Admin Rental',
    //         'email' => 'admin@test.com',
    //         'password' => bcrypt('password'),
    //         'role' => 'admin',
    //     ]);
        
    //     \App\Models\User::create([
    //         'name' => 'Staff Toko',
    //         'email' => 'staff@test.com',
    //         'password' => bcrypt('password'),
    //         'role' => 'staff',
    //     ]);

    //     \App\Models\User::create([
    //         'name' => 'Client Wibu',
    //         'email' => 'client@test.com',
    //         'password' => bcrypt('password'),
    //         'role' => 'client',
    //     ]);
    // }
    public function run(): void
    {
        $this->call([
            RentalSeeder::class,
        ]);
    }
}
