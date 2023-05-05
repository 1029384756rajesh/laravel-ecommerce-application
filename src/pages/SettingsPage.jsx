import { useEffect, useReducer, useState } from "react";
import { Link } from "react-router-dom";
import axios from "../utils/axios"

export default function SettingsPage() {
    const [settings, setSettings] = useState({})
    const [isLoding, setIsLoading] = useState(true)

    const fetchSettings = async () => {
        const { data } = await axios.get("/settings")

        setSettings(data)

        console.log(data);

        setIsLoading(false)
    }

    useEffect(() => {
        fetchSettings()
    }, [])

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )

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
                                    <td>About</td>
                                    <td>{settings.about}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{settings.email}</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td>{settings.mobile}</td>
                                </tr>
                                <tr>
                                    <td>GST</td>
                                    <td>{settings.gst}%</td>
                                </tr>
                                <tr>
                                    <td width="20%">Shipping Cost</td>
                                    <td>{settings.shippingCost}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}