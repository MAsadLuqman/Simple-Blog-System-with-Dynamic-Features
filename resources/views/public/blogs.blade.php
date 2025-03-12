<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blogs</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<h1 class="text-center fw-bold pt-5">Blogs Lists</h1>
<div class="blog-master">
    <div class="container">
        <form method="post" id="searchForm">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="text" name="title" class="form-control" id="searchbytitle" placeholder="Search By Title">
                </div>
                <div class="col-md-3 mb-3">
                    <button type="submit" id="search-btn"  class="btn btn-info">Search</button>
                </div>
            </div>
        </form>
        <div class="row" id="postssearch">
            @foreach($posts as $post)
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
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $(document).on('submit', '#searchForm', function (e) {
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: '{{ route("blogs.search") }}',
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: $(this).serialize(),
            beforeSend: function() {
                $("#search-btn").prop("disabled", true).html('Processing');

            },
            success: function (response) {
                console.log(response);
                $('#postssearch').html(response);
            },
            error: function(xhr, status, error) {
            },
            complete:function(){
                $("#search-btn").prop("disabled",false).html('Search');


            }
        });
    });
</script>
</body>
</html>
