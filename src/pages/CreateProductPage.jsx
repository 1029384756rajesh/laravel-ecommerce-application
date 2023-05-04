import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default function CreateProductPage() {
    return (
        <div class="card mx-auto max-w-3xl">
            <div class="card-header card-header-title">Create New Product</div>

            <form enctype="multipart/form-data" action="/admin/products/store" class="card-body" method="post">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>

                    <input type="text" name="name" id="name" value="" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="categoryId" class="form-label">Category</label>

                    <select name="category_id" class="form-control" id="categoryId">
                        <option></option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="shortDescription" class="form-label">Short Description</label>

                    <input type="text" name="short_description" id="shortDescription" class="form-control" />
                </div>

                <div class="form-group">
                    <label class="form-label" for="editor">Description</label>

                    <CKEditor
                        editor={ClassicEditor}
                        data="<p>Hello from CKEditor 5!</p>"
                        onReady={editor => {
                            // You can store the "editor" and use when it is needed.
                            console.log('Editor is ready to use!', editor);
                        }}
                        onChange={(event, editor) => {
                            const data = editor.getData();
                            console.log({ event, editor, data });
                        }}
                        onBlur={(event, editor) => {
                            console.log('Blur.', editor);
                        }}
                        onFocus={(event, editor) => {
                            console.log('Focus.', editor);
                        }}
                    />
                </div>

                <div class="form-group">
                    <label for="price" class="form-label">Price</label>

                    <input type="number" name="price" id="price" value="" class="form-control" />
                </div>

                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>

                    <input type="number" name="stock" id="stock" value="" class="form-control" />
                </div>

                <div class="form-group form-check">
                    <input type="hidden" name="has_variations" value="0" />

                    <input type="checkbox" name="has_variations" id="hasVariations" class="form-check-input" value="1" />

                    <label for="hasVariations" class="form-check-label">Has Variations</label>
                </div>

                <div class="form-group">
                    <label class="form-label">Gallery</label>

                    <div class="flex flex-wrap gap-2">
                        <ul id="gallery" class="flex flex-wrap gap-2">

                            <li class="relative group h-20 w-20 rounded border border-gray-300 overflow-hidden">
                                <div data-fp-remove class="group-hover:flex hidden absolute inset-0 bg-black bg-opacity-50 items-center justify-center text-white">
                                    <i class="fa fa-close text-2xl cursor-pointer"></i>
                                </div>

                                <input type="hidden" name="images[]" value="" />

                                <img src="https://cdn.pixabay.com/photo/2023/04/21/15/42/portrait-7942151_640.jpg" class="w-full h-full object-cover" />
                            </li>
                        </ul>

                        <img src="/images/placeholder.png" data-fp="multiple" data-fp-container="#gallery" data-fp-name="images[]" class="rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer" />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    )
}