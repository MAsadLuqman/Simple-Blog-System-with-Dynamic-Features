<x-layout>
    @section('title')
        View Users
    @endsection
    <div class="container">
        @can('update-user')
            <a href="{{route('users.edit',$user->id)}}" class="btn btn-info my-3">Edit Profile</a>
        @endcan

        <div class="card shadow mt-5">
            <div class="card-body">
                <div class="d-flex justify-items-center align-item-center">
                    <div>
                        <img src="/storage/images/{{ $user->image }}" width="150"
                             alt="{{$user->name}}'s image not fond">
                    </div>
                    <div class="mx-4 my-4">
                        <div>
                            ID : <span class="text-info">{{$user->id}}</span>
                        </div>
                        <div>
                            Name : <span class="text-info">{{$user->name}}</span>
                        </div>
                        <div>
                            Email : <span class="text-info">{{$user->email}}</span>
                        </div>
                        <div>
                            <p>
                                <strong>Permissions:</strong>
                                @foreach($user->Permissions as $permission)
                                    <span class="badge bg-primary">
                                    {{$permission->name}}
                                </span>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</x-layout>

