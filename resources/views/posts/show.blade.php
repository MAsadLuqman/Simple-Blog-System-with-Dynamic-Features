<x-layout>
        <style>
            body {
                background-color: #f5f6fa;
                font-family: 'Poppins', sans-serif;
            }
            .blog-container {
                margin-top: 50px;
            }
            .blog-card {
                background: white;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .blog-img {
                width: 100%;
                height: auto;
                border-radius: 10px;
            }
            .blog-meta {
                font-size: 14px;
                color: #777;
            }
            .tags {
                margin-top: 15px;
            }
            .tags span {
                background-color: #2c3e50;
                color: white;
                padding: 5px 10px;
                border-radius: 5px;
                font-size: 14px;
                margin-right: 5px;
            }
            .recent-blogs {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }
            .recent-blog-item {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
                cursor: pointer;
            }
            .recent-blog-item img {
                width: 60px;
                height: 60px;
                border-radius: 8px;
                margin-right: 10px;
            }
            .recent-blog-item h6 {
                margin: 0;
                font-size: 14px;
                color: #333;
            }
            .recent-blog-item p {
                margin: 0;
                font-size: 12px;
                color: #777;
            }
            .recent-blog-item:hover h6 {
                color: #2c3e50;
            }
        </style>

    <div class="container blog-container">
        <div class="row">
            @if (Session::has('success'))
                <div class=" mt-4">
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                </div>
            @endif
            <!-- Main Blog Content -->
            <div class="col-lg-8">
                <div class="blog-card">
                    <img src="{{ asset('storage/images/post_img/') }}/{{ $post->image }}" alt="Blog Image" class="blog-img">
                    <h2 class="mt-3">{{$post->title}}</h2>
                    <p class="blog-meta">
                        <i class="fas fa-user"></i> {{$post->user->name}} |
                        <i class="fas fa-calendar"></i> {{$post->created_at->format('j F, Y')}}
                    </p>
                    <p class="mt-3">
                        {!!$post->description !!}
                    </p>
                    <div class="tags">
                        @foreach($post->tags as $tag)
                        <span>
                            {{$tag->name}}
                        </span>
                        @endforeach
                    </div>
                </div>
                @forelse($post->comments as $comment)
                    {{$comment->comment}}
                    {{$comment->user->name}}
                    <br>

                @empty
                    <p>no comments</p>
                @endforelse
            </div>


            <!-- Recent Blogs Section -->
            <div class="col-lg-4">
                <div class="recent-blogs">
                    <h5>Recent Blogs</h5>
                    @foreach($last_post as $last_posts)
                        <div class="recent-blog-item">

                            <img src="{{asset('storage/images/post_img/')}}/{{$last_posts->image}}" alt="Blog">
                            <div>
                                <h6>{{$last_posts->title}}</h6>
                                <p>{{$last_posts->created_at}}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header">
            <h3 class="fw-bold text-center">Comment section</h3>
        </div>
        <div class="card-body shadow">
            <form action="{{route('comments.store')}}" method="post">
                @csrf
                <div>
                    <input type="hidden" name="postId" value="{{$post->id}}">
                    <label for="" class="fw-bold">Comments</label>
                    <textarea type="text" name="comment" placeholder="comment here" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
    </div>


</x-layout>

