import { ErrorMessage, Field, Form, Formik } from "formik"
import { useEffect, useState } from "react"
import axios from "../utils/axios"
import { settingSchema } from "../utils/schema"
import { toast } from "react-toastify"
import { useNavigate } from "react-router-dom"

export default function EditSettingsPage() {
    const [settings, setSettings] = useState({})
    const [isLoding, setIsLoading] = useState(true)
    const navigate = useNavigate()

    const fetchSettings = async () => {
        const { data } = await axios.get("/settings")
        setSettings(data)
        setIsLoading(false)
    }

    const handleSubmit = async (values, { setSubmitting }) => {
        setSubmitting(true)

        await axios.patch("/settings", values)

        toast.success("Setting updated successfully")

        navigate("/settings")

        setSubmitting(false)
    }

    useEffect(() => {
        fetchSettings()
    }, [])

    if (isLoding) return (
        <div className="h-8 w-8 border-4 border-indigo-600 border-b-transparent rounded-full animate-spin"></div>
    )

    return (
        <Formik
            initialValues={settings}
            validationSchema={settingSchema}
            onSubmit={handleSubmit}
        >
            {({ errors, isSubmitting, touched }) => (
                <Form class="card mx-auto max-w-3xl">
                    <div class="card-header card-header-title">Edit Setting</div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="about" class="form-label">About</label>

                            <Field
                                type="text"
                                name="about"
                                id="about"
                                class={`form-control ${errors.about && touched.about ? 'form-control-error' : ''}`}
                            />

                            <ErrorMessage name="about" component="div" className="invalid-feedback" />
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="form-label">Mobile</label>

                            <Field
                                type="text"
                                name="mobile"
                                id="mobile"
                                class={`form-control ${errors.about && touched.about ? 'form-control-error' : ''}`}
                            />

                            <ErrorMessage name="mobile" component="div" className="invalid-feedback" />
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>

                            <Field
                                type="email"
                                name="email"
                                id="email"
                                class={`form-control ${errors.about && touched.about ? 'form-control-error' : ''}`}
                            />

                            <ErrorMessage name="email" component="div" className="invalid-feedback" />
                        </div>

                        <div class="form-group">
                            <label for="gst" class="form-label">Gst</label>

                            <Field
                                type="number"
                                name="gst"
                                id="gst"
                                class={`form-control ${errors.about && touched.about ? 'form-control-error' : ''}`}
                            />

                            <ErrorMessage name="gst" component="div" className="invalid-feedback" />
                        </div>

                        <div class="form-group">
                            <label for="shippingCost" class="form-label">Shipping Cost</label>

                            <Field
                                type="number"
                                name="shippingCost"
                                id="shippingCost"
                                class={`form-control ${errors.about && touched.about ? 'form-control-error' : ''}`}
                            />

                            <ErrorMessage name="shippingCost" component="div" className="invalid-feedback" />
                        </div>

                        <button type="submit" disabled={isSubmitting} class="btn btn-primary">Update</button>
                    </div>
                </Form>
            )}
        </Formik>
    )
}