<x-layout>
    @section('title')
        Tags
    @endsection

<div class="container mt-5">

    <div class="card">
        <div class="card-header">
            <h1 class="fw-bold text-center ">Tags table</h1>
        </div>
        <div class="card-body">
            @can('create-tag')
                <a href="" class="btn btn-primary mb-3  " data-bs-toggle="modal" data-bs-target="#create_tagModal">
                    Add tags</a>
            @endcan

            <table class="table table-hover">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tag_table">
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="create_tagModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Tag</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('tags.store')}}" method="post" id="tag-form">

                <div class="modal-body">
                    <div>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="fw-bold">Name:</label>
                                <input type="text" name="name" id="name" placeholder="Tag name"
                                       class="form-control">
                                <span class="error text-danger" id="name_error"></span>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button name="submit" id="save-btn" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>
{{--end modal tag create--}}

<!--  start Modal tag edit-->
<div class="modal fade" id="edit_tagModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="editTagModalData">


        </div>
    </div>
</div>
{{--end modal students--}}
        <div style="z-index: 999">
            @if (Session::has('success'))
                    <script>
                        $(document).ready(function (){
                            toastr.option={
                                "progressBar" : true,
                            }
                            toastr.success("{{Session::get('success')}}");
                        });
                    </script>
            @endif
        </div>
</x-layout>
<script type="text/javascript">

    $("#tag-form").submit(function (e) {
        e.preventDefault();
        var name = $("#name").val();
        $.ajax({
            type: "POST",
            url: "{{route('tags.store')}}",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            data: {
                "name": name,
            },

            beforeSend: function (){
                $("#save-btn").prop("disabled", true).html('Processing');
            },

            success: function (response) {

                $("#tag-form")[0].reset();
                $("#save-btn").prop("disabled",false).html("Save");
                $("#create_tagModal").modal('hide');
                fetch_tags();
            },
            error: function (error) {
                let errors = error.responseJSON;
                if ('errors' in error.responseJSON) {
                    $(".error").text('');
                    $.each(error.responseJSON.errors, (index, value) => {
                        $("#" + index + "_error").text(value[0]);
                    });
                }
            },

        })
    })
    $(document).ready(function () {
        fetch_tags();
    });

    function fetch_tags() {
        $.ajax({
            url: "{{route('tags.index')}}",
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response);

                $('#tag_table').empty();
                $.each(response, function (index, tag) {
                    $('#tag_table').append('<tr><td>' + tag.id + '</td><td>' + tag.name + '</td>' +
                        '<td> <button type="button"  class="btn btn-info edit_tag" data-id="' + tag.id + '" >Edit</button>  ' +
                        '<button type="button" class="btn btn-danger delete_tag"  data-id="' + tag.id + '">Delete</button> </td> </tr>');
                });
            }
        });
    }

    //     delete ajax method
    $(document).on('click', '.delete_tag', function () {
        var id = $(this).data("id");
        console.log('id', id);
        if (confirm('Are you sure to delete the record?')) {
            $.ajax({

                url: "delete_tag/" + id,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                data: {
                    "id": id,
                },

                success: function () {
                    fetch_tags();
                }
            });
        } else {
            return false;
        }

    })

    $(document).on('click', '.edit_tag', function (e) {
        e.preventDefault();
        var tag_id = $(this).data('id');
        let url = "{{ route('tags.edit', ":id") }}";
        url = url.replace(":id", tag_id);
        $("#editTagModalData").html('');

        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                console.log(response);
                if (response.status === 404) {
                    console.log("error");
                } else {
                    $("#editTagModalData").html(response);
                    $("#edit_tagModal").modal('show');
                }
            }
        })

        $("document").on('click', '.update_tag', function (e) {
            e.preventDefault();
            tag_id = $('#edit_tag_id').val();
            var data = {
                'name': $('#edit_name').val(),
            }
            $.ajax({
                type: "PUT",
                url: "/update_tags/" + tag_id,
                data: data,
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                }
            })

        })

    })
    $(document).on('submit', "#edit_tag_form", function (e) {
        e.preventDefault();
        let url = $(this).attr('action');
        console.log($(this).serialize())
        if (confirm('Are You sure you want Update!')) {
            $.ajax({
                type: "PUT",
                url: url,
                data: $(this).serialize(),
                dataType: "JSON",
                success: function (response) {
                    fetch_tags();
                    console.log(response);
                    $('#edit_tagModal').modal('hide')
                }
            })
        }

    });

</script>
