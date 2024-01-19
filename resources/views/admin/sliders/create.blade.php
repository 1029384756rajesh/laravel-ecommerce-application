@extends("admin.base")

@section("head")
    <title>Create Slider</title>
@endsection

@section("content")
<div class="card mx-auto max-w-lg">
    <div class="card-header font-bold text-indigo-600">Create New Slider</div>

    <form action="/admin/sliders" class="card-body" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-5">
            <label class="form-label">Image</label>

            <input type="file" name="image" id="image" class="form-control">

            @error("image")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection