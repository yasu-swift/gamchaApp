<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Room;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
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
    // public function index()
    // {
    //     $comments = Comment::get();
    //     return view('rooms.show', ['comments' => $comments]);
    // }

    public function add(RoomRequest $request)
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
     * Display a listing of the resource.
     *
     * @return App\Http\Requests\RoomRequest;
     */
    public function index()
    {
        $rooms = Room::with('user')->latest()->paginate(8);
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return App\Http\Requests\RoomRequest;
     */
    public function create(Category $category)
    {
        $categories = Category::all();
        return view('rooms.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Requests\RoomRequest;
     */
    public function store(RoomRequest $request)
    {
        $room = new Room($request->all());
        $room->category_id = $request->category;
        $room->user_id = $request->user()->id;

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 登録
            // dd($room);
            $room->save();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('rooms.show', $room)
            ->with('notice', '部屋を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return App\Http\Requests\RoomRequest;
     */
    public function show(Room $room)
    {
        $comments = Comment::all();
        $comments = $room->comments()->latest()->get()->load(['user']);
        return view('rooms.show', compact('room', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return App\Http\Requests\RoomRequest;
     */
    public function edit(Room $room)
    {
        $comments = Comment::get();
        $categories = Category::all();
        return view('rooms.edit', compact('room', 'categories'), ['comments' => $comments]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return App\Http\Requests\RoomRequest;
     */
    public function update(RoomRequest $request, Room $room)
    {
        if ($request->user()->cannot('update', $room)) {
            return redirect()->route('rooms.show', $room)
                ->withErrors('自分の部屋以外は更新できません');
        }

        $room->category_id = $request->category;
        $room->fill($request->all());

        // トランザクション開始
        DB::beginTransaction();
        try {
            // 更新
            $room->save();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('rooms.show', $room)
            ->with('notice', '部屋を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return App\Http\Requests\RoomRequest;
     */
    public function destroy(Room $room)
    {
        // トランザクション開始
        DB::beginTransaction();
        try {
            $room->delete();

            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('rooms.index')
            ->with('notice', '部屋を削除しました');
    }
}
