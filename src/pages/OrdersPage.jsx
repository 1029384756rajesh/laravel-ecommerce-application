import { Link } from "react-router-dom";

export default function OrdersPage() {
    return (
        <div class="card">
        <div class="card-header card-header-title">Orders</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered min-w-[1024px]">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>status</th>
                            <th>Total Amount</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                          <tr>
                              <td>234</td>
                              <td>john@gmail.com</td>
                              <td>
                                    <div className="badge badge-success">Delivered</div>
                              </td>
                              <td>₹ 234</td>
                              <td>23-2-23</td>
                              <td>
                                  <Link to="/orders/3" class="btn btn-sm btn-primary">View</Link>
                              </td>
                          </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    )
}