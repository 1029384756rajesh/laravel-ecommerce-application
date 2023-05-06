@extends("admin.base")

@section("head")
    <title>Create Slider</title>
@endsection

@section("content")
<div class="card mx-auto max-w-lg">
    <div class="card-header font-bold text-indigo-600">Create New Slider</div>

    <form action="/admin/sliders" class="card-body" method="post">
        @csrf

        <div class="mb-5">
            <label class="form-label">Image</label>

            <div>
                <input type="hidden" name="image">
                <img src="/uploads/images/placeholder.png"  data-fp="single" data-fp-input="input[name=image]" class="h-24 w-24 object-cover border border-gray-300 cursor-pointer">
            </div>

            @error("image_url")
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection