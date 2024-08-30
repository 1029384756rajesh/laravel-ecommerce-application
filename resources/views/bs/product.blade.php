<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Form</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->

        <script src="https://cdn.tailwindcss.com"></script>

        @vite('resources/css/app.css')
    <style>
        .form-control-color {
            max-width: 50px;
        }

        i {
            font-size: 20px;
            margin: 0px !important;
            padding: 0px !important;
            cursor: pointer;
        }

        .option-image {
            height: 38px; width: 38px; object-fit: cover;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto my-8">
        <div class="border border-gray-300 rounded-md bg-white">
            <div class="border-b border-gray-300 px-4 py-3 font-bold text-indigo-600">Basic</div>

            <div class="p-4">
                <div class="mb-4">
                    <label for="name" class="inline-block mb-2">Name <span class="text-red-600">*</span></label>
                    <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" id="name" name="name"
                        value="{{ old('name', $product->name ?? null) }}">
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label for="category_id" class="inline-block mb-2">Category <span class="text-red-600">*</span></label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" id="category_id" name="category_id">
                            <option value=""></option>
                        </select>
                    </div>

                    <div>
                        <label for="brand_id" class="inline-block mb-2">Brand</label>
                        <select class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" id="brand_id" name="brand_id">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="short_description" class="inline-block mb-2">Short Description</label>
                    <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" id="short_description" name="short_description"
                        value="{{ old('short_description', $product->short_description ?? null) }}">
                </div>

                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-6">
                        <label for="gst" class="inline-block mb-2">Gst</label>
                        <input type="number" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" id="gst" name="gst"
                            value="{{ old('gst', $product->gst ?? null) }}">
                    </div>

                    <div class="col-md-6">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="inline-block mb-2"></label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="has_variations"
                                        name="has_variations" {{ old('has_variations', $product->has_variations ?? null) ? 'checked' : null }}>
                                    <label class="form-check-label" for="has_variations">Has Variations</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="inline-block mb-2"></label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_downloadable"
                                        name="is_downloadable" {{ old('is_downloadable', $product->is_downloadable ?? null) ? 'checked' : null }}>
                                    <label class="form-check-label" for="is_downloadable">Downloadable</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="description" class="inline-block mb-2">Description</label>
                    <textarea class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" id="description" name="description"
                        value="{{ old('description', $product->description ?? null) }}"></textarea>
                </div>
            </div>
        </div>

        <div class="border border-gray-300 rounded-md bg-white mt-4" id="detailInfoCard">
            <div class="card-header fw-bold text-primary">Detail Info</div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="price" class="inline-block mb-2">Price <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ old('price', $variation->price ?? null) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="stock" class="form-label">Stock <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="stock" name="stock"
                            value="{{ old('stock', $variation->stock ?? null) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" class="form-control" id="link" name="link"
                            value="{{ old('link', $variation->link ?? null) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="expiry" class="form-label">Expiry</label>
                        <input type="datetime-local" class="form-control" id="expiry" name="expiry"
                            value="{{ old('expiry', $variation->expiry ?? null) }}">
                    </div>

                    <div class="col-md-4" id="limitGroup">
                        <label for="limit" class="form-label">Limit</label>
                        <input type="number" class="form-control" id="limit" name="limit"
                            value="{{ old('limit', $variation->limit ?? null) }}">
                    </div>

                    <div class="col-md-4" id="lengthGroup">
                        <label for="length" class="form-label">Length</label>
                        <input type="number" class="form-control" id="length" name="length"
                            value="{{ old('length', $variation->length ?? null) }}">
                    </div>

                    <div class="col-md-4" id="breadthGroup">
                        <label for="breadth" class="form-label">Breadth</label>
                        <input type="number" class="form-control" id="breadth" name="breadth"
                            value="{{ old('breadth', $variation->breadth ?? null) }}">
                    </div>

                    <div class="col-md-4" id="heightGroup">
                        <label for="height" class="form-label">Height</label>
                        <input type="number" class="form-control" id="height" name="height"
                            value="{{ old('height', $variation->height ?? null) }}">
                    </div>

                    <div class="col-md-4" id="weightGroup">
                        <label for="weight" class="form-label">Weight <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="weight" name="weight"
                            value="{{ old('weight', $variation->weight ?? null) }}">
                    </div>
                </div>

                <div>
                    <label for="images">Image</label>
                    <div id="image-previews" class="d-flex flex-wrap"></div>
                    <input type="file" class="form-control-file" id="images" multiple>
                </div>
            </div>
        </div>

        <div class="border border-gray-300 rounded-md bg-white mt-4">
            <div class="border-b border-gray-300 px-4 py-2 flex items-center justify-between">
                <span class="font-bold text-indigo-600">Attributes</span>
                <i class="bi bi-plus" id="addAttribute"></i>
            </div>

            <div class="p-4 grid grid-cols-2 gap-3">
            <div class="border border-gray-300 rounded-md">
                            <div class="border-b border-gray-300 px-4 py-2 flex items-center justify-end gap-3">
                                <i class="bi bi-x attribute-remove"></i>
                                <i class="bi bi-list"></i>
                            </div>

                            <div class="p-4">
                                <div class="mb-4">
                                    <label class="inline-block mb-2">Attribute <span class="text-red-600">*</span></label>
                                    <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" name="name">
                                </div>

                                <div class="mb-4">
                                    <label class="inline-block mb-2">Type <span class="text-red-600">*</span></label>
                                    <select class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none form-select" name="type">
                                        <option value="label">Label</option>
                                        <option value="color">Color</option>
                                        <option value="image">Image</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="inline-block mb-2">Options <span class="text-red-600">*</span></label>
                                    <div class="flex flex-col gap-3">
                                        <div class="flex justify-start items-center gap-2">
                                            <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" name="name">
                                            <i class="bi bi-plus option-add"></i>
                                        </div>
                                        <div class="flex justify-start items-center gap-2">
                                            <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" name="name">
                                            <i class="bi bi-plus option-add"></i>
                                        </div>
                                        <div class="flex justify-start items-center gap-2">
                                            <input type="text" class="w-full border border-gray-300 rounded-md px-3 py-1.5 focus:ring-1 focus:ring-indigo-600 outline-none" name="name">
                                            <i class="bi bi-plus option-add"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>


        <div class="mt-4">
            <button id="btnSave" class="btn btn-primary">Save</button>
            <button id="btnCancel" class="btn btn-outline-primary ml-2">Cancel</button>
        </div>
    </div>

    <script>
        function get_option(type) {
            if (type === 'image') {
                return (`
                    <div class="d-flex justify-content-start align-items-center gap-2 option">
                        <label class="option-value">
                            <input type="file" class="d-none">
                            <img src="" class="border option-image">
                        </label>
                        <input type="text" class="form-control" name="name">
                        <i class="bi bi-dash option-remove"></i>
                    </div>
                `)
            }

            if (type === 'color') {
                return (`
                    <div class="d-flex justify-content-start align-items-center gap-2 option">
                        <input type="color" class="form-control form-control-color" name="value">
                        <input type="text" class="form-control" name="name">
                        <i class="bi bi-dash option-remove"></i>
                    </div>
                `)
            }

            if(type === 'label') {
                return (`
                    <div class="d-flex justify-content-start align-items-center gap-2 option">
                        <input type="text" class="form-control" name="name">
                        <i class="bi bi-dash option-remove"></i>
                    </div>
                `)
            }
        }

        function get_attribute_view() {
            return (`
                <div class="col-md-6 attribute">
                    <div class="card">
                        <div class="card-header d-flex align-items-center gap-2 justify-content-end">
                            <i class="bi bi-x attribute-remove"></i>
                            <i class="bi bi-list"></i>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Attribute <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="type">
                                    <option value="label">Label</option>
                                    <option value="color">Color</option>
                                    <option value="image">Image</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Options <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2 options">
                                    <div class="d-flex justify-content-start align-items-center gap-2 option">
                                        <input type="text" class="form-control" name="name">
                                        <i class="bi bi-plus option-add"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `)
        }

        $(document).ready(function () {
            $("#addAttribute").click(function () {
                const attribute_view = get_attribute_view()
                // alert(attribute_view)

                $("#attributes").append(attribute_view)
            })


            $(".attributes").on("click", ".attribute bi-plus", function () {

            })

            $("#attributes").on("click", ".attribute-remove", function(){
                $(this).closest(".attribute").remove()
            })

            $("#attributes").on("click", ".option-add", function(){
                const type = $(this).closest(".attribute").find('[name=type] option:selected').val()
                console.log(type);
                const option_view = get_option(type)

                $(this).closest('.attribute').find('.options').append(option_view)
            })

            $("#attributes").on("click", ".option-remove", function(){
                $(this).closest('.option').remove()
            })

            $("#attributes").on("change", "[name=type]", function(){
                $(this).closest('.attribute').find(".option [name=value],.option .option-value").remove()

                const type = $(this).closest(".attribute").find('[name=type] option:selected').val()

                if(type === 'image') {
                    $(this).closest('.attribute').find(".option").prepend(`
                        <label class="option-value">
                            <input type="file" class="d-none">
                            <img src="" class="border option-image">
                        </label>
                    `)
                }

                if(type === 'color') {
                    $(this).closest('.attribute').find(".option").prepend(`
                        <input type="color" class="form-control form-control-color" name="value">
                    `)
                }
            })
        })
    </script>
</body>

</html>