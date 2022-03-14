<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Courier;
use App\Models\Order;
use App\Models\User;
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
        User::factory(9)->create();
        User::factory(1)->create([
            'name' => 'Admin Admin',
            'phone' => '9999999999',
            'role_id' => 1
        ]);
        Order::factory(12)->create();
        Courier::factory(5)->create();
    }
}
