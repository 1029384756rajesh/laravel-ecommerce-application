import { Link } from "react-router-dom";
import { ErrorMessage, Field, Form, Formik } from "formik"
import { useEffect, useState } from "react"
import axios from "../utils/axios"
import { settingSchema } from "../utils/schema"
import { toast } from "react-toastify"
import { useNavigate } from "react-router-dom"

export default function OrdersPage() {
    const [orders, setOrders] = useState({})
    const [isLoding, setIsLoading] = useState(true)

    const fetchUsers = async () => {
        const { data } = await axios.get("/orders")
        
        setOrders(data)

        setIsLoading(false)
    }
    useEffect(() => {
        fetchUsers()
    }, [])

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )


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
                            <th>Total Products</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                          {orders.map(order => (
                            <tr key={order.id}>
                            <td>{order.id}</td>
                            <td>{order.email}</td>
                            <td>
                                  <div className="badge badge-success">{order.status}</div>
                            </td>
                            <td>₹ {order.totalAmount}</td>
                            <td>₹ {order.totalProducts}</td>
                            <td>{order.created}</td>
                            <td>
                                <Link to={`/orders/${order.id}`} class="btn btn-sm btn-primary">View</Link>
                            </td>
                        </tr>
                          ))}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    )
}