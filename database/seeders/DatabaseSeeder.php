<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //gonna create a user before exec cat seeder or post seeder so that it don't throw error
        $user = User::factory()->create([
            'name' => 'DummyUser',
            'email' => 'dummy@example.com',
        ]);


        // to create categories and post into DB
        $categories=[
            'Web Programming Lab',
            'Operating Systems',
            'Embedded Systems and IoT',
            'Applied Stat',
            'Database Systems',
            'Information Systems and Design'
        ];
        foreach($categories as $category){
            Category::create([
                'name' => $category,
            ]);
        }
        Post::factory(100)->create();

        // $this->call([
        //     PostSeeder::class
        // ]);
    }
}
