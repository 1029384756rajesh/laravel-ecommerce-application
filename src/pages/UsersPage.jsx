import { ErrorMessage, Field, Form, Formik } from "formik"
import { useEffect, useState } from "react"
import axios from "../utils/axios"
import { settingSchema } from "../utils/schema"
import { toast } from "react-toastify"
import { useNavigate } from "react-router-dom"

export default function UsersPage() {
    const [users, setUsers] = useState({})
    const [isLoding, setIsLoading] = useState(true)

    const fetchUsers = async () => {
        const { data } = await axios.get("/users")
        setUsers(data)
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
            <div class="card-header card-header-title">Customers</div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="table min-w-[1024px]">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Since</th>
                                </tr>
                            </thead>
                            <tbody>
                                {users.map(user => (
                                    <tr key={user.id}>
                                    <td>{user.name}</td>

                                    <td>{user.email}</td>

                                    <td>{user.createdAt}</td>
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