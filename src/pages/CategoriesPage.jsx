import { useEffect, useState } from "react";
import { FaEdit, FaTrash } from "react-icons/fa";
import axios from "../utils/axios"
import { Link } from "react-router-dom";

export default function CategoriesPage() {
    const [categories, setCategories] = useState()
    const [isLoding, setIsLoading] = useState(true)

    const fetchCategories = async () => {
        const { data } = await axios.get("/categories")

        setCategories(data.map(category => ({
            ...category,
            name: [...Array(category.label - 1).keys()].map(_ => "—").join(" ") + category.name
        })))
        
        setIsLoading(false)
    }

    useEffect(() => {
        fetchCategories()
    }, [])

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )


    const handleDelete = categoryId => {

    }

    return (
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <span class="card-header-title">Categories</span>
                <Link to="/categories/create" class="btn btn-sm btn-primary">Add New</Link>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="table min-w-[1024px]">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Last Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {categories.map(category => (
                                    <tr>
                                        <td>{category.name}</td>

                                        <td>
                                            <div class="flex gap-1">
                                                <Link to={`/categories/${category.id}`} class="bg-yellow-600 p-1.5 text-white rounded">
                                                    <FaEdit size={18} />
                                                </Link>

                                                <button onClick={()=>handleDelete(category.id)} class="bg-red-600 p-1.5 text-white rounded">
                                                    <FaTrash size={18} />
                                                </button>
                                            </div>
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