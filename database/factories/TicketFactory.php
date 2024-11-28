<?php

namespace Database\Factories;

use App\Models\Ticket;
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
        $users = User::all();
        $ids = $users->pluck('id');

        return [
            'title' => $this->faker->sentence ,
            'description' => $this->faker->paragraph ,
            'deadline' => $this->faker->date() ,
            'status' => $this->faker->randomElement(['pending' , 'ongoing' , 'finished']) ,
            'assigned_user_id' => $this->faker->randomElement($ids),
            'user_id' => $this->faker->randomElement($ids),

        ];
    }
}
