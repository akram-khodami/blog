<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Property;
use App\Models\Tag;
use App\Models\Value;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(AdminUserSeeder::class);

        Product::factory(10)->create();
        Property::factory(5)->create();
        Value::factory(5)->create();

        Category::factory(5)->create();
        Tag::factory(5)->create();
        Post::factory(10)->create();
//        $this->call(PostSeeder::class);


        Comment::factory(10)->create();


    }
}
