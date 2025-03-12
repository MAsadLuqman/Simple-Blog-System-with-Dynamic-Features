<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title','good')
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<!-- Sidebar -->
<div class="sidebar-master">
    <div class="sidebar-general">
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <img src="{{asset('image/hybrid_web_logo.png')}}" height="40"  alt="">
            </div>
            <ul>
                <a href="{{route('dashboard')}}" class="sidebar-link">
                <li data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                    <i class="fas fa-home"></i><span class="sidebar-text">
                        Dashboard
                    </span>
                </li>
                </a>
                @can('view-user')
                    <a href="{{route('users.index')}}" class="sidebar-link">
                    <li data-bs-toggle="tooltip" data-bs-placement="right" title="Profile">
                    <i class="fas fa-user"></i><span class="sidebar-text">
                        Users
                    </span>
                    </li>
                    </a>
                @endcan
                @can('view-post')
                    <a href="{{route('posts.index')}}" class="sidebar-link">
                    <li data-bs-toggle="tooltip" data-bs-placement="right" title="Settings">
                        <i class="fas fa-cogs"></i><span class="sidebar-text">
                        Posts
                    </span>
                    </li>
                    </a>
                @endcan
                @can('view-tag')
                    <a href="{{route('tags.index')}}" class="sidebar-link">
                    <li data-bs-toggle="tooltip" data-bs-placement="right" title="Messages">
                        <i class="fa-solid fa-tags"></i><span class="sidebar-text">
                            Tags
                    </span>
                    </li>
                    </a>
                @endcan

                <li data-bs-toggle="tooltip" data-bs-placement="right" title="Messages">
                    <i class="fa-solid fa-lock"></i><span class="sidebar-text">
                        <a href="{{route('permissions.index')}}" class="sidebar-link">Permissions</a>
                    </span>
                </li>
                <li data-bs-toggle="tooltip" data-bs-placement="right" title="Logout">
                    <i class="fas fa-sign-out-alt"></i><span class="sidebar-text">
                        <a href="{{route('logout')}}" class="sidebar-link">Logout</a>
                    </span>
                </li>
            </ul>
        </div>

        <!-- Navbar -->
        <nav class="navbar" id="navbar">
            <span class="toggle-btn" id="toggle-btn" onclick="toggleSidebar()">☰</span>

            <div class="d-flex align-items-center">
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('/storage/images') }}/{{ auth()->user()->image }}" height="30px" alt="User" class="rounded-circle me-2">
                        <span>{{auth()->user()->name}}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{route('profile')}}">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{route('logout')}}">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="content mt-5">
           {{$slot}}
        </div>
    </div>
</div>

<!-- JavaScript -->

<script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let navbar = document.getElementById("navbar");
        let logoImg = document.querySelector(".logo img");

        sidebar.classList.toggle("collapsed");
        navbar.classList.toggle("collapsed");

        // Change logo image based on sidebar state
        if (sidebar.classList.contains("collapsed")) {
            logoImg.src = "{{asset('image/1.png')}}";  // Change to collapsed logo
        } else {
            logoImg.src = "{{asset('image/hybrid_web_logo.png')}}"; // Change to default logo
        }

        // Re-initialize tooltips when sidebar is collapsed
        let sidebarCollapsed = sidebar.classList.contains("collapsed");
        let tooltipElements = document.querySelectorAll("[data-bs-toggle='tooltip']");

        tooltipElements.forEach(el => {
            let tooltip = bootstrap.Tooltip.getInstance(el);
            if (tooltip) tooltip.dispose(); // Remove existing tooltip instance
            if (sidebarCollapsed) {
                new bootstrap.Tooltip(el); // Re-add tooltip when sidebar is collapsed
            }
        });


    }

</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.tiny.cloud/1/g0go5idxuyafxxd7bdojxj10flfbks4vvfet9p9h9m9hpbfg/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        $('.multiple_select').select2();
        tinymce.init({
            selector: '#description',
            plugins: [
                // Core editing features
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
                // Your account includes a free trial of TinyMCE premium features
                // Try the most popular premium features until Mar 12, 2025:
                'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
            ],
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [
                {value: 'First.Name', title: 'First Name'},
                {value: 'Email', title: 'Email'},
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        });
    });
    function deletePost(route) {
        $("#postDeleteBtn").attr('href', route);
        $("#delete_postModal").modal('show');
    }
</script>
@if(isset($usersearch))
{{$usersearch}}
@endif
@if(isset($postssearch))
    {{$postssearch}}
@endif
@if(isset($permissions))
    {{$permissions}}
@endif
@if(isset($alert))
    {{$alert}}
@endif
</body>
</html>
