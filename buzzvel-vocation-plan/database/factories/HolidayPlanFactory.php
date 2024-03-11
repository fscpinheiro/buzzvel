<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HolidayPlan>
 */
class HolidayPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->date,
            'location' => $this->faker->address,
            'participants' => $this->generateParticipants(),
        ];
    }

    private function generateParticipants()
    {
        $participants = [];
        $numParticipants = rand(1, 5);

        for ($i = 0; $i < $numParticipants; $i++) {
            $participants[] = $this->faker->name;
        }

        return implode(', ', $participants);
    }
}
