<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use Illuminate\Http\Request;


class RoomController extends Controller
{
    // const host = 'http://localhost/';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        $rooms->load('user');
        return $rooms;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $room = new Room($request->all());
        // return $request->user()->id;
        $room->category_id = $request->category_id;
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
            return $e->getMessage();
        }

        return $room;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        $room->load('user');
        
        // dd($room->user);
        $comments = $room->comments()->
            // latest()->
            get();
        // load('user');

        return [$room, $comments];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        // if ($request->user()->cannot('update', $room)) {
        //     return redirect()->route('rooms.show', $room)
        //         ->withErrors('自分の部屋以外は更新できません');
        // }


        $room->fill($request->all());
        $room->category_id = $request->category_id;
        $room->user_id = $request->user()->id;

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
            return $e->getMessage();
        }

        return $room;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        return $room;
    }
}
