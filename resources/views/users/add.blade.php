<x-layout>

@section('title')
    Add users
@endsection
    <div class="container mt-5">
        <div class="card shadow ">
            <div class="card-header">
                <h1 class="text-center fw-bold">Create Users</h1>
            </div>
            <div class="card-body">
                <form action="{{route('register_save')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card shadow p-3">
                                <input type="hidden" name="check_login" value="add_by_admin">
                                <div>
                                    <label for="" class="fw-bold">Name:</label>
                                    <input type="text" name="name" placeholder="Enter User Name" value="{{old('name')}}"  class="form-control">
                                    @error('name')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="" class="fw-bold">Email:</label>
                                    <input type="email" name="email" placeholder="User Email" value="{{old('email')}}"  class="form-control">
                                    @error('email')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="" class="fw-bold">Image:</label>
                                    <input type="file" name="image" class="form-control">
                                    @error('image')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow p-3">
                                <div>
                                    <label for="" class="fw-bold">Password:</label>
                                    <input type="password" name="password" placeholder="Create Password"
                                           class="form-control">
                                    @error('password')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="" class="fw-bold">Confirm Password:</label>
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                           class="form-control">
                                    @error('password_confirmation')
                                    <span class="alert text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="" class="fw-bold">Assign Permissions:</label>
                                    <select name="permission[]" id="tags" class="form-control multiple_select"
                                            multiple>
                                        @forelse($permissions as $permission)
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @empty
                                            <option value="">No Permissions</option>
                                        @endforelse

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3 text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
<script>
    $(document).ready(function () {
        $('.multiple_select').select2();
        });
</script>
