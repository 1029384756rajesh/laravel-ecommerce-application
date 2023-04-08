@extends('admin.base')

@section('content')
<form action="" class="my-card mx-auto my-4 px-2" style="max-width: 700px">
    <div class="my-header">Create New Product</div>

    <div class="p-4">
        <div class="mb-3">
            <label for="name" class="form-la">Name</label>
            <input type="text" id="name" name="name" class="form-con">
        </div>

        <div class="mb-3">
            <label for="price" class="form-la">Price</label>
            <input type="number" id="price" name="price" class="form-con">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-la">Stock</label>
            <input type="number" id="stock" name="stock" class="form-con">
        </div>

        <div class="mb-3">
            <label for="short_description" class="form-la">Short Description</label>
            <input type="number" id="short_description" name="short_description" class="form-con">
        </div>

        <div class="mb-3">
            <label for="description" class="form-la">Description</label>
            <textarea name="description" id="description" cols="30" rows="10" class="form-con"></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-la">Category</label>
            <select name="category" id="category" name="category" class="form-con form-select">
                <option value=""></option>
                <option value="1">Tshirt</option>
                <option value="1">Shirt</option>
                <option value="1">Jeans</option>
            </select>
        </div>

        <div class="mb-3 checkboxcontainer">
            <input type="checkbox" id="has_variations" onchange="showAttributes(event)" class="fout checkbox">
            <label for="has_variations" class="form-ch">Has Variations</label>
        </div>

        <div class="mb-4 checkboxcontainer">
            <input type="checkbox" id="is_featured" class="fout checkbox">
            <label for="is_featured" class="form-ch">Is Featured</label>
        </div>

        <button class="my-btn w-100">Save</button>
    </div>
</form>
@endsection
