import { FaBars } from "react-icons/fa";
import { MdClose } from "react-icons/md";

export default function Navbar({ onMenuClick, showSidebar }) {
    return (
        <nav className="bg-indigo-600 h-16 z-50 px-6 flex items-center justify-between shadow-md fixed top-0 left-0 right-0" data-bs-theme="dark">
            <a className="text-white text-xl font-bold" href="/admin">Rmart Admin</a>
            {showSidebar ? <MdClose size={24} className="text-white block lg:hidden cursor-pointer" onClick={onMenuClick}/> :
            <FaBars size={24} className="text-white block lg:hidden cursor-pointer" onClick={onMenuClick}/>}
        </nav>
    )
}