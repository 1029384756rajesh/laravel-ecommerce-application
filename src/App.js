import { Route, Routes } from "react-router-dom"
import Layout from "./components/Layout"
import DashboardPage from "./pages/DashboardPage"
import SlidersPage from "./pages/SlidersPage"
import CategoriesPage from "./pages/CategoriesPage"
import CreateCategoryPage from "./pages/CreateCategoryPage"
import EditCategoryPage from "./pages/EditCategoryPage"
import ProductsPage from "./pages/ProductsPage"
import CreateProductPage from "./pages/CreateProductPage"
import EditProductPage from "./pages/EditProductPage"
import AttributesPage from "./pages/AttributesPage"
import VariationsPage from "./pages/VariationsPage"
import OrdersPage from "./pages/OrdersPage"
import OrderDetailsPage from "./pages/OrderDetailsPage"
import UsersPage from "./pages/UsersPage"
import SettingsPage from "./pages/SettingsPage"
import EditSettingsPage from "./pages/EditSettingsPage"
import CreateSliderPage from "./pages/CreateSliderPage"

export default function App() {
    return (
        <Routes>
            <Route element={<Layout/>}>
                <Route path="/" element={<DashboardPage/>}/>
                <Route path="/sliders" element={<SlidersPage/>}/>
                <Route path="/sliders/create" element={<CreateSliderPage/>}/>
                <Route path="/categories" element={<CategoriesPage/>}/>
                <Route path="/categories/create" element={<CreateCategoryPage/>}/>
                <Route path="/categories/:categoryId" element={<EditCategoryPage/>}/>
                <Route path="/products" element={<ProductsPage/>}/>
                <Route path="/products/create" element={<CreateProductPage/>}/>
                <Route path="/products/:productId" element={<EditProductPage/>}/>
                <Route path="/products/:productId/attributes" element={<AttributesPage/>}/>
                <Route path="/products/:productId/variations" element={<VariationsPage/>}/>
                <Route path="/orders" element={<OrdersPage/>}/>
                <Route path="/orders/:orderId" element={<OrderDetailsPage/>}/>
                <Route path="/users" element={<UsersPage/>}/>
                <Route path="/settings" element={<SettingsPage/>}/>
                <Route path="/settings/edit" element={<EditSettingsPage/>}/>
            </Route>
        </Routes>
    )
}