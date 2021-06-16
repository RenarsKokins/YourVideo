@forelse ($videos as $video)
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-5 p-0">
            <img src="{{route('home').'/storage/thumbnails/'.$video->video_url.'/'.$video->video_url.'_original.png'}}" class="card-img-top" alt="...">
            <a href="{{route('home').'/video?v='.$video->video_url}}" class="stretched-link"></a>
        </div>
        <div class="col-xl-7 d-flex flex-column">
            <div class="mt-0 mb-0">
                <h5 class="mt-0">{{$video->title}}</h5>
                <p>Uploaded by: {{$video->user->name}}</p>
                <small>Views: {{$video->views}}</small>
            </div>
            @if(Route::is('account.view_videos.view') or Route::is('account.view_videos_admin.view'))
            <div class="d-flex">
                <a id="{{$video->id}}" href="{{route('account.show_modify', $video->id)}}" class="btn btn-primary modify-video">Modify</a>
                <button id="{{$video->id}}" class="btn btn-danger delete-video ml-1">Delete</button>
            </div>
            @else
            <a href="{{route('home').'/video?v='.$video->video_url}}" class="stretched-link"></a>
            @endif
        </div>
    </div>
</div>
<hr class="theme-lighter-base"/>
@empty
<p>No videos</p>
@endforelse