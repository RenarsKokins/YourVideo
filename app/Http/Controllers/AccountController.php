<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Video;
use App\Jobs\ExportVideo;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use ProtoneMedia\LaravelFFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Support\ServiceProvider;


class AccountController extends Controller
{
    /**
     * Display upload page
     *
     * @return \Illuminate\Http\Renderable
     * @return \Illuminate\Http\Response
     */
    
    public function show_upload()
    {
        return view('video_upload');
    }

    /**
     * Display personal video view page
     *
     * @return \Illuminate\Http\Renderable
     * @return \Illuminate\Http\Response
     */

    public function show_view()
    {
        return view('video_management');
    }

    public function show_modify(Request $request)
    {
        $video = Video::where('id', $request->id)->first();
        //$video = json_decode($video);
        return view('video_modify', compact('video'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function modify_video(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'max:5000'
        ]);

        if (!Auth::check()){
            return response()->json(['error'=>'User not logged in']);
        }

        $user = Auth::user();
        $video = Video::where('id', $request->video_id)->first();
        if($video->user->id != $user->id) return response()->json(['error'=>'Wrong video']);

        $video->title = $request->title;
        $video->description = $request->description;
        $video->category = $request->category;
        $video->publicity = $request->publicity;
        $video->save();

        //return "cool";
        return redirect('/account/myvideos');
    }

    public function get_videos(Request $request){
        $all = Auth::user()->videos;
        return View::make('components.video-template', ['videos'=>$all])->render();
    }

    public function get_videos_admin(Request $request){
        if(Auth::user()->role != 1) return "not admin";
        $all = Video::all();
        return View::make('components.video-template', ['videos'=>$all])->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_video(Request $request)
    {
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'max:5000',
            'video' => 'required'
        ]);

        if (!Auth::check()){
            return response()->json(['error'=>'User not logged in']);
        }
        $filename = Str::random(12);
        $path = public_path().'/storage/tempVideos';
        request()->video->move($path, $filename.'.'.request()->video->getClientOriginalExtension());
        
        $video = new Video();
        $id = Auth::id();
        $video->user_id = $id;
        $video->video_url = $filename;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->publicity = $request->publicity;
        $video->category = intval($request->category);
        $video->save();
        $ext = request()->video->getClientOriginalExtension();
        
        // Add video to render queue
        ExportVideo::dispatch((string)$filename, (string)$ext);
        return response()->json(['success'=>$filename, 'publicity'=>$request->publicity, 'category'=>intval($request->category), 'path'=>storage_path().'/app/public/tempVideos/'.$filename.'.'.$ext]);
    }

    public function delete_video(Request $request)
    {
        if (!Auth::check()){
            return response()->json(['error'=>'User not logged in']);
        }
        $user = Auth::user();
        $video = Video::where('id', $request->video_id)->first();

        if($user->role!=1){
            if($video->user->id != $user->id) return response()->json(['error'=>'Wrong video']);
        }
        
        $url = $video->video_url;
        File::deleteDirectory(storage_path().'/app/public/videos/'.$url);
            File::deleteDirectory(storage_path().'/app/public/thumbnails/'.$url);
            $video->delete();
            return "success";
        
        if(File::exists(storage_path().'/app/public/videos/'.$url.'/'.$url.'.m3u8')){
            
        }
        return "didnt find file on server!";
    }
}
