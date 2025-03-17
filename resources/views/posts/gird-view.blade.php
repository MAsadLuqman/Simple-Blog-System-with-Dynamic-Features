<div class="blog-master">
    <div class="container">
        <form method="post" id="searchForm">
            @csrf
            <div class="row">
                <div class="col-md-3 mb-3">
                    <input type="Date" name="date" class="form-control" id="searchbydate" placeholder="Search By Date">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="text" name="title" class="form-control" id="searchbytitle" placeholder="Search By Title">
                </div>
                <div class="col-md-3 mb-3">
                    <select name="tags" id="tags" class="form-control" >
                        <option value="tags" disabled>Search By Tags</option>
                        @forelse($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @empty
                            <option value="">No tags</option>
                        @endforelse

                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <button type="submit" id="search-btn"  class="btn btn-info">Search</button>
                </div>
            </div>
        </form>
        <div id="gird-view" style="display: block;">
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
                                <div>
                                    @can('publish-posts')
                                        <label class="switch">
                                            <input type="checkbox" class="toggle-status" data-id="{{ $post->id }}" {{ $post->is_published ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    @endcan

                                </div>
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
                @endforeach
            </div>
        </div>
    </div>
</div>
