<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Traits\AuthorizationsTrait;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Request;

class PostController extends Controller
{
    use AuthorizationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('managePosts', Post::class);

        // $data['posts'] = Post::orderBy("created_at", "desc")->withTrashed()->paginate(10);
        $data['posts'] = Post::orderBy("created_at", "desc")->paginate(10);


        $data['title'] = 'فهرست پست ها';

        $data['categories'] = Category::all();

        $data['active'] = 'posts';

        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view("admin.post.all", $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Post::class);

        $data['active'] = 'posts';
        $data['title'] = 'ایجاد پست';

        $data['tags'] = Tag::all();
        $data['categories'] = Category::all();
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view("admin.post.create", $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //===start Policy===========================================================

        //===روش اول
        // $response = Gate::inspect('create', Post::class);

        // if (!$response->allowed()) {

        //     abort(403, '!اجازه ویرایش ندارید');

        // }

        //===روش دوم
        Gate::authorize('create', Post::class);

        //===روش سوم
        // if ($request->user()->cannot('create', Post::class)) {
        //     abort(403, '!اجازه ویرایش ندارید');
        // }

        //===end Policy===========================================================


        if ($request->hasFile(key: 'image')) {

            $request->validate(['iamge' => 'max:20']);

//            $image = $request->image;
            $image = $request->file('image');

//            $extension = $image->getClientOriginalExtension();
            $extension = $image->extension();

//            $originalName = $image->getClientOriginalName();

            $imageNewName = time() . '.' . $extension;

            $path = $image->storeAs('upload/images', $imageNewName);

        } else {

            $imageNewName = NULL;

        }

            $post = Post::create([
                'title' => request('title'),
                'published' => request('show', '1'),
                'content' => request('content'),
                'slug' => request('title'),
                'user_id' => Auth::user()->id,
                'image' => $imageNewName
            ]);

            $post->categories()->attach(request('categories'));

            $post->tags()->attach(request('tags'));

            return redirect('posts/' . $post->id . '/edit')->with("success_message", "پست با موفقیت ثبت شد.");

        }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if (!Gate::allows('show-post', $post)) {
            abort(403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        \DB::enableQueryLog(); // Enable query log

        $data['post'] = $post;
        $data['active'] = 'posts';
        $data['title'] = 'ویرایش پست';

        $data['tags'] = Tag::all();
        $data['categories'] = Category::all();

        $data['post_tags'] = $post->tags->pluck('id')->toArray();
        $data['post_categories'] = $post->categories->pluck('id')->toArray();
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        // dd(\DB::getQueryLog()); // Show results of log

        return view("admin.post.create", $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePostRequest $request
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // \DB::enableQueryLog(); // Enable query log

        //===start Policy===========================================================

        //===روش اول
        // $response = Gate::inspect('update', $post);

        // if (!$response->allowed()) {

        //     abort(403, '!اجازه ویرایش ندارید');

        // }

        //===روش دوم(مورد علاقه من)
        Gate::authorize('update', $post);

        //===روش سوم
        // if ($request->user()->cannot('update', $post)) {
        //     abort(403, '!2اجازه ویرایش ندارید');
        // }

        //===end Policy===========================================================

        if ($request->hasFile(key: 'image')) {

            $image = $request->file('image');

            $extension = $image->extension();

            $path = $image->storeAs('upload/images', time() . '.' . $extension);

            $post->image = $path;

        }

        $post->title = $request->title;
        $post->content = $request->content;
        $post->published = request('show', '1');
        $post->slug = $request->title;
        $post->save();

        $post->categories()->detach(request('categories[]'));
        $post->categories()->attach(request('categories'));

        $post->tags()->detach(request('tags[]'));
        $post->tags()->attach(request('tags'));

        // dd(\DB::getQueryLog()); // Show results of log

        return redirect()->back()->with('success_message', 'این مطلب با موفقیت ویرایش شد.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        DB::transaction(function () use ($post) {
            $post->categories()->detach();
            $post->tags()->detach();
            $post->delete();
        });

        return redirect()->back()->with('success_message', 'مطلب با موفقیت حذف شد.');

    }

    public function destroyAll()
    {
        // Start a manual transaction
        DB::beginTransaction();

        try {
            Log::info('Starting transaction...');

            // Disable foreign key checks (MySQL specific)
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Log::info('Foreign key checks disabled.');

            // Truncate pivot tables and related tables
            DB::table('category_post')->truncate();
            Log::info('category_post truncated.');

            DB::table('post_tag')->truncate();
            Log::info('post_tag truncated.');

            DB::table('comments')->truncate();
            Log::info('comments truncated.');

            DB::table('posts')->truncate();
            Log::info('posts truncated.');

            // Enable foreign key checks (MySQL specific)
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            Log::info('Foreign key checks enabled.');

        } catch (Exception $e) {
            // Roll back the transaction in case of an error
            DB::rollBack();
            Log::error('Error in destroyAll: ' . $e->getMessage());

            // Return an error response
            return redirect()->back()->with('error_message', 'An error occurred while deleting the posts.');
        }

        // Return a success response
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
        $data['manuAuthorizations'] = $this->getMenuAuthorizations(Auth::user());

        return view('admin.post.post_comments', compact('comments'));

    }
}
