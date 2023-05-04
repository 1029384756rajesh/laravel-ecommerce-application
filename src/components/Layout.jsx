import { Outlet } from "react-router-dom"
import Navbar from "./Navbar"
import Sidebar from "./Sidebar"
import { useState } from "react"

export default function Layout() {
    const [showSidebar, setShowSidebar] = useState(false)

    return (
        <div>
            <Navbar onMenuClick={() => setShowSidebar(!showSidebar)} showSidebar={showSidebar}/>
            <Sidebar show={showSidebar} onNavClick={() => setShowSidebar(false)}/>
            <div className="pt-20 px-4 pb-4 ml-0 lg:ml-56">
                <Outlet />
            </div>
        </div>
    )
}