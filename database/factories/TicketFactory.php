<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $statuses = ['pending' , 'ongoing' , 'finished'];
    public function definition(): array
    {

        return [
            'title' => $this->faker->sentence ,
            'description' => $this->faker->paragraph ,
            'deadline' => $this->faker->date() ,
            'status' => $this->faker->randomElement(['pending' , 'ongoing' , 'finished']) ,
            'assigned_user' => User::factory(),
            'user_id' => User::factory(),

        ];
    }
}
