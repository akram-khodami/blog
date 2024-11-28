<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post_id = request('post');
        $confirmed = request('confirmed');

        $filter = [];

        if (in_array($confirmed, [0, 1])) {

            $filter[] = ['confirmed', '=', $confirmed];

            if ($confirmed == 1) {

                $title = 'نظرات تایید شده';

            } else {

                $title = 'نظرات تایید نشده';

            }

        } else {

            $title = 'نظرات';

        }

        if (isset($post_id)) {

            $filter[] = ['post_id', '=', $post_id];

            $post = Post::findOrFail($post_id);

            $title .= ' ' . $post->title;

            $data['post'] = $post;

        }

        if (empty($filter)) {

            $comments = Comment::paginate(10);

        } else {

            $comments = Comment::where($filter)->paginate(10);

        }

        $data['title'] = $title;
        $data['comments'] = $comments;
        $data['active'] = 'comments';

        return view('admin.comment.all', $data);
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
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }



    public function confirmComment($id)
    {
        $comment = Comment::find($id);

        $comment->confirmed = 1;

        $comment->save();

        return redirect()->back()->with('success_message', value: 'نظر با موفقیت تایید شد.');

    }
}
