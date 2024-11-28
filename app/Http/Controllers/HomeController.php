<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Slider;
use App\Models\Tag;
use Illuminate\Http\Request;

use App\Models\Post;

class HomeController extends Controller
{
    function index()
    {
        $data['title'] = 'خانه';
        $data['tags'] = Tag::all();
        $data['slider1'] = Slider::where([['slider_type', '=', 1], ['active', '=', 1]])->get();
        $data['slider2'] = Slider::where([['slider_type', '=', 2], ['active', '=', 1]])->get();
        $data['posts'] = Post::where('published', '=', 1)->orderBy("created_at", "desc")->paginate(5);


        /**
         * select `categories`.*, (select count(*) from `posts` inner join `category_post` on `posts`.`id` = `category_post`.`post_id` where `categories`.`id` = `category_post`.`category_id` and `published` = ?) as `posts_count` from `categories`
         */
        $categories = Category::withCount([
            'posts' => function ($query) {
                $query->where('published', 1);  // Count only published posts
            }
        ])->get();//دسته بندی ها

        $data['categories'] = $categories;


        return view("blog.home", $data);

    }

}
