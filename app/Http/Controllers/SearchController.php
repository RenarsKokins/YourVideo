<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\View;

class SearchController extends Controller
{
    public function show(Request $request){
        $search_text = $request->search;
        return view('video_search', compact('search_text'));
    }

    public function get_videos(Request $request){
        $videos = Video::where('title', 'LIKE', '%'.$request->q.'%')
        ->orWhere('description', 'LIKE', '%'.$request->q.'%')
        ->where('publicity', 'P')
        ->limit($request->count)
        ->get();

        return View::make('components.video-template', ['videos'=>$videos])->render();
    }
}
