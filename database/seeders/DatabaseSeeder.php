<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            [ 'email' => 'admin@demo.com' ],
            [
                'name' => 'Sys Admin',
                'email' => 'admin@demo.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);

        User::firstOrCreate(
            [ 'email' => 'customer@demo.com' ],
            [
                'name' => 'Customer 01',
                'email' => 'customer@demo.com',
                'role' => 'customer',
            'password' => bcrypt('password'),
        ]);

        User::firstOrCreate(
            [ 'email' => 'customer@example.com' ],
            [
                'name' => 'Another Customer',
                'email' => 'customer@example.com',
                'role' => 'customer',
            'password' => bcrypt('password'),
        ]);

        $this->call(ProductsTableSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
