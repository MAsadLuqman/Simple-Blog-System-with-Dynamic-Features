
<x-layout>
    @section('title')
        Blogs
    @endsection
        <x-slot name="alert">
           <div class="mt-5">
               @if (Session::has('success'))
                   <div class=" mt-4">
                       <script>
                           $(document).ready(function (){

                               toastr.error("{{Session::get('success')}}");
                               toastr.option = {
                                   "progressBar" : true,
                                   "positionClass": "toast-bottom-right",
                               }
                           });
                       </script>
                   </div>
               @endif
           </div>
        </x-slot>
    @can('create-post')
        <a href="{{route('posts.create')}}" class="btn btn-primary mb-3">Add Blogs</a>
    @endcan
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
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="delete_postModal" tabindex="-1" aria-labelledby="delete_userModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete_userModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are You Sure You want to delete?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="#" class="btn btn-primary" id="postDeleteBtn">Save changes</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
        <x-slot name="postssearch">
            <script>
                $(document).on('submit', '#searchForm', function (e) {
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("posts.search") }}',
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

        </x-slot>
</x-layout>




