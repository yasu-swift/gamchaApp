<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\User;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->realText(20),
            'user_id' => Arr::random(Arr::pluck(User::all(), 'id')),
            // 'name' => Arr::random(Arr::pluck(User::all(), 'name')),
            'room_id' => Arr::random(Arr::pluck(Room::all(), 'id')),
            
        ];
    }
}
