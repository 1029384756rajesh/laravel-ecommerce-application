export default function EditCategoryPage() {
    return (
        <div class="card mx-auto max-w-lg">
            <div class="card-header card-header-title">Edit Category</div>

            <form enctype="multipart/form-data" action="/admin/categories" class="card-body" method="post">


                <div class="form-group">
                    <label for="name" class="form-label">Name</label>

                    <input type="text" name="name" id="name" class="form-control" value="" />
                </div>

                <div class="form-group">
                    <label for="parentId" class="form-label">Parent Category</label>

                    <select name="parent_id" class="form-control" id="parentId">
                        <option></option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    )
}