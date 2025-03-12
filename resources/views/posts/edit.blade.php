<x-layout>
@section('title')
    Edit Blogs
@endsection
    <div class="container mt-5">
        <div class="card shadow ">
            <div class="card-header">
                <h1 class="text-center fw-bold">Update Blog Post</h1>
            </div>
            <div class="card-body">
                <form action="{{route('posts.update',$post->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="px-5 py-5 card shadow">
                                <label for="" class="fw-bold">Update Title:</label>
                                <textarea type="text" name="title" class="form-control"> {{$post->title}} </textarea>
                                @error('title')
                                <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="py-2 px-5 card shadow">
                                <div>
                                    <label for="" class="fw-bold">Old Image</label> <br>
                                    <img src="{{ asset('/storage/images/post_img') }}/{{ $post->image }}" height="100"
                                         alt="">
                                </div>
                                <label for="" class="fw-bold">Update Image:</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="fw-bold">Description:</label>
                            <textarea name="description" id="description" placeholder="Descriptions....."
                                      class="form-control ">{!! $post->description !!}</textarea>
                            @error('description')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="" class="fw-bold">Select Tags:</label>
                            <select name="tags[]" id="tags" class="form-control multiple_select" multiple>
                                @forelse($tags as $tag)
                                    <option
                                        value="{{ $tag->id }}" @selected(in_array($tag->id, $post->tags->pluck('id')->toArray()))>{{ $tag->name }}</option>
                                @empty
                                    <option value="">No tags</option>
                                @endforelse

                            </select>
                        </div>
                        <div class="col-md-6 mt-3 text-center">
                            <button type="submit" class="btn btn-primary">update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
