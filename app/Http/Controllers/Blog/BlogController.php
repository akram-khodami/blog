<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Auth;
use DB;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /**
         * select `categories`.*, (select count(*) from `posts` inner join `category_post` on `posts`.`id` = `category_post`.`post_id` where `categories`.`id` = `category_post`.`category_id` and `published` = ?) as `posts_count` from `categories`
         */
        $categories = Category::withCount([
            'posts' => function ($query) {
                $query->where('published', 1);  // Count only published posts
            }
        ])->get();//دسته بندی ها


        $data['active'] = 'blog';
        $data['title'] = 'فهرست پست ها';
        $data['categories'] = $categories;
        $data['posts'] = Post::orderBy("created_at", "desc")->where('published', '=', 1)->paginate(10);

        return view("blog.post.all", $data);

    }

    public function post($id)
    {
        $post = Post::findOrFail($id);//post.published should be active

        /**
         * select `categories`.*, (select count(*) from `posts` inner join `category_post` on `posts`.`id` = `category_post`.`post_id` where `categories`.`id` = `category_post`.`category_id` and `published` = ?) as `posts_count` from `categories`
         */
        $categories = Category::withCount([
            'posts' => function ($query) {
                $query->where('published', 1);  // Count only published posts
            }
        ])->get();//دسته بندی ها

        $data['active'] = 'blog';
        $data['user'] = Auth::user();
        $data['title'] = $post->title;
        $data['post'] = $post;//اطلاعات نوشته
        $data['categories'] = $categories;
        $data['posts'] = Post::where([['id', '!=', $id], ['published', '=', 1]])->orderBy("created_at", "desc")->limit(5)->get();//5 نوشته اخیر
        $data['comments'] = Comment::where([['post_id', '=', $id], ['confirmed', '=', 1]])->paginate(10);//نظرات تایید شده این نوشته

        return view("blog.post.post", $data);

    }

    public function storeComment()
    {
        Comment::create([
            'content' => request('content'),
            'name' => request('name'),
            'email' => request('email'),
            'user_id' => Auth::user()->id,
            'post_id' => request('post_id'),
        ]);

        return redirect()->back()->with("success_message", "نظر با موفقیت ثبت شد.");

    }

    public function category_posts($category_id)
    {

        /**
         * select * from `posts` inner join `category_post` on `posts`.`id` = `category_post`.`post_id` where `category_post`.`category_id` = ?
         */
        $category = Category::find($category_id);
        $posts = $category->posts()->paginate();

        /**
         * select `categories`.*, (select count(*) from `posts` inner join `category_post` on `posts`.`id` = `category_post`.`post_id` where `categories`.`id` = `category_post`.`category_id` and `published` = ?) as `posts_count` from `categories`
         */
        $categories = Category::withCount([
            'posts' => function ($query) {
                $query->where('published', 1);  // Count only published posts
            }
        ])->get();//دسته بندی ها


        $data['title'] = 'پست های ' . $category->title;
        $data['active'] = 'blog';
        $data['categories'] = $categories;
        $data['posts'] = $posts;
        $data['user'] = Auth::user();

        return view("blog.post.all", $data);

    }
}
