import { useEffect, useState } from "react"
import axios from "../utils/axios"

export default function DashboardPage() {
    const [analytics, setAnalytics] = useState()
    const [isLoding, setIsLoading] = useState(true)

    const fetchAnalytics = async () => {
        const { data } = await axios.get("/")
        setAnalytics(data)
        setIsLoading(false)
    }

    useEffect(()=>{
        fetchAnalytics()
    }, [])

    if(isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )

    return (
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div className="card text-center">
                <div className="card-header font-bold text-indigo-600">
                    Total Sliders
                </div>
                <div className="card-body text-3xl font-bold">
                    <h1>{analytics.totalSliders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Categories
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalCategories}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Products
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalProducts}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Orders
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalOrders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Placed Orders
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalPlacedOrders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Accepted Orders
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalAcceptedOrders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Rejected Orders
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalRejectedOrders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Shipped Orders
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalShippedOrders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header font-bold text-indigo-600">
                    Total Delivered Orders
                </div>
                <div className="card-body text-3xl font-bold">
                    <h1>{analytics.totalDeliveredOrders}</h1>
                </div>
            </div>

            <div className="card text-center font-bold">
                <div className="card-header text-indigo-600">
                    Total Customers
                </div>
                <div className="card-body text-3xl">
                    <h1>{analytics.totalUsers}</h1>
                </div>
            </div>
        </div>
    )
}