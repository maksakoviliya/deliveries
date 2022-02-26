<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::factory(9)->create();
         \App\Models\User::factory(1)->create([
             'email' => 'admin@admin.admin',
             'role_id' => 1
         ]);
         \App\Models\Order::factory(12)->create();
    }
}
