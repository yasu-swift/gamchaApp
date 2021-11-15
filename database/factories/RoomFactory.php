<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $game_name = ['ファイナルファンタジー', 'ドラクエ', 'Minecraft', 'Fortnite', 'リターナル', 'ディスガイア', 'ポケモン', '天稲のサクナヒメ', 'モンスターハンター', '麻雀', 'マインスイーパー', 'ピンボール', 'スマブラ', 'マリオカート'];
        $game_action = ['ストーリー進めます', 'だらだら遊びましょう', 'マルチ募集', 'レイド行きませんか？', '素材集めしましょう'];
        $text = $this->faker->realText(100);

        return [
            'title' => $game_name[array_rand($game_name)],
            'body' => $game_action[array_rand($game_action)],
            'joinUser' => rand(1, 4),
            'userLimit' => rand(4, 12),
            // 'category_id' => rand(1, 26),
            'category_id' => rand(1, 5),
        ];
        
    }
}
