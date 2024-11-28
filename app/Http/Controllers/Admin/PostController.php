<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Auth;
use Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['posts'] = Post::orderBy("created_at", "desc")->paginate(10);

        $data['title'] = 'فهرست پست ها';

        $data['categories'] = Category::all();

        $data['active'] = 'posts';

        return view("admin.post.all", $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['active'] = 'posts';
        $data['title'] = 'ایجاد پست';

        $data['tags'] = Tag::all();
        $data['categories'] = Category::all();

        return view("admin.post.create", $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        if ($request->hasFile(key: 'image')) {

            $image = $request->file('image');

            $path = $image->storeAs(
                'public/uploads/post/images',
                time() . '.' . $image->extension()
            );

        } else {

            $path = NULL;

        }

        $post = Post::create([
            'title' => request('title'),
            'published' => request('show', '1'),
            'content' => request('content'),
            'slug' => request('title'),
            'user_id' => Auth::user()->id,
            'image' => $path
        ]);

        $post->categories()->attach(request('categories'));

        $post->tags()->attach(request('tags'));

        return redirect('posts/' . $post->id . '/edit')->with("success_message", "پست با موفقیت ثبت شد.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        \DB::enableQueryLog(); // Enable query log

        $data['post'] = $post;
        $data['active'] = 'posts';
        $data['title'] = 'ویرایش پست';

        $data['tags'] = Tag::all();
        $data['categories'] = Category::all();

        $data['post_tags'] = $post->tags->pluck('id')->toArray();
        $data['post_categories'] = $post->categories->pluck('id')->toArray();

        // dd(\DB::getQueryLog()); // Show results of log

        return view("admin.post.create", $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        \DB::enableQueryLog(); // Enable query log

        if ($request->hasFile(key: 'image')) {

            $image = $request->file('image');

            $path = $image->storeAs(
                'public/uploads/post/images',
                time() . '.' . $image->extension()
            );

            $post->image = $path;


        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->published = request('show', '1');
        $post->slug = $request->title;
        $post->save();

        $post->categories()->detach(request('categories[]'));
        $post->categories()->attach(request('categories'));

        $post->tags()->detach(ids: request('tags[]'));
        $post->tags()->attach(request('tags'));

        // dd(\DB::getQueryLog()); // Show results of log
        return redirect()->back()->with('success_message', 'این مطلب با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // DB::transaction(function ($post) {

        $post->categories()->detach();

        $post->delete();

        // });

        return redirect()->back()->with('success_message', 'مطلب با موفقیت حذف شد.');

    }

    public function destroyAll()
    {
        DB::table('category_post')->truncate();

        DB::table('posts')->delete();

        return redirect()->back()->with('success_message', 'تمامی نوشته ها با موفقیت حذف شدند.');

    }


    public function get_post_comments()
    {
        $post_id = request('id');

        $confirmed = request('confirmed');

        $filter[] = ['post_id', '=', $post_id];

        if (in_array($confirmed, [0, 1])) {

            $filter[] = ['confirmed', '=', $confirmed];

        }

        $comments = Comment::where($filter)->paginate(10);

        $data['active'] = 'posts';

        return view('admin.post.post_comments', compact('comments'));

    }
}
