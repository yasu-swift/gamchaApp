<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Room;
use App\Http\Requests\CommentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Break_;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getData()
    {
        $comments = Comment::orderBy('created_at', 'desc')->get();
        $json = ["comments" => $comments];
        return response()->json($json);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::get();
        return view('rooms.show', ['comments' => $comments]);
    }

    public function add(CommentRequest $request)
    {
        $user = Auth::user();
        $comment = $request->input('comment');
        Comment::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'comment' => $comment
        ]);
        return redirect()->route('home');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Room $room)
    {
        return view('comments.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *  @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Room $room)
    {
        $comment = new Comment($request->all());
        $comment->name = $request->user()->name;
        $comment->user_id = $request->user()->id;
        $comment->room_id = $room->id;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // dd($comment);
            // 登録
            $room->comments()->save($comment);

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()
            ->route('rooms.show', $room)
            ->with('notice', 'コメントを登録しました');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommentRequest $request, Room $room, Comment $comment)
    {
        if ($request->user()->cannot('update', $comment)) {
            return redirect()->route('posts.show', $comment)
            ->withErrors('自分の記事以外は削除できません');
        }
        
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

        return redirect()->route('rooms.show', $room)
            ->with('notice', 'コメントを削除しました');
    }
}
