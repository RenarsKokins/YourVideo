<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Video;
use App\Models\Comment;

class VideoViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showVideo(Request $request){
        $video_url = $request->input('v');
        if (!Storage::exists('public/videos/'.$video_url.'/'.$video_url.'.m3u8')) abort(404);

        $path = asset('storage/videos/'.$video_url.'/'.$video_url);
        $video = Video::where('video_url', $video_url)->first();
        $video->views = (int)$video->views + 1;
        $video->update();

        return view('video_view', compact('path', 'video'));
    }

    public function saveLike(Request $request){
        if (!Auth::check()){
            return response()->json(['data'=>'no_login']);
        }
        $video = Video::where('id', $request->video_id)->first();
        if($request->type == "like"){
            $video->likes = $video->likes + 1;
            $video->save();
            return "like";
        }
        else if($request->type == "dislike"){
            $video->dislikes = $video->dislikes + 1;
            $video->save();
            return "dislike";
        }
    }

    public function saveComment(Request $request){
        if (!Auth::check()){
            return response()->json(['data'=>'no_login']);
        }
        $id = Auth::id();
        $comment = new Comment();
        $comment->comment = $request->input("comment");
        $comment->user_id = $id;
        $comment->video_id = $request->video_id;
        $comment->save();
        return "Comment: ".$request->input("comment");
    }

    public function getComment(Request $request){
        $video = Video::where('id', $request->id)->first();
        $comments = $video->comments;
        return View::make('components.comment', ['comments'=>$comments])->render();
    }
}
