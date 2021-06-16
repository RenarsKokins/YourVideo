<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    public function followLogic(Request $request){
        if (!Auth::check()){
            return response()->json(['data'=>'no_login']);
        }
        $user = Auth::user();

        if (Follow::where([
            ['follower_id', '=', $user->id],
            ['following_id', '=', $request->user_id]])
        ->exists()){
            Follow::where([
                ['follower_id', '=', $user->id],
                ['following_id', '=', $request->user_id]])
        ->delete();
        return response()->json(['data'=>"unfollowed"]);
        }
        else{
            $follow = new Follow();
            $follow->follower_id = $user->id;
            $follow->following_id = $request->user_id;
            $follow->save();
        }
        return response()->json(['data'=>"followed"]);
    }

    public function checkFollow(Request $request){
        if (!Auth::check()){
            return response()->json(['data'=>'no_login']);
        }
        $user = Auth::user();
        if (Follow::where([
            ['follower_id', '=', $user->id],
            ['following_id', '=', $request->user_id]])
        ->exists()){
            return response()->json(['data'=>"following"]);
        }
        else{
            return response()->json(['data'=>"not_following"]);
        }
    }

    public function getFollows(Request $request){
        return Auth::user()->following;
    }
}
