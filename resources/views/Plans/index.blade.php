<x-layout>
    @section('title')
        Blogs | Plans
    @endsection
    <div class="container mt-5">
        <a href="{{route('plans.create')}}" class="btn btn-info">Create Plan</a>
        <h2 class="text-center fw-bold mb-4">Our Blog Packages</h2>
        <div class="row">
            @foreach($plans as $plan)
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-header bg-primary text-white">{{ $plan->name }}</div>
                        <div class="card-body">
                            <h5 class="card-title">${{ $plan->price }} / Month</h5>
                            <p class="card-text">{!! $plan->description !!}</p>

                            <form action="{{ route('stripe.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="name" value="{{ $plan->name }}">
                                <input type="hidden" name="price" value="{{ $plan->price }}">
                                <input type="hidden" name="description" value="{{ $plan->description }}">
                                <input type="hidden" name="stripe_id" value="{{ $plan->stripe_id }}">
                                <input type="hidden" name="price_id" value="{{ $plan->price_id }}">
                                <button type="submit" class="btn btn-primary">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        @if (Session::has('success'))
        $(document).ready(function (){
            toastr.options = {
                "progressBar" : true,
            }
            toastr.success("{{ Session::get('success') }}");
        });
        @endif
    </script>
</x-layout>
