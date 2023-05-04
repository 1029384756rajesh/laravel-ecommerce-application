import { FaCheck } from "react-icons/fa"

export default function OrderDetailsPage() {
    return (
        <div class="grid grid-cols-12 gap-4 items-start">
    <div class="col-span-12 lg:col-span-8 card">
        <div class="card-header card-header-title">Products</div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table min-w-[700px]">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" height="70px" width="70px" class="img-fluid"/>
                                            <div>Men's regular fit tshirt : Size - S, Color - Red</div>
                                        </div>
                                    </td>
                                    <td>₹ 345</td>
                                    <td>5</td>
                                </tr>                  
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" height="70px" width="70px" class="img-fluid"/>
                                            <div>Men's regular fit tshirt : Size - S, Color - Red</div>
                                        </div>
                                    </td>
                                    <td>₹ 345</td>
                                    <td>5</td>
                                </tr>                  

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-span-12 lg:col-span-4 space-y-4">
        <div class="card">
            <div class="card-header card-header-title">Payment Details</div>
            <div class="card-body">
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Product Price</span>
                    <span>₹ 34</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Gst (5%)</span>
                    <span>₹ 788</span>
                </p>
                <p class="flex items-center justify-between border-b border-gray-300 pb-3 mb-3">
                    <span>Shipping Cost</span>
                    <span>₹ 456</span>
                </p>
                <p class="flex items-center justify-between">
                    <span>Total Payable</span>
                    <span>₹ 456</span>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-title">Shipping Address</div>
            <div class="card-body">
                <p class="border-b border-gray-300 pb-3 mb-3">Name - J.P Nagar, Banglore</p>
                <p class="border-b border-gray-300 pb-3 mb-3">Mobile - 9484756474</p>
                <p>Address - Banglore, India</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header card-header-title">Status</div>
            <div class="card-body">
                <form method="post" action="/admin/orders/{{ $order->id }}" class="flex">
                    <select name="status" class="rounded-r-none form-control">
                        <option value="Placed">Placed</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Canceled">Canceled</option>
                        <option value="Delivered">Delivered</option>
                    </select>     

                    <button class="btn btn-primary rounded-l-none" type="submit">
                        <FaCheck size={18}/>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
    )
}