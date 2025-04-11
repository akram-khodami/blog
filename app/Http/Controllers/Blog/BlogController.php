<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Services\CommentService;
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
        $data['comments'] = $post->comments()->confirmed()->paginate(10);

        return view("blog.post.post", $data);

    }

    public function storeComment(Request $request, CommentService $commentService)
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['error_message' => 'برای ثبت نظر باید وارد شوید.']);
        }

        // Validate input
        $validatedData = $request->validate([
            'content' => 'required|string|max:1000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        // Find the post
        $post = Post::findOrFail($validatedData['post_id']);

        // Create the comment
        if ($commentService->createComment($post, $validatedData, Auth::id())) {
            return redirect()->back()->with('success_message', 'نظر با موفقیت ثبت شد.');
        }

        return redirect()->back()->withErrors(['error_message' => 'نظر با موفقیت ثبت نشد. لطفاً دوباره تلاش کنید.']);
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
