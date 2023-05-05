import { useEffect, useState } from "react"
import axios from "../utils/axios"
import { ErrorMessage, Field, Form, Formik } from "formik"
import { categorySchema } from "../utils/schema"
import { toast } from "react-toastify"
import { useNavigate, useParams } from "react-router-dom"

export default function EditCategoryPage() {
    const [category, setCategory] = useState({})
    const [categories, setCategories] = useState([])
    const [isLoding, setIsLoading] = useState(true)
    const { categoryId } = useParams()
    const navigate = useNavigate()

    const fetchData = async () => {
        const [categoryRes, categoriesRes] = await Promise.all([
            await axios.get(`/categories/${categoryId}`),

            await axios.get("/categories")
        ])

        setCategories(categoriesRes.data.map(category => ({
            ...category,
            name: [...Array(category.label - 1).keys()].map(_ => "—").join(" ") + category.name
        })))

        setCategory(categoryRes.data)

        setIsLoading(false)
    }

    useEffect(() => {
        fetchData()
    }, [])

    const handleSubmit = async (values, { setSubmitting, resetForm }) => { 
        setSubmitting(true)

        try {
            await axios.patch(`/categories/${values.id}`, values)

            toast.success("Category edited successfully")

            navigate("/categories")

        } catch ({ response }) {
            
            response?.status === 422 && toast.error("Category already exists") 
        } 

        setSubmitting(false)
    }

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )

    return (
        <Formik
            initialValues={category}
            validationSchema={categorySchema}
            onSubmit={handleSubmit}
        >
            {({ values, errors, touched, isSubmitting }) => (
                <Form class="card mx-auto max-w-lg">
                    <div class="card-header card-header-title">Create New Category</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <Field type="text" name="name" id="name" class={`form-control ${errors.name && touched.name ? 'form-control-error' : ''}`}/>
                            <ErrorMessage name="name" className="invalid-feedback" component="div"/>
                        </div>

                        <div class="form-group">
                            <label for="parentId" class="form-label">Parent Category</label>

                            <Field name="parentId" className="form-control" as="select">
                                <option></option>
                                {categories.map(category => <option value={category.id}>{category.name}</option>)}
                            </Field>
                        </div>

                        <button type="submit" disabled={isSubmitting} class="btn btn-primary">Save</button>
                    </div>
                </Form>
            )}
        </Formik>
    )
}