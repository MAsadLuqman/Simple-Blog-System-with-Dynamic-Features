<div class="card  shadow">
    <div class="card-header">
        <h1 class="text-center fw-bold">Posts Tables</h1>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="tableview">
            @foreach($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td><img src="{{asset('storage/images/post_img')}}/{{ $post->image }}" alt="" width="50"></td>
                    <td>{{$post->title}}</td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" class="toggle-status" data-id="{{ $post->id }}" {{ $post->is_published ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </td>
                    <td>
                        @can('view-post')
                            <a href="{{route('posts.show',$post->slug)}}" class="btn btn-info "><i
                                    class="fa-solid fa-eye"></i></a>
                        @endcan
                        @can('update-post')
                            <a href="{{route('posts.edit',$post->id)}}" class="btn btn-success"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                        @endcan
                        @can('delete-post')
                            <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                               data-bs-target="#delete_userModal"><i class="fa-solid fa-trash"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
