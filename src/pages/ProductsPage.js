import { FaCheckCircle, FaEdit, FaTimesCircle, FaTrash } from "react-icons/fa"
import { MdEdit } from "react-icons/md"
import { Link } from "react-router-dom"

export default function ProductsPage() {
    return (
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <span class="card-header-title">Products</span>
                <Link to="/products/create" class="btn btn-sm btn-primary">Add New</Link>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <div class="table min-w-[1024px]">
                        <table>
                            <thead>
                                <tr>
                                    <th width="25%">Name</th>
                                    <th width="15%">Price</th>
                                    <th width="10%">Featured</th>
                                    <th width="10%">Variations</th>
                                    <th width="15%">Image</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Men's regular fit tshirt</td>

                                    <td>456</td>

                                    <td>
                                        <FaCheckCircle size={18} className="text-green-600" />
                                        {/* <FaTimesCircle size={18} className="text-red-600"/> */}
                                    </td>

                                    <td>
                                        <   FaCheckCircle size={18} className="text-green-600" />
                                        {/* <FaTimesCircle size={18} className="text-red-600"/> */}
                                    </td>

                                    <td>
                                        <img src="https://cdn.pixabay.com/photo/2023/04/26/16/57/flower-7952897_640.jpg" class="w-16 h-16 object-cover rounded-md" />
                                    </td>

                                    <td>
                                        <div class="flex gap-1">
                                            <Link to="/products/5" class="bg-yellow-600 p-1.5 text-white rounded">
                                                <FaEdit size={18} />
                                            </Link>

                                            <button type="submit" class="bg-red-600 p-1.5 text-white rounded">
                                                <FaTrash size={18} />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    )
}