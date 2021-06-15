<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Jobs\ExportVideo;

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

    public function index()
    {
        return view('video_upload');
    }

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
