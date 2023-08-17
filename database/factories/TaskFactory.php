<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_ids = User::all('id');
        $total_count = count($user_ids);
        $user_index = fake()->numberBetween(0, $total_count - 1);

        return [
            'title' => fake()->jobTitle(),
            'description' => fake()->sentence(30),
            'date_due' => fake()->date(),
            'is_completed' => fake()->boolean,
            'user_id' => $user_ids[$user_index],
        ];
    }
}
