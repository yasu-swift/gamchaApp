<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!DB::table('categories')->first()) {
            DB::table('categories')->insert([
                ['name' => 'モンハン'],
                ['name' => 'Apex'],
                ['name' => 'マインクラフト'],
                ['name' => 'スプラトゥーン'],
                ['name' => 'パズドラ'],
                ['name' => 'モンスト'],
                ['name' => 'スマホゲーム'],
                ['name' => 'PCゲーム'],
                ['name' => 'FPS'],
                ['name' => 'TPS'],
                ['name' => 'シューティング'],
                ['name' => 'アクションゲーム'],
                ['name' => '対戦ゲーム'],
                ['name' => 'RPG'],
                ['name' => 'アクションRPG'],
                ['name' => 'シミュレーション'],
                ['name' => 'アドベンチャー'],
                ['name' => 'ホラーゲーム'],
                ['name' => 'レースゲーム'],
                ['name' => 'パズルゲーム'],
                ['name' => 'サンドボックス'],
                ['name' => '音楽ゲーム'],
                ['name' => 'テーブルゲーム'],
                ['name' => 'ボードゲーム'],
                ['name' => 'カードゲーム'],
                ['name' => 'その他'],
            ]);
        }
    }
}
