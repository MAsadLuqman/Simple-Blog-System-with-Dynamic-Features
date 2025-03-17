
<x-layout>
    @section('title')
        Blogs
    @endsection
        <x-slot name="alert">
           <div class="mt-5">
               @if (Session::has('success'))
                   <div class=" mt-4">
                       <script>
                           $(document).ready(function (){
                               toastr.error("{{Session::get('success')}}");
                               toastr.option = {
                                   "progressBar" : true,
                                   "positionClass": "toast-bottom-right",
                               }
                           });
                       </script>
                   </div>
               @endif
           </div>
        </x-slot>

            <button onclick="change('table-view-btn')" id="table-view-btn" class="btn btn-info mt-3 mb-3">Table view</button>
            <button onclick="change('gird-view-btn')" id="Gird-view-btn" class="btn btn-info mt-3 mb-3">Gird view</button>
            @can('create-post')
                <a href="{{route('posts.create')}}" class="btn btn-primary mt-3 mb-3">Add Blogs</a>
            @endcan

        <div id="post-view">
            <div class="auto-load text-center" style="display: none;">
                <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink"
                     x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0"
                     xml:space="preserve">
            <path fill="#000"
                  d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">

                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"

                                  from="0 50 50" to="360 50 50" repeatCount="indefinite"/>

            </path>

        </svg>

            </div>
        </div>
            <div>

            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="delete_postModal" tabindex="-1" aria-labelledby="delete_userModalLabel"
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
                        <a href="#" class="btn btn-primary" id="postDeleteBtn">Save changes</a>
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="postssearch">
            <script>
                $(document).on('submit', '#searchForm', function (e) {
                    e.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: '{{ route("posts.search") }}',
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        data: $(this).serialize(),
                        beforeSend: function() {
                            $("#search-btn").prop("disabled", true).html('Processing');

                        },
                        success: function (response) {
                            console.log(response);
                            $('#postssearch').html(response);
                        },
                        error: function(xhr, status, error) {
                        },
                        complete:function(){
                            $("#search-btn").prop("disabled",false).html('Search');


                        }
                    });
                });
                    $(document).ready(function () {
                        change('table-view-btn')
                    $(document).on('change','.toggle-status', function () {
                        const postId = $(this).data('id');
                        const is_published = $(this).is(':checked') ? 1 : 0;

                        $.ajax({
                            url: `/post/toggle/${postId}`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                is_published: is_published
                            },
                            success: function (response) {
                                toastr.success(response.message);
                                toastr.option = {
                                    "progressBar" : true,
                                    "positionClass": "toast-bottom-right",
                                }
                                ;
                            },
                            error: function (xhr) {
                                alert('An error occurred: ' + xhr.responseJSON.message);
                            }
                        });
                    });
                });

                    function change(type){
                        let url = "{{ route('posts.tableview') }}";
                        $("#table-view").html('');


                        $.ajax({
                            type: "GET",
                            url: url,
                            data: {type:type},
                            beforeSend: function () {
                                $('.auto-load').show();
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.status === 404) {
                                    console.log("error");
                                } else {
                                    $("#post-view").html(response);
                                    $('.auto-load').hide();
                                }
                            }
                        });
                    }

            </script>

        </x-slot>
</x-layout>




