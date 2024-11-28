<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'فهرست تگ ها';
        $data['tags'] = Tag::orderBy("created_at", "desc")->paginate(10);
        $data['active'] = 'tags';

        return view("admin.tag.all", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        Tag::create($request->all());

        return redirect()->back()->with("success_message", "تگ با موفقیت ثبت شد.");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $data['title'] = 'فهرست تگ ها';
        $data['tag'] = $tag;
        $data['tags'] = Tag::orderBy("created_at", "desc")->paginate(10);
        $data['active'] = 'tags';

        return view("admin.tag.all", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Admin\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->title = $request->title;
        $tag->save();

        return redirect('tags')->with("success_message", "تگ با موفقیت ویرایش شد.");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->posts()->detach();

        $tag->delete();

        return redirect()->back()->with('success_message', 'تگ با موفقیت حذف شد.');

    }
}
