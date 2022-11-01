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
            'password' => '$2y$10$o8wb83Lc4Q/BxwbnXBgUz.S6W.KLZDnvDmHdKAZn4vsyvrEMw0Mha', // secret123
            'remember_token' => Str::random(10),
        ];
    }


    public function johnDoe()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'John Doe',
                'email' => 'john@laravel.test'
            ];
        });
    }
}
