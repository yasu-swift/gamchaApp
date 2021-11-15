<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $game_name = ['ファイナルファンタジー', 'ドラクエ', 'Minecraft', 'Fortnite', 'リターナル', 'ディスガイア', 'ポケモン', '天稲のサクナヒメ', 'モンスターハンター', '麻雀', 'マインスイーパー', 'ピンボール', 'スマブラ', 'マリオカート'];
        $file = $this->faker->image();
        $fileName = basename($file);
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'likeGame' => $game_name[array_rand($game_name)],
            'profirle' => $this->faker->realText(100),
            'avatar' => $fileName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
