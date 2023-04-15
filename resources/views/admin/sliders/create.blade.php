@extends("admin.base")

@section("content")
<div class="container my-4 px-3">

    <div class="card">
        <div class="card-header fw-bold text-primary">Create New Slider</div>

        <form enctype="multipart/form-data" action="/admin/sliders" class="card-body" method="post">
            @csrf

            {{-- <x-form-control type="text" label="Image" id="image_url" name="image_url"/> --}}

            <label for="" class="form-label">Image</label>
            <x-server-image name="image_url" style="height:60px;width:60px;object-fit:cover"/>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    
</div>
@endsection