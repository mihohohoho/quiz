<?php

use Illuminate\Database\Seeder;

class RanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \DB::table('ranks')->insert([
        [
            'id' => '1',
            'rank_name' => '赤ちゃん',
            'judge' => '0',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
         ],
        [
            'id' => '2',
            'rank_name' => '一般人',
            'judge' => '1',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ],
        [
            'id' => '3',
            'rank_name' => 'ちょっと詳しい人',
            'judge' => '2',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ],
        [
            'id' => '4',
            'rank_name' => '一人前の韓国ファン',
            'judge' => '3',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ],
        [
            'id' => '5',
            'rank_name' => '専門家',
            'judge' => '4',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ],
        [
            'id' => '6',
            'rank_name' => 'マスター',
            'judge' => '5',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ],
    ]);
    }
}
