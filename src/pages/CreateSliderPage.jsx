import { useParams } from "react-router-dom"
import axios from "../utils/axios"
import { useState } from "react"
import { toast } from "react-toastify"
import { ErrorMessage, useFormik } from "formik"
import { sliderSchema } from "../utils/schema"

export default function CreateSliderPage() {
    const [image, setImage] = useState()

    const handleImgClick = () => {
        formik.touched.image = true
        window.open("/files/single", "FileManager", "width=900", "height=600")
        window.setUrl = image => formik.setFieldValue("image", image)
    }

    const handleSubmit = async (values, { resetForm, setSubmitting }) => {
        setSubmitting(true)
        await axios.post("/sliders", values)
        toast.success("Slider created successfully")
        setSubmitting(false)
        resetForm()
    }

    const formik = useFormik({
        initialValues: { image: "" },
        validationSchema: sliderSchema,
        onSubmit: handleSubmit
    })

    return (
        <div class="card mx-auto max-w-lg">
            <div class="card-header font-bold text-indigo-600">Create New Slider</div>

            <form onSubmit={formik.handleSubmit} class="card-body">
                <div class="mb-5">
                    <label class="form-label">Image</label>

                    <div onClick={handleImgClick} class="h-24 w-24 border border-gray-300 cursor-pointer">
                        <input type="hidden" name="image_url" />
                        <img src={formik.values.image ? formik.values.image : "/images/placeholder.png"} class="h-full w-full object-cover block" />
                    </div>

                    {formik.touched.image && formik.errors.image && <div className="invalid-feedback">{formik.errors.image}</div>}
                </div>

                <button type="submit" disabled={formik.isSubmitting} class="btn btn-primary">Save</button>
            </form>
        </div>
    )
}