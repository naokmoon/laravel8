<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use function PHPSTORM_META\map;

class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->paragraph(5, true),
            'created_at' => $this->faker->dateTimeBetween('-3 months'),
        ];
    }

    /**
     * Create a dummy BlogPost from Factory
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function dummyTest()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'New title',
                'content' => 'Content of the blog post'
            ];
        });
    }
}
