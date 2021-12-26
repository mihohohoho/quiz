<?php

use Illuminate\Database\Seeder;

class QuizzesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        factory(App\Quiz::class, 5)->create();
        //
        /*DB::table('quizzes')->insert([
            'title' => '命名の心得',
            'body' => '命名はデータを基準に考える',
        ]);*/
    }
}
