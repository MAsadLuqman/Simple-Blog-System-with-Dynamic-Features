@forelse($posts as $post)
    <div class="col-md-4">
        <div class="card mb-4">
            <img src="{{ asset('storage/images/post_img/') }}/{{ $post->image }}" class="card-img-top"
                 alt="Blog Image">
            <div class="card-body text-center">
                <h5 class="card-title">{{$post->title}}</h5>
                <p class="card-text"><strong>Author:</strong> {{$post->user->name}}
                    <br> <b>Published on:</b> {{$post->updated_at->format('j F, Y')}}</p>
                <a href="{{route('posts.show',$post->slug)}}" class="btn btn-outline-info">Read More</a>
                <div class="mt-3">
                    @can('update-post')
                        <a href="{{route('posts.edit',$post->id)}}" class="btn btn-primary">Edit</a>
                    @endcan
                    @can('delete-post')
                        <a href="#" onclick="deletePost('{{ route('posts.destroy', $post->id) }}')"
                           class="btn btn-danger">Delete</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@empty
    <p>no found</p>
@endforelse
