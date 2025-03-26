<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs | {{ $post->title }}</title>

    <!-- CSS Assets -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Main Styles */
        body {
            background-color: #f5f6fa;
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }

        /* Blog Container Styles */
        .blog-container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        /* Blog Card Styles */
        .blog-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .blog-img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
            object-fit: cover;
            max-height: 500px;
        }

        .blog-meta {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }

        .blog-meta i {
            margin-right: 5px;
        }

        /* Tags Styles */
        .tags {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tags span {
            background-color: #2c3e50;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        /* Comments Section */
        .comment-section {
            margin-top: 40px;
        }

        .comment-card {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .comment-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .comment-body {
            padding: 20px;
            background-color: white;
            border-radius: 8px;
        }

        .reply-btn {
            cursor: pointer;
            color: #007bff;
            font-size: 14px;
        }

        .reply-btn:hover {
            text-decoration: underline;
        }

        .reply-form {
            display: none;
            margin-top: 10px;
        }

        .nested-reply {
            margin-left: 40px;
            border-left: 3px solid #ddd;
            padding-left: 15px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<!-- Main Container -->
<div class="container blog-container">
    <div class="row">
        <!-- Main Blog Content Column -->
        <div class="col-lg-8">
            <!-- Blog Post Card -->
            <div class="blog-card">
                <!-- Blog Featured Image -->
                <img src="{{ asset('storage/images/post_img/') }}/{{ $post->image }}"
                     alt="{{ $post->title }}" class="blog-img">

                <!-- Blog Title -->
                <h1 class="mb-3">{{ $post->title }}</h1>

                <!-- Blog Meta Information (Author and Date) -->
                <div class="blog-meta">
                    <span><i class="fas fa-user"></i> {{ $post->user->name }}</span>
                    <span class="mx-2">|</span>
                    <span><i class="fas fa-calendar"></i> {{ $post->created_at->format('j F, Y') }}</span>
                </div>

                <!-- Blog Content -->
                <div class="blog-content">
                    {!! $post->description !!}
                </div>

                <!-- Blog Tags -->
                <div class="tags">
                    @foreach($post->tags as $tag)
                        <span>{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Blogs Sidebar Column -->
        <div class="col-lg-4">
            <div class="recent-blogs">
                <h5><i class="fas fa-clock-rotate-left me-2"></i>Recent Blogs</h5>

                @foreach($last_post as $last_posts)
                    <a href="{{ route('blogs.show', $last_posts->id) }}" class="text-decoration-none">
                        <div class="recent-blog-item">
                            <img src="{{ asset('storage/images/post_img/') }}/{{ $last_posts->image }}"
                                 alt="{{ $last_posts->title }}">
                            <div>
                                <h6>{{ Str::limit($last_posts->title, 50) }}</h6>
                                <p>{{ $last_posts->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach

                <a href="{{ route('blogs.index') }}" class="read-more-link">
                    View All Blogs <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container comment-section">
    <div class="card comment-card">
        <div class="card-header comment-header">
            <h3 class="fw-bold"><i class="fas fa-comments me-2"></i>Comments</h3>
        </div>
        <div class="card-body">
            @foreach($post->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold">{{ $comment->user->name }}</h6>
                        <p>{{ $comment->comment }}</p>
                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        <span class="reply-btn" onclick="toggleReplyForm({{ $comment->id }})">Reply</span>
                        <div id="reply-form-{{ $comment->id }}" class="reply-form">
                            <form action="{{route('reply.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                <textarea name="reply" class="form-control" rows="2" placeholder="Write a reply..."></textarea>
                                <button type="submit" class="btn btn-sm btn-primary mt-2"><i class="fas fa-reply me-1"></i> Reply</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Nested Replies -->
                @foreach($comment->replies as $reply)
                    <div class="nested-reply">
                        <div class="card bg-light mb-2">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $reply->user->name }}</h6>
                                <p>{{ $reply->comment }}</p>
                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Add Comment Form -->
    <div class="card comment-card">
        <div class="card-body">
            <h4 class="card-title mb-4"><i class="fas fa-edit me-2"></i>Leave a Comment</h4>
            <form action="{{ route('comments.store') }}" method="post">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <textarea name="comment" class="form-control" rows="4" placeholder="Share your thoughts..."></textarea>
                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-paper-plane me-2"></i>Post Comment</button>
            </form>
        </div>
    </div>
</div>



<!-- JS Scripts -->
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybKpnk8p5T8oG5sEwKXQCcXr0trF4d0F7XbHjwC6EzYPFlVxF5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0Sh47o4P2DwwNng56uGy1bDlT6r58znn/64fB40pVJd6jYiI" crossorigin="anonymous"></script>

<script>
    function toggleReplyForm(commentId) {
        const replyForm = document.getElementById('reply-form-' + commentId);
        if (replyForm.style.display === "none" || replyForm.style.display === "") {
            replyForm.style.display = "block";
        } else {
            replyForm.style.display = "none";
        }
    }
</script>
</body>
</html>
