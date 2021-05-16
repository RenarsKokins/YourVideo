@forelse ($videos as $video)
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-5">
            <img src="{{route('home').'/storage/thumbnails/'.$video->video_url.'/'.$video->video_url.'_original.png'}}" class="card-img-top" alt="...">
            <a href="{{route('home').'/video?v='.$video->video_url}}" class="stretched-link"></a>
        </div>
        <div class="col-xl-7">
            <h5 class="mt-0">{{$video->title}}</h5>
            <p>Uploaded by: {{$video->user->name}}</p>
            <small>Views: {{$video->views}}</small>
            <a href="{{route('home').'/video?v='.$video->video_url}}" class="stretched-link"></a>
        </div>
    </div>
</div>
<hr class="theme-lighter-base"/>
@empty
<p>No videos</p>
@endforelse