import { useEffect, useState } from "react"
import axios from "../utils/axios"
import { ErrorMessage, Field, Form, Formik } from "formik"
import { categorySchema } from "../utils/schema"
import { toast } from "react-toastify"

export default function CreateCategoryPage() {
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

    const handleSubmit = async (values, { setSubmitting, resetForm }) => { 
        setSubmitting(true)
        await axios.post("/categories", values)
        toast.success("Category created successfully")
        resetForm()
        setSubmitting(false)
    }

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )

    return (
        <Formik
            initialValues={{ name: "", parentId: "" }}
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