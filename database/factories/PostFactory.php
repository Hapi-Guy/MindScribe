<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $temp = fake()->sentence();
        return [
            //
            'image' => fake()->imageUrl(),
            'title' => $temp,
            'slug' => \Illuminate\Support\Str::slug($temp),
            'content' => fake()->paragraph(5),
            'category_id' => Category::inRandomOrder(10)->first()->id,
            'user_id' => 1,
            'published_at' => fake()->optional()->dateTime(),
        ];
    }
}
