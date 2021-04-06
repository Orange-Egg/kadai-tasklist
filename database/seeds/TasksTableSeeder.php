<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // taskでなくcontentのままにする
        // DB::table('tasks')->insert([
            // 'status' => 'test status 1',
            // 'content' => 'test task 1'
        // ]);
        // DB::table('tasks')->insert([
            // 'status' => 'test status 2',
            // 'content' => 'test task 2'
        // ]);
        // DB::table('tasks')->insert([
            // 'status' => 'test status 3',
            // 'content' => 'test task 3'
        // ]);
        
        // forループで大量にデータを作る
        for($i = 1; $i <= 100; $i++) {
            DB::table('tasks')->insert([
                'status' => 'test status ' . $i,
                'content' => 'test content ' . $i
            ]);
        }
    }
}
