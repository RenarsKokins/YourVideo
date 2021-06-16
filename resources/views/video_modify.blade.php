@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="theme-lighter-base">
                <div class="card-header">Modify your video</div>
                <div class="card-body">
                    <form method="POST" class=".modify-form" action="{{ route('account.modify') }}">
                        <p>You can modify your video by changing the title, description, publicity and category.</p>
                        <hr/>
                        @csrf
                        <input name="video_id" type="hidden" value="{{$video->id}}">
                        <!-- Title -->
                        <div class="form-group">
                            <label for="title">Your video title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="{{$video->title}}" required/>
                            <small id="titleHelp" class="form-text text-muted">You can change it later.</small>
                        </div>
                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Your description</label>
                            <textarea class="form-control" id="description" placeholder="Your description" name="description" rows="3">{{$video->description}}</textarea>
                            <small id="titleHelp" class="form-text text-muted">Not necessary.</small>
                        </div>
                        <!-- Publicity -->
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="publicity" id="public" value="P" checked>
                        <label class="form-check-label" for="public">
                            Public <small>(everybody can view your video)</small>
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="publicity" id="unlisted" value="U">
                        <label class="form-check-label" for="unlisted">
                            Unlisted <small>(only people with a link can view your video)</small>
                        </label>
                        </div>
                        <div class="form-check mb-4">
                        <input class="form-check-input" type="radio" name="publicity" id="private" value="S">
                        <label class="form-check-label" for="private">
                            Private <small>(only you can view your video)</small>
                        </label>
                        </div>
                        <!-- Category --> 
                        <div class="form-group">
                            <label for="category">Select content category <small>(by selecting the right category, people can see your video while using tags)</small></label>
                            <select class="form-control" id="category" name="category">
                            <option value="0">Entertainment</option>
                            <option value="1">Films & Animation</option>
                            <option value="2">Music</option>
                            <option value="3">Pets & Animals</option>
                            <option value="4">Sports</option>
                            <option value="5">Travel & Vlogs</option>
                            <option value="6">Gaming</option>
                            <option value="7">Comedy</option>
                            <option value="8">News</option>
                            <option value="9">Science</option>
                            <option value="10">Education</option>
                            </select>
                        </div>
                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary mb-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
