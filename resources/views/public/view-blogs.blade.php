<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs | Details</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

</head>

<body>
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
                    <a href="{{route('blogs.index')}}">Read More</a>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Display Comments Section -->
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="fw-bold text-center">Comments</h3>
            </div>
            <div class="card-body shadow">
                <div id="data-wrapper" style="overflow-y:scroll;max-height: 400px; ">

                </div>
                <div class="auto-load text-center" style="display: none;">
                    <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
                         xml:space="preserve">
            <path fill="#000"
                  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">

                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"

                                  from="0 50 50" to="360 50 50" repeatCount="indefinite"/>

            </path>

        </svg>

                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="mb-3">
                        <label for="comment" class="fw-bold">Leave a Comment</label>
                        <textarea name="comment" class="form-control" placeholder="Write your comment..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        let postID="{{ $post->id }}";
        var ENDPOINT = @json(route('comments.index', ':id'));
        ENDPOINT=  ENDPOINT.replace(':id', postID);
        var page = 1;
        infiniteLoadMore(page);
        var isLoaded = false;

        let div = $("#data-wrapper");

        div.scroll(function (event) {
          let container =event.target;
            const tolerance = 2; // Allow a small tolerance for floating-point issues
            const isAtBottom =
                container.scrollHeight - container.scrollTop - container.clientHeight <= tolerance;
            console.log(isAtBottom)
            console.log( container.scrollHeight , container.scrollTop , container.clientHeight)
            if (!isLoaded && isAtBottom) {
                page++;
                infiniteLoadMore(page);
            }

        });

        function infiniteLoadMore(page) {
            $.ajax({
                url: ENDPOINT + "?page=" + page,
                datatype: "html",
                type: "GET",
                beforeSend: function () {
                    $('.auto-load').show();
                }
            })
                .done(function (response) {
                    if (response.html === '') {
                        $('.auto-load').html("We don't have more comments to display");
                        return;
                    }
                    isLoaded = response.isLoaded;
                    $('.auto-load').hide();

                    $("#data-wrapper").append(response.html);
                })
                .fail(function () {
                    console.log('Server error occurred');
                })

        }
    </script>

</body>
</html>
