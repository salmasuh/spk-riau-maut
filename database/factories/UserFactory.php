<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'       => $this->faker->name(),
            'username'   => $this->faker->unique()->userName(),
            'password'   => Hash::make('Password123'),  // gunakan default password
            'role'       => 'staf',                     // default role
            'status'     => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}