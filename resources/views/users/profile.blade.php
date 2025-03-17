<x-layout>

    @section('title')
        User's Profie
    @endsection

    <div class="container">
        <a href="{{route('users.edit',$user->id)}}" class="btn btn-info my-3">Edit Profile</a>
        <div class="card   shadow">
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
                        <a href="#" class="btn btn-primary 2fa_btn" data-id="{{ auth()->user()->id}}" >Verify 2fa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Modal -->
        <div class="modal fade" id="2fa_Modal" tabindex="-1" aria-labelledby="2fa_ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="2fa_form">

                </div>
            </div>
        </div>

        <x-slot name="toggle2fa">
        <script>
            $(document).on('click', '.2fa_btn', function (e){
                e.preventDefault();
                let id = $(this).data("id");
                let url = "{{ route('enable-2fa', ':id')}}";
                url=url.replace(':id',id);
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (response){
                        $('#2fa_form').html(response)
                        $('#2fa_Modal').modal('show')
                    }

                })
            })
            $(document).on('submit', "#form_2fa", function (e) {
                e.preventDefault();
                let url = $(this).attr('action');
                console.log($(this).serialize())
                if (confirm('Are You sure you want Enable Two way Auth!')) {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: $(this).serialize(),
                        dataType: "JSON",
                        beforeSend: function (){
                            $(".save_btn").prop("disabled", true).html('Verifying');
                        },

                        success: function (response) {
                            console.log(response)
                            if(response.status === true){
                                $("#success").text(response.success)
                                $(".save_btn").prop("disabled", false).html('Verify');
                                $('#2fa_Modal').modal('hide');
                            }
                            if(response.status === false){
                                $("#otp_error").text(response.success)
                                $(".save_btn").prop("disabled", false).html('Verify');
                            }
                        },
                        error: function (error) {
                            let errors = error.responseJSON;
                            if ('errors' in error.responseJSON) {
                                $(".error").text('');
                                $.each(error.responseJSON.errors, (index, value) => {
                                    $("#" + index + "_error").text(value[0]);
                                });
                            }
                            $(".save_btn").prop("disabled", false).html('Verify');
                        },

                    })
                }

            });
        </script>
    </x-slot>

</x-layout>



