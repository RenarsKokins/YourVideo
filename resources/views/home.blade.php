@extends('layouts.app')

@section('content')
<div class="col-sm container-fluid">
    <div class="row justify-content-around">
        <div class="theme-dark-base col-5">
        <h4 class="mt-4">Videos from people you follow</h4>
        <hr class="theme-lighter-base"/>
        <div class="following-videos">
        </div>
        </div>
        <div class="theme-dark-base col-5">
        <h4 class="mt-4">Recommended videos</h4>
        <hr class="theme-lighter-base"/>
        <div class="recommended-videos">
        </div>
        </div>
    </div>
</div>
@endsection
