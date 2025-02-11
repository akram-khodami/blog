<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++) {

            DB::table('posts')->insert(
                [
                    'title' => 'test',
                    'content' => 'test',
                    'slug' => 'test',
                    'published' => 1,
                    'active_comment' => 0,
                    'user_id' => 1

                ]
            );

        }

    }
}
