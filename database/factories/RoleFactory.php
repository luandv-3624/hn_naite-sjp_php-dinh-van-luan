<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roles = ['admin', 'guest', 'user', 'premium_user'];

        return [
            'name' => $this->faker->unique()->randomElement($roles),
        ];
    }
}
