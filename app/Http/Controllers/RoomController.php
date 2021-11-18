<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Room;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
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

        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return App\Http\Requests\RoomRequest;
     */
    public function edit(Room $room)
    {
        $categories = Category::all();
        return view('rooms.edit', compact('room', 'categories'));
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
        //
    }
}
