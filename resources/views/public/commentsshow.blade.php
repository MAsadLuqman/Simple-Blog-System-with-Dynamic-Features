@forelse($comments as $comment)
    <div class="d-flex align-items-start mb-3 p-3 border rounded bg-light">
        <img src="{{asset('storage/images/')}}/{{$comment->user->image}}"
             alt="User Image"
             class="rounded-circle"
             width="50" height="50">
        <div class="ms-3">
            <strong>{{ $comment->user->name }}</strong>
            <p class="mb-1">{{ $comment->comment }}</p>
            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
        </div>
    </div>
@empty
@endforelse
