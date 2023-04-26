@extends("admin.base")

@section("head")
<title>Create Slider</title>
@endsection

@section("content")
<div class="container my-4 px-3">
    <div class="card mx-auto max-w-lg">
        <div class="card-header font-bold text-indigo-600">Create New Slider</div>

        <form action="/admin/sliders" class="card-body" method="post">
            @csrf

            <div class="mb-5">
                <label class="form-label">Image</label>

                <div class="h-24 w-24 border border-gray-300 cursor-pointer" data-fp="single" data-fp-input="input[name=image_url]" data-fp-preview="img">
                    <input type="hidden" name="image_url">
                    <img src="/assets/placeholder.png" class="h-full w-full object-cover block">
                </div>

                @error("image_url")
                    <div class="mt-1 text-red-600">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection