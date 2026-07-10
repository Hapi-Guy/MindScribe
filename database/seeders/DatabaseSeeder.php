<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
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
        $categories = [
            'Web Programming Lab',
            'Operating Systems',
            'Embedded Systems and IoT',
            'Applied Stat',
            'Database Systems',
            'Information Systems Design',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        User::factory()->create([
            'name' => 'Dummy',
            'username' => 'dummy',
            'email' => 'dummy@example.com',
        ]);

//        Post::factory(100)->create();
    }
}
