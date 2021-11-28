<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return [$user];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        // if ($request->user()->cannot('update', $user)) {
        //         return redirect()->route('users.show', $user)
        //         ->withErrors('自分の記事以外は更新できません');
        //     }

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
            return $e->getMessage();
        }

        return $user;
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
