import { FaHome, FaEdit, FaList, FaTshirt, FaShoppingBag, FaUser, FaLink } from "react-icons/fa"
import { MdSettings, MdHome, MdEdit, MdShoppingBasket, MdPeople, MdLink, MdList, MdPhotoAlbum } from "react-icons/md"
import { NavLink } from "react-router-dom"

export default function Sidebar({ show, onNavClick }) {
    return (
        <ul className={`bg-indigo-600 w-56 h-[calc(100vh-64px)] fixed ${show ? "left-0" : "-left-56"} transition-all duration-300 lg:left-0 top-16`}>
            <li>
                <NavLink onClick={onNavClick} to="/" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <FaHome size={20} className="w-6" />
                    <span>Dashboard</span>
                </NavLink>
            </li>

            <li>
                <NavLink onClick={onNavClick} to="/sliders" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <MdPhotoAlbum size={20} className="w-6" />
                    <span>Slider</span>
                </NavLink>
            </li>

            <li>
                <NavLink onClick={onNavClick} to="/categories" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <FaList size={20} className="w-6" />
                    <span>Category</span>
                </NavLink>
            </li>

            <li>
                <NavLink onClick={onNavClick} to="/products" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <FaTshirt size={20} className="w-6" />
                    <span>Products</span>
                </NavLink>
            </li>

            <li>
                <NavLink onClick={onNavClick} to="/orders" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <FaShoppingBag size={20} className="w-6" />
                    <span>Order</span>
                </NavLink>
            </li>

            <li>
                <NavLink onClick={onNavClick} to="/users" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <FaUser size={20} className="w-6" />
                    <span>User</span>
                </NavLink>
            </li>

            <li>
                <NavLink onClick={onNavClick} to="/settings" className={({ isActive }) => `text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent ${isActive ? 'bg-indigo-700 border-l-indigo-900' : ''}`}>
                    <MdSettings size={20} className="w-6" />
                    <span>Settings</span>
                </NavLink>
            </li>

            <li>
                <a href="/" className="text-white px-5 py-3 flex items-center gap-4 border-l-4 border-l-transparent">
                    <FaLink size={20} className="w-6" />
                    <span>View Site</span>
                </a>
            </li>
        </ul>
    )
}
