<x-layout>
    @section('title')
        Edit User
    @endsection
    <div class="container mt-5">
        <div class="card shadow ">
            <div class="card-header">
                <h1 class="text-center fw-bold">Update Profile</h1>
            </div>
            <div class="card-body">

                <form action="{{route('users.update',$user->id)}}" method="post" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-4 shadow">
                                <p>Current Photo:</p>
                                <img src="/storage/images/{{ $user->image }}" width="150"
                                     alt="{{$user->name}}'s image not fond">
                                <div class="mt-3">
                                    <label for="" class="fw-bold">Change Profile Photo:</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-4 shadow">
                                <div>
                                    <p><b>User ID :</b>
                                        <span class="badge bg-danger">{{$user->id}}</span>
                                    </p>
                                </div>
                                <div>
                                    <label for="" class="fw-bold">Update Email:</label>
                                    <input type="email" name="email" value="{{$user->email}}" class="form-control">
                                    @error('email')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="" class="fw-bold">Update Name:</label>
                                    <input type="text" name="name" value="{{$user->name}}" class="form-control">
                                    @error('name')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if(auth()->user()->roles->first()->name == 'admin')
                                    <div>
                                        <label for="" class="fw-bold">Select Tags:</label>
                                        <select name="permissions[]" id="tags" class="form-control multiple_select" multiple>
                                            @forelse($permissions as $permission)
                                                <option
                                                    value="{{ $permission->id }}" @selected(in_array($permission->id, $user->permissions->pluck('id')->toArray()))>{{ $permission->name }}</option>
                                            @empty
                                                <option value="">No tags</option>
                                            @endforelse

                                        </select>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-12 mt-5 text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
