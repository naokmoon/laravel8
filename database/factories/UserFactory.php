<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$3ZrYOZCa1beRgcBE3kLF5uNnxYtgfr4h/eyepAxQJRXESQOXNbx6W', // secret123
            'remember_token' => Str::random(10),
            'is_admin' => false
        ];
    }

    /**
     * Create John Doe user
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function johnDoe()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'John Doe',
                'email' => 'john@laravel.test',
                'is_admin' => true
            ];
        });
    }
}
