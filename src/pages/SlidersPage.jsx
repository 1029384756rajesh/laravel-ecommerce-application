import { useEffect, useState } from "react"
import { Link } from "react-router-dom"
import axios from "../utils/axios"

export default function SlidersPage() {
    const [sliders, setSliders] = useState()
    const [isLoding, setIsLoading] = useState(true)

    const fetchSliders = async () => {
        const { data } = await axios.get("/sliders")
        setSliders(data)
        setIsLoading(false)
    }

    useEffect(() => {
        fetchSliders()
    }, [])

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )

    return (
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <span class="card-header-title">Sliders</span>
                <Link to="/sliders/create" class="btn btn-sm btn-primary">Add New</Link>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="table min-w-[1024px]">
                        <table>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Last Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {sliders.map(slider => (
                                    <tr key={slider.id}>
                                        <td>
                                            <img src={slider.image} class="w-20 object-cover" />
                                        </td>
                                        <td>
                                            <button className="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    )
}