<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::get();
        return $comments;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Room $room)
    {
        $comment = new Comment($request->all());
        $comment->name = $request->user()->name;
        $comment->user_id = $request->user()->id;
        // $comment->room_id = $request->room_id;

        
        // トランザクション開始
        DB::beginTransaction();
        try {
            // return $comment;
            // 登録
            $room->comments()->save($comment);

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return $e->getMessage();
        }
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentRequest $request, Room $room, Comment $comment)
    {
        // dd($comment);
        // トランザクション開始
        DB::beginTransaction();
        try {
            $comment->delete();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return $comment;
    }
}
