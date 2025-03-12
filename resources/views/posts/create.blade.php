<x-layout>
    @section('title')
        Create Posts
    @endsection
    <div class="container mt-5">
        <div class="card shadow ">
            <div class="card-header">
                <h1 class="text-center fw-bold">Create Blog Post</h1>
            </div>
            <div class="card-body">
                <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="fw-bold">Title:</label>
                            <input type="text" name="title" placeholder="Blog Title:" value="{{old('title')}}" class="form-control">
                            @error('title')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="" class="fw-bold">Image:</label>
                            <input type="file" name="image" class="form-control" value="value="{{old('image')}}" ">
                            @error('image')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="" class="fw-bold">Description:</label>
                            <textarea name="description" id="description"   placeholder="Descriptions....."
                                      class="form-control " ></textarea>
                            @error('description')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="" class="fw-bold">Select Tags:</label>
                            <select name="tags[]" id="tags" class="form-control multiple_select" multiple>
                                @forelse($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @empty
                                    <option value="">No tags</option>
                                @endforelse

                            </select>
                        </div>
                        <div class="col-md-6 mt-3 text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-layout>
