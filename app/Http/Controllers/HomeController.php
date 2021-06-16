<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        return view('home');
    }

    public function get_recommended(Request $request){
        $videos = Video::inRandomOrder()->where('publicity', 'P')->limit($request->count)->get();
        return View::make('components.video-template', ['videos'=>$videos])->render();
    }

    public function get_following(Request $request){
        $following = Auth::user()->following;
        $followers = []; 
        foreach($following as $follow){
            $followers[] = $follow->id;
        }
        $videos = Video::whereIn('user_id', $followers)->where('publicity', 'P')->orderBy('created_at', 'desc')->get();
        return View::make('components.video-template', ['videos'=>$videos])->render();
    }
}
