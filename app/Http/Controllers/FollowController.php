<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{
    public function followLogic(Request $request){
        if (!Auth::check()){
            return response()->json(['data'=>'no_login']);
        }
        $user = Auth::user();

        if (Follow::where('follower_id', $user->id)->where('following_id', $request->id)->exists()) {
            
        }
    }
}
