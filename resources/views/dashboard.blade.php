
<x-layout>
    @section('title')
        dashboard
    @endsection
    <div class="container mt-5 mb-5 ">
        <div class="row">
            @can('view-user')
                <div class="col-lg-4">
                    <div class="card shadow">
                        <a href="{{route('users.index')}}" style="text-decoration: none">
                            <div class="card-body bg-info text-white">
                                <h1 class="fw-bold" style="font-size: 30px">Users
                                </h1>
                                <i class="fa-solid fa-users fa-3x text-muted mt-3 ml-5"></i>
                                <h3 class="fw-bold mt-3">Total Users :
                                    <span class="ml-5">{{$totalUsers}}</span>
                                </h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan
            @can('view-post')
                <div class="col-lg-4">
                    <div class="card shadow">
                        <a href="{{route('posts.index')}}" style="text-decoration: none">
                            <div class="card-body bg-warning text-white">
                                <h1 class="fw-bold" style="font-size: 30px">Posts
                                </h1>
                                <i class="fa-solid fa-signs-post fa-3x text-muted mt-3 ml-5"></i>
                                <h3 class="fw-bold mt-3">Total Posts :
                                    <span class="ml-5">{{$totalPosts}}</span>
                                </h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan
            @can('view-tag')
                <div class="col-lg-4">
                    <div class="card shadow">
                        <a href="{{route('tags.index')}}" style="text-decoration: none">
                            <div class="card-body bg-success text-white">
                                <h1 class="fw-bold" style="font-size: 30px">Tags
                                </h1>
                                <i class="fa-solid fa-tags fa-3x text-muted mt-3 ml-5"></i>
                                <h3 class="fw-bold mt-3">Total Tags :
                                    <span class="ml-5">{{$totalTags}}</span>
                                </h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endcan

        </div>
    </div>
</x-layout>
