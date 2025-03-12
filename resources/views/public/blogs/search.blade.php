@forelse($posts as $post)
    <div class="col-md-4">
        <div class="card mb-4">
            <img src="{{ asset('storage/images/post_img/') }}/{{ $post->image }}" class="card-img-top"
                 alt="Blog Image">
            <div class="card-body text-center">
                <h5 class="card-title">{{$post->title}}</h5>
                <p class="card-text"><strong>Author:</strong> {{$post->user->name}}
                    <br> <b>Published on:</b> {{$post->updated_at->format('j F, Y')}}</p>
                <a href="{{route('blogs.show',$post->slug)}}" class="btn btn-outline-info">Read More</a>

            </div>
        </div>
    </div>
@empty
    <p class="text-center fw-bold mt-3">No Blogs found!!</p>
@endforelse
