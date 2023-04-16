@extends("admin.base")

@section("content")
<div class="container my-4 px-3">

    <div class="card">
        <div class="card-header fw-bold text-primary">Create New Category</div>

        <form enctype="multipart/form-data" action="/admin/categories" class="card-body" method="post">
            @csrf

            <x-form-control type="text" label="Name" id="name" name="name"/>

            <div class="mb-3">
                <label for="parent_id" class="form-label">Parent Category</label>
            <select name="parent_id" class="form-control form-select">
                <option></option>
                @foreach ($categories as $c)

                <option    value={{ $c["id"] }}> 
                    @if ($c["label"] > 1)
                        @for ($i = 1; $i < $c["label"]; $i++)
                        —
                        @endfor
                    @endif
                 
                    {{ $c["name"]}}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    
</div>
@endsection