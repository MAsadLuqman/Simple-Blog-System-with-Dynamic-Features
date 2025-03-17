<div class="modal-header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Enable Two way Auth</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="text-center">
    @if (Session::has('success'))
        {{$success}}
    @endif
    <img src="{{ asset('storage/images/qr/qr.svg') }}" alt="Qr code"/>
    <p>{{ $secretKey }}</p>
    <label>Please scan this QR Code with Google Authenticator App. Click on verify once scanned.</label>
</div>
<form action="{{route('verify-2fa',$user->id)}}" method="post" id="form_2fa">
    <div class="modal-body">
        <div>
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="google2fa_secret" id="key-2fa" value="{{ $secretKey }}"  class="form-control">
                    <label for="" class="fw-bold">Enter OTP:</label>
                    <input type="text" name="otp" id="otp" class="form-control">
                    <span class="error text-danger" id="otp_error"></span>
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button name="submit" class="btn btn-primary save_btn">Verfiy</button>
    </div>
</form>
