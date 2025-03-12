<x-layout>
    @section('title')
        Permissions
    @endsection
            <div class="card mt-5">
                <div class="card-header">
                    <h1 class="fw-bold text-center ">Permissions table</h1>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody id="permissions_table">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <x-slot name="permissions">
        <script>

            $(document).ready(function () {
                fetch_permissions();
            });
            function fetch_permissions(){
                $.ajax({
                    type:'GET',
                    url: '{{route('permissions.index')}}',
                    dataType: "json",
                    success:function (response){
                        $('#permissions_table').empty();
                        $.each(response, function (index, permission){
                            $('#permissions_table').append(
                                '<tr> <td>' + permission.id + '</td><td>' + permission.name + '</td>' +
                                '</tr>'
                            );
                        });
                    }
                });
            }
        </script>
        </x-slot>
</x-layout>
