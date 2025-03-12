<div class="modal-header">
    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Tag: {{ $tag->name }}</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('tags.update', $tag->id) }}" method="PUT" id="edit_tag_form">
    <div class="modal-body">
        <div>
            @method('PUT')
            @csrf
            <input type="hidden" name="edit_tag_id">
            <div class="row">
                <div class="col-md-12">
                    <label for="" class="fw-bold">Name:</label>
                    <input type="text" name="name" id="edit_name" value="{{ $tag->name }}" placeholder="Tag name" required class="form-control">
                </div>
            </div>
            <div>
            </div>
        </div>
    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button name="submit" class="btn btn-primary">Update</button>
    </div>
</form>
