<?php
/*
 * WeeklyController.php
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

class WeeklyController extends Controller
{
    public function index(Request $request)
    {
        return view("user.weekly");
    }
}
