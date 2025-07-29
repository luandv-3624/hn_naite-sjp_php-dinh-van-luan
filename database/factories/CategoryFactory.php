<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
             'name' => $this->faker->word,
             'type' => $this->faker->randomElement(['expense', 'income', 'debt_loan']),
             'category_parent_id' => null,
             'created_by' => 1,
             'default' => true,
         ];
    }
}
