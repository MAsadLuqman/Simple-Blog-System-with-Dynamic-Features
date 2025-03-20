<x-layout>
    @section( 'title')
        Create Plan
    @endsection
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center fw-bold">Create Plan</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('plans.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="" class="fw-bold">Title:</label>
                            <input type="text" name="name" placeholder="Enter Plan name" class="form-control">
                            @error('name')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold" for="specificSizeInputGroupUsername " >Price:</label>
                            <div class="input-group">
                                <div class="input-group-text">$</div>
                                <input type="number" name="price" placeholder="Enter Plan Price" id="specificSizeInputGroupUsername"  class="form-control">
                            </div>
                            @error('price')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="" class="fw-bold">Stripe ID:</label>
                            <input type="text" name="stripe_id" placeholder="Enter Stripe Id" class="form-control">
                            @error('stripe_id')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="" class="fw-bold">Description:</label>
                            <textarea name="description" id="description"   placeholder="Descriptions....."
                                      class="form-control " ></textarea>
                            @error('description')
                            <span class="alert text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="md-4 mt-3">
                            <button type="submit" class="btn btn-primary ">create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
