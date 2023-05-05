import { useEffect, useState } from "react"
import { FaCheckCircle, FaEdit, FaTimesCircle, FaTrash } from "react-icons/fa"
import { MdEdit } from "react-icons/md"
import axios from "../utils/axios"
import { Link } from "react-router-dom"
import { toast } from "react-toastify"

export default function ProductsPage() {
    const [products, setProducts] = useState([])
    const [isLoding, setIsLoading] = useState(true)

    const fetchProducts = async () => {
        const { data } = await axios.get("/products")


        setProducts(data)
        
        setIsLoading(false)
    }

    const handleDelete = async productId => {
        setIsLoading(true)

        await axios.delete(`/products/${productId}`)

        toast.success("Product deleted successfully")

        setProducts(products.filter(product => product.id !== productId))

        setIsLoading(false)
    }

    useEffect(() => {
        fetchProducts()
    }, [])
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
                                    <th width="10%">Category</th>
                                    <th width="10%">Variations</th>
                                    <th width="15%">Image</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               {products.map(product => (
                                 <tr key={product.id}>
                                 <td>{product.name}</td>

                                 <td>{product.price ? product.price : `${product.minPrice} - ${product.maxPrice}`}</td>
                                 <td>{product.category}</td>

                                 <td>
                                     {product.hasVariations ? <FaCheckCircle size={18} className="text-green-600" /> : <FaTimesCircle size={18} className="text-red-600"/>}
                                     {/* <FaTimesCircle size={18} className="text-red-600"/> */}
                                 </td>


                                 <td>
                                     <img src={product.image} class="w-16 h-16 object-cover rounded-md" />
                                 </td>

                                 <td>
                                     <div class="flex gap-1">
                                         <Link to="/products/5" class="bg-yellow-600 p-1.5 text-white rounded">
                                             <FaEdit size={18} />
                                         </Link>

                                         <button type="submit" onClick={()=>handleDelete(product.id)} class="bg-red-600 p-1.5 text-white rounded">
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