<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Fish;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@fishbid.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat beberapa user biasa
        $user1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Buat beberapa pedagang
        $pedagang1 = User::create([
            'name' => 'Joko Nelayan',
            'email' => 'joko@example.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
        ]);

        $pedagang2 = User::create([
            'name' => 'Dewi Laut',
            'email' => 'dewi@example.com',
            'password' => Hash::make('password'),
            'role' => 'pedagang',
        ]);

        // Buat beberapa ikan
        $fish1 = Fish::create([
            'user_id' => $pedagang1->id,
            'name' => 'Tuna Sirip Kuning',
            'description' => 'Tuna sirip kuning segar hasil tangkapan nelayan lokal. Cocok untuk sashimi atau dimasak.',
            'species' => 'Tuna',
            'weight' => 5.2,
            'base_price' => 250000,
            'status' => 'auction',
        ]);

        $fish2 = Fish::create([
            'user_id' => $pedagang1->id,
            'name' => 'Kerapu Macan',
            'description' => 'Kerapu macan segar dengan kualitas premium. Daging tebal dan lembut.',
            'species' => 'Kerapu',
            'weight' => 3.8,
            'base_price' => 180000,
            'status' => 'auction',
        ]);

        $fish3 = Fish::create([
            'user_id' => $pedagang2->id,
            'name' => 'Kakap Merah',
            'description' => 'Kakap merah segar dengan daging putih yang lembut. Cocok untuk berbagai masakan.',
            'species' => 'Kakap',
            'weight' => 2.5,
            'base_price' => 120000,
            'status' => 'auction',
        ]);

        $fish4 = Fish::create([
            'user_id' => $pedagang2->id,
            'name' => 'Salmon Norwegia',
            'description' => 'Salmon impor dari Norwegia dengan kualitas terbaik. Cocok untuk sashimi atau dimasak.',
            'species' => 'Salmon',
            'weight' => 4.0,
            'base_price' => 350000,
            'status' => 'available',
        ]);

        // Buat beberapa lelang
        $auction1 = Auction::create([
            'fish_id' => $fish1->id,
            'user_id' => $pedagang1->id,
            'start_price' => 250000,
            'current_price' => 250000,
            'min_bid' => 10000,
            'start_time' => Carbon::now()->subHours(2),
            'end_time' => Carbon::now()->addDays(3),
            'status' => 'active',
        ]);

        $auction2 = Auction::create([
            'fish_id' => $fish2->id,
            'user_id' => $pedagang1->id,
            'start_price' => 180000,
            'current_price' => 200000, // Sudah ada bid
            'min_bid' => 10000,
            'start_time' => Carbon::now()->subHours(5),
            'end_time' => Carbon::now()->addDays(2),
            'status' => 'active',
        ]);

        $auction3 = Auction::create([
            'fish_id' => $fish3->id,
            'user_id' => $pedagang2->id,
            'start_price' => 120000,
            'current_price' => 120000,
            'min_bid' => 5000,
            'start_time' => Carbon::now()->addDays(1),
            'end_time' => Carbon::now()->addDays(4),
            'status' => 'upcoming',
        ]);

        // Buat beberapa bid
        Bid::create([
            'auction_id' => $auction2->id,
            'user_id' => $user1->id,
            'amount' => 190000,
        ]);

        Bid::create([
            'auction_id' => $auction2->id,
            'user_id' => $user2->id,
            'amount' => 200000,
        ]);
    }
}
