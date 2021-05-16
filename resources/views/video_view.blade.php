@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 pt-lg-4 pl-lg-4 pr-lg-4">
    <div class="row m-0">
        <div class="col-lg-8 p-0 theme-darker-base">
            <div data-vjs-player>
                <video id="vid1" class="video-js vjs-big-play-centered" controls preload="auto" data-setup='{"aspectRatio": "16:9", "autoplay": true}'>
                    <source src="{{asset($path)}}" type="video/mp4"/>
                    Your browser does not support the video tag. 
                </video>
            </div>
            <div class="pt-2 ml-2">
                <h4>Cool title</h4>
            </div>
            <div class="text-light row">
                <div class="col ml-2">
                    <p>14591 views, 5/16/2021</p>
                </div>
                <div class="col mr-2">
                    <button id="share-button" class="btn float-right pt-0 pb-0">
                        <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 16 16">
                        <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z"/>
                        </svg>
                        SHARE
                    </button>
                    <button id="thumbs-down-button" class="btn float-right pt-0 pb-0">
                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray" viewBox="0 0 16 16">
                        <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                        </svg>
                        76
                    </button>
                    <button id="thumbs-up-button" class="btn float-right pt-0 pb-0">
                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="gray" viewBox="0 0 16 16">
                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                        </svg>
                        5.7K
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <p>This is the recommended video view</p>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $("#thumbs-down-button").on('click', function (e) {
        var url = "{{ route('video.liked') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var btn = $(this);
        $.ajax({
            type: "POST",
            url: url,
            data: { id: 0, _token: CSRF_TOKEN },
            success: function (data) {
                console.log('Success:', data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    $("#thumbs-up-button").on('click', function (e) {
        var url = "{{ route('video.liked') }}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var btn = $(this);
        $.ajax({
            type: "POST",
            url: url,
            data: { id: 0, _token: CSRF_TOKEN },
            success: function (data) {
                console.log('Success:', data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});     
</script>
@endsection