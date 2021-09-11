<?php
/*
 * HeightController.php
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 * git-hub
 * https://github.com/tora-japan
 */

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;                              // 日付
use Illuminate\Support\Facades\Auth;            // ユーザー認証
use App\Models\User;                            // ユーザー
use App\Models\Weight;                          // 体重

class HeightController extends Controller
{
    public function index(Request $request)
    {
        // ユーザーを取得し、身長を投げる
        $user = User::find(Auth::id());
        return view("user.height",[
            "height" => $user->height,
            "msg" => ''
        ]);
    }

    public function post(Request $request)
    {
        // バリデーション：身長は3桁以内とする
        $request->validate([
            'height' => ['regex:/^([0-9]{1,3})$/'],
        ]);
        // ユーザーを取得し、身長を更新する
        $user = User::find(Auth::id());
        $user->height = $request->input('height');
        $user->save();

        return view("user.height", [
            "height" => $user->height,
            "msg" => '更新しました'
        ]);
    }
}
