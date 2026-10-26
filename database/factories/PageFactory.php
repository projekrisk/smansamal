<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => '<p>'.fake()->paragraphs(3, true).'</p>',
            'meta_description' => fake()->sentence(10),
            'is_active' => true,
            'is_system' => false,
            'views_count' => fake()->numberBetween(0, 500),
        ];
    }
}
