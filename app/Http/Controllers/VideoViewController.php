<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoViewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showVideo(Request $request){
        $video = $request->input('v');
        $path = asset('storage/videos/' . $video . '.mp4');
        //$path = Storage::path('public/videos/'.$video.'.mp4');
        if (!Storage::exists('public/videos/'.$video.'.mp4')) {
            echo $path;
            abort(404);
        }
        return view('video_view', compact('path'));
    }

    public function saveLike(Request $request){
        return "ez";
    }

    public function saveComment(Request $request){
        return "ez";
    }
}
