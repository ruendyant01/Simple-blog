<?php

namespace Database\Factories;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            "title" => fake()->name(),
            "body" => fake()->text(),
            "image" => UploadedFile::fake()->image("photo.png", 50,50)->size(200)
        ];
    }
}
