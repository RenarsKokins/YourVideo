<div>
@forelse ($comments as $comment)
    <p><b>{{$comment->user->name}}</b> posted at: {{$comment->posted_at}}</p>
    <p> {{ $comment->comment }}</p>
    <hr class="theme-lighter-base"/>
@empty
<p>No comments</p>
@endforelse
</div>