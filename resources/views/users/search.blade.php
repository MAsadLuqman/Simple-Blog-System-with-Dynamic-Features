
@forelse($users as $user)
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
@empty
    <p class="text-center mt-2">No Users Found! </p>
@endforelse

