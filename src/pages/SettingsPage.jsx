import { Link } from "react-router-dom";

export default function SettingsPage() {
    return (
        <div class="container my-4 px-3">
    <div class="card mx-auto max-w-5xl">
        <div class="card-header flex items-center justify-between">
            <span class="card-header-title">Setting</span>
            <Link to="/settings/edit" class="btn btn-sm btn-primary">Edit Settings</Link>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div class="table min-w-[800px]">
                    <table>
                        <tr>
                            <td>About Us</td>
                            <td>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis quidem tempore quisquam quam mollitia debitis quo doloremque est ullam reprehenderit.</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>john@gmail.com</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>8474658473</td>
                        </tr>
                        <tr>
                            <td>GST</td>
                            <td>4%</td>
                        </tr>
                        <tr>
                            <td width="20%">Shipping Cost</td>
                            <td>56</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    )
}