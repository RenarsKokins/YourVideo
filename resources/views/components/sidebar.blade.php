<div class="col-lg-3 collapse theme-darker-base" id="sidebarContent">
    <h4 class="mt-2">Search videos</h4>
    <form method="GET" class="video-form" action="{{ route('search') }}">
        @csrf
        <div class="input-group">
            <!-- Title -->
            <input type="text" class="form-control" id="search-text" name="search-text" placeholder="Search" required/>
            <!-- Submit -->
            <button type="submit" class="btn btn-primary ml-1">Search</button>
        </div>
    </form>
    <hr/>
    <div class="d-flex justify-content-between mt-4 mb-2">
        <h4 class="mt-auto mb-auto">People you follow</h4>
        <p class="ml-2 mt-auto mb-auto">
            <a class="mt-auto mb-auto" data-toggle="collapse" href="#showFollows" role="button" aria-expanded="false" aria-controls="showFollows">Show</a>
        </p>
    </div>
    <hr/>
    <div class="collapse" id="showFollows">
        @forelse ($subscriptions as $subscription)
            <p> {{ $subscription->name }}</p>
        @empty
        <p>No follows</p>
        @endforelse
        <hr/>
    </div>
</div>