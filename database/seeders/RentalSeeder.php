<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Clothe;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT DATA USER (5 ORANG)
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Staff (2 Orang)
        User::create([
            'name' => 'Staff Gudang 1',
            'email' => 'staff1@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);
        User::create([
            'name' => 'Staff Gudang 2',
            'email' => 'staff2@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        // Client (2 Orang)
        User::create([
            'name' => 'Budi Client',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);
        User::create([
            'name' => 'Siti Client',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // 2. BUAT KATEGORI
        $anime = Category::create([
            'name' => 'Anime',
            'slug' => Str::slug('Anime')
        ]);

        $game = Category::create([
            'name' => 'Game',
            'slug' => Str::slug('Game')
        ]);

        // 3. BUAT DATA PAKAIAN (10 KOSTUM)
        $clothes = [
            [
                'category_id' => $anime->id,
                'character_name' => 'Naruto Uzumaki',
                'series_name' => 'Naruto Shippuden',
                'size' => 'M',
                'price_per_day' => 50000,
                'stock' => 3,
                'include_items' => 'Baju, Celana, Ikat Kepala'
            ],
            [
                'category_id' => $anime->id,
                'character_name' => 'Monkey D. Luffy',
                'series_name' => 'One Piece',
                'size' => 'L',
                'price_per_day' => 45000,
                'stock' => 5,
                'include_items' => 'Topi Jerami, Kemeja Merah, Celana'
            ],
            [
                'category_id' => $anime->id,
                'character_name' => 'Tanjiro Kamado',
                'series_name' => 'Demon Slayer',
                'size' => 'M',
                'price_per_day' => 60000,
                'stock' => 2,
                'include_items' => 'Haori, Seragam Kimetsu, Anting'
            ],
            [
                'category_id' => $game->id,
                'character_name' => 'Raiden Shogun',
                'series_name' => 'Genshin Impact',
                'size' => 'S',
                'price_per_day' => 85000,
                'stock' => 1,
                'include_items' => 'Kimono, Aksesoris Rambut, Obi'
            ],
            [
                'category_id' => $game->id,
                'character_name' => 'Zhongli',
                'series_name' => 'Genshin Impact',
                'size' => 'XL',
                'price_per_day' => 75000,
                'stock' => 2,
                'include_items' => 'Jas Formal, Sarung Tangan, Wig'
            ],
            [
                'category_id' => $anime->id,
                'character_name' => 'Rem',
                'series_name' => 'Re:Zero',
                'size' => 'S',
                'price_per_day' => 55000,
                'stock' => 4,
                'include_items' => 'Baju Maid, Headpiece, Kaos Kaki'
            ],
            [
                'category_id' => $anime->id,
                'character_name' => 'Gojo Satoru',
                'series_name' => 'Jujutsu Kaisen',
                'size' => 'L',
                'price_per_day' => 50000,
                'stock' => 6,
                'include_items' => 'Seragam Sekolah, Penutup Mata, Wig'
            ],
            [
                'category_id' => $game->id,
                'character_name' => 'Cloud Strife',
                'series_name' => 'Final Fantasy VII',
                'size' => 'M',
                'price_per_day' => 90000,
                'stock' => 2,
                'include_items' => 'Kostum Fullset, Buster Sword (Prop)'
            ],
            [
                'category_id' => $anime->id,
                'character_name' => 'Mikasa Ackerman',
                'series_name' => 'Attack on Titan',
                'size' => 'M',
                'price_per_day' => 55000,
                'stock' => 3,
                'include_items' => 'Jaket Survey Corps, Syal, Celana'
            ],
            [
                'category_id' => $game->id,
                'character_name' => 'Kratos',
                'series_name' => 'God of War',
                'size' => 'XL',
                'price_per_day' => 100000,
                'stock' => 1,
                'include_items' => 'Kostum Armor, Kapak Leviathan (Prop)'
            ],
        ];

        foreach ($clothes as $item) {
            Clothe::create($item);
        }
    }
}