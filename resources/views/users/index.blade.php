<x-layout>
@section('title')
    Users
@endsection

    <div class="container">
        <div class="text-end">
            @can('create-user')
                <a href="{{route('users.add')}}" class="btn btn-primary mb-3 mt-2 ">Add users</a>
            @endcan
                <a href="{{route('users.pdf')}}" class="btn btn-info mb-3 mt-2 ">Generate PDF</a>

        </div>


        <div class="card  shadow">
            <div class="card-header">
                <h1 class="text-center fw-bold">Users Tables</h1>
            </div>
            <div class="card-body">
                <div class="col-md-5 mb-3">
                    <input type="text" class="form-control" id="search" placeholder="Search Users">
                </div>
                <table class="table table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="usersearch">
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><img src="{{asset('storage/images')}}/{{ $user->image }}" alt="" width="50"></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @can('view-user')
                                    <a href="{{route('users.show',$user->id)}}" class="btn btn-info "><i
                                            class="fa-solid fa-eye"></i></a>
                                @endcan
                                @can('update-user')
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-success"><i
                                            class="fa-solid fa-pen-to-square"></i></a>
                                @endcan
                                @can('delete-user')
                                    <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                                       data-bs-target="#delete_userModal"><i class="fa-solid fa-trash"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="delete_userModal" tabindex="-1" aria-labelledby="delete_userModalLabel"
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
                    <a href="{{route('users.destroy',$user->id)}}" class="btn btn-primary">Save changes</a>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="usersearch">
        <script>
            $(document).ready(function(){
                $("#search").on('keyup', function(){
                    var query = $(this).val();
                    $.ajax({
                        type: 'GET',
                        url: '{{ route("users.search") }}',
                        data: { search: query },
                        success: function(data){
                            $("#usersearch").html(data);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                });
            });
        </script>
    </x-slot>
   <x-slot name="alert">
       @if (Session::has('success'))
           <div class=" mt-4">
               <script>
                   $(document).ready(function (){
                       toastr.option={
                           "progressBar" : true,
                       }
                       toastr.success("{{Session::get('success')}}");
                   });
               </script>
           </div>
       @endif
   </x-slot>
</x-layout>

