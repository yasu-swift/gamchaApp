<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User;
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User;
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // dd($user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\Models\User;
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        // dd($user->id, Auth::user()->id);
        // $this->middleware('auth');
        //  dd(Auth::user()->id, $request->user()->id);
        // if ($request->user()->cannot('update', $user)) {
        //     return redirect()->route('users.show', $user)
        //     ->withErrors('自分の記事以外は更新できません');
        // }
        if (Auth::user()->id == $user->id){
            $file = $request->file('avatar');
            if ($file) {
                $delete_file_path = $user->image_path;
                $user->avatar = date('YmdHis') . '_' . $file->getClientOriginalName();
            }
            $user->fill($request->all());
            // トランザクション開始
            DB::beginTransaction();
            try {
                // 更新
                // dd($user);
                $user->save();
                if ($file == "") {
                    if ($file) {
                        // 画像アップロード
                        if (!Storage::putFileAs('images/users', $file, $user->avatar)) {
                            // 例外を投げてロールバックさせる
                            throw new \Exception('画像ファイルの保存に失敗しました。');
                        }
                        if (!Storage::delete($delete_file_path)) {
                            // 例外を投げてロールバックさせる
                            throw new \Exception('画像ファイルの削除に失敗しました。');
                        }
                    }
                } else {
                    if ($file) {
                        // 画像アップロード
                        if (!Storage::putFileAs('images/users', $file, $user->avatar)) {
                            // 例外を投げてロールバックさせる
                            throw new \Exception('画像ファイルの保存に失敗しました。');
                        }
                    }
                }
                
    
                // トランザクション終了(成功)
                DB::commit();
            } catch (\Exception $e) {
                // トランザクション終了(失敗)
                DB::rollback();
                return back()->withInput()->withErrors($e->getMessage());
            }
    
            return redirect()->route('users.show', $user)
                ->with('notice', '記事を更新しました');

        }else{
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
