<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JoinUser;
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
        \App\Models\User::factory(5)->create();
        $this->call(CategorySeeder::class);
        \App\Models\Room::factory(5)->create();
        \App\Models\Comment::factory(40)->create();
    }
}
