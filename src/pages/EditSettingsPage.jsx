export default function EditSettingsPage() {
    return (
        <div class="card mx-auto max-w-3xl">
            <div class="card-header card-header-title">Edit Setting</div>

            <form action="/admin/settings" class="card-body" method="post">

                <div class="form-group">
                    <label for="about" class="form-label">About</label>

                    <input
                        type="text"
                        name="about"
                        id="about"
                        value=""
                        class="form-control"
                    />
                </div>

                <div class="form-group">
                    <label for="mobile" class="form-label">Mobile</label>

                    <input
                        type="text"
                        name="mobile"
                        id="mobile"
                        value=""
                        class="form-control"
                    />
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        value=""
                        class="form-control"
                    />
                </div>

                <div class="form-group">
                    <label for="gst" class="form-label">Gst</label>

                    <input
                        type="number"
                        name="gst"
                        id="gst"
                        value=""
                        class="form-control"
                    />
                </div>

                <div class="form-group">
                    <label for="shippingCost" class="form-label">Shipping Cost</label>

                    <input
                        type="number"
                        name="shipping_cost"
                        id="shippingCost"
                        value=""
                        class="form-control"
                    />
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    )
}