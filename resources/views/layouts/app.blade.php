<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" type="text/javascript" defer></script>
    
    @if (Route::is('video.view'))
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/video.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/videojs-hls-quality-selector.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/videojs-contrib-quality-levels.min.js') }}" type="text/javascript"></script>

    <script>
    $(document).ready(function () {
        var options = {"aspectRatio": "16:9", "autoplay": true};
        var player = videojs("vid1", options);
        var vid_id = {{$video->id}};
        var user_id = {{$video->user_id}};
        player.qualityLevels();
        player.hlsQualitySelector();

        function addLike(data){
            if(data=="like"){
                $('#like-text').text(parseInt($('#like-text').text()) + 1);
            }else{
                $('#dislike-text').text(parseInt($('#dislike-text').text()) + 1);
            }
        }

        function reloadComments(){
            $.ajax({
                type: "POST",
                url: "{{ route('video.get_comment') }}",
                data: {"id": vid_id, "_token": "{{ csrf_token() }}"},
                success: function(data){
                    $(".comments-section").html(data);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        function loadVideos(){
            $.ajax({
                type: "POST",
                url: "{{ route('home.get_recommended') }}",
                data: {"count":20, "_token": "{{ csrf_token() }}"},
                success: function(data){
                    $(".recommended-videos").html(data);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }

        $('.comment-form').on('submit',function(e){
            e.preventDefault();
            var form = $(this);
            var data = form.serialize();
            var url = "{{ route('video.comment') }}";
            var textarea = form.find("[textarea]");
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success:function(data){
                    console.log('Success:', data);
                    reloadComments();
                    $("#comment").val("");
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            })
        });
        $(".video-liked").on('click', function (e) {
            var url = "{{ route('video.like') }}";
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var btn = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: { "type": btn.attr('id'), "video_id": vid_id, "_token": CSRF_TOKEN },
                success: function (data) {
                    if(data.data=="no_login") window.location.replace("{{route('home').'/login'}}");
                    console.log('Success:', data);
                    addLike(data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $("#follow-button").on('click', function (e) {
            var url = "{{ route('follow') }}";
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: url,
                data: { "user_id": user_id, "_token": CSRF_TOKEN },
                success: function (data) {
                    if(data.data=="no_login") window.location.replace("{{route('home').'/login'}}");
                    console.log('Success:', data);
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        reloadComments();
        loadVideos();
    });     
    </script>
    @endif

    @if (Route::is('home'))
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    var ROOTURL = "{{ route('home') }}";
    $(document).ready(function(){
        function loadVideos(){
            $.ajax({
                type: "POST",
                url: "{{ route('home.get_recommended') }}",
                data: {"count":20, "_token": "{{ csrf_token() }}"},
                success: function(data){
                    $(".recommended-videos").html(data);
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        }
        loadVideos();
    }); 
    </script>
    @endif

    @if (Route::is('account.upload'))
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    var SITEURL = "{{ route('account.upload') }}";
    var ROOTURL = "{{ route('home') }}";
    $(document).ready(function(){
        $('form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var bar = $('.progress-bar');
            var progress = $('.progress');
            progress.removeClass("invisible");
            $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    bar.css("width", percentComplete + '%');
                    bar.attr("aria-valuenow", percentComplete);
                    bar.html(percentComplete+"%");
                    //console.log(percentComplete);
                    if (percentComplete === 100) {
                        bar.removeClass("bg-warning");
                        bar.addClass("bg-success");
                    }
                }
                }, false);
                return xhr;
            },
            url: SITEURL,
            method: "POST",
            type: "POST",
            data: new FormData( this ),
            processData: false,
            contentType: false,
            success: function(result) {
                console.log(result);
                $('.video-form').remove();
                $('.video-link').html(ROOTURL + "/video?v=" + result["success"]);
                $('.video-link').attr("href", ROOTURL + "/video?v=" + result["success"]);
                $('.success').removeClass("invisible");
            },
            error: function (result) {
                console.log('Error:', result);
            }
            });
        });
    }); 
    </script>
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app" class="h-100">
        <nav class="navbar theme-lighter-base navbar-expand-md sticky-top navbar-dark shadow">
            <div class="container-fluid pl-0 pr-0">
                @if (Route::is('home') or Route::is('video.view'))
                <button class="btn" type="button" data-toggle="collapse" data-target="#sidebarContent" aria-controls="sidebarContent" aria-expanded="false" aria-label="{{ __('Toggle sidebar') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                @endif

                <a class="navbar-brand " href="{{ url('/') }}">
                    <img src="/img/logo-orange.webp" width="120" alt="YourVideo logo">
                </a>
                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link btn theme-accent " href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <!--Logout button-->
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    <!--Upload button-->
                                    <a class="dropdown-item" href="{{ route('account.upload') }}">
                                        {{ __('Upload video') }}
                                    </a>

                                    <!--View videos button-->
                                    <a class="dropdown-item" href="{{ route('account.view_videos') }}">
                                        {{ __('View my videos') }}
                                    </a>

                                    <!--Settings button-->
                                    <a class="dropdown-item" href="{{ route('account') }}">
                                        {{ __('Account settings') }}
                                    </a>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container-fluid">
            <div class="row">
                @if (Route::is('home') or Route::is('video.view'))
                <x-sidebar :subscriptions="[]"/>
                @endif
                @section('content')
                @show
            </div>
        </main>
    </div>
</body>
</html>
