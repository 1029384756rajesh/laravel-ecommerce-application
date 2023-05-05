import { string, object, number, boolean, array } from "yup";

export const categorySchema = object({
    name: string().trim().required("Name is required").max(20, "Name must be within 20 characters")
})

export const sliderSchema = object({
    image: string().trim().required("Image is required")
})

export const productSchema = object({
    hasVariations: boolean(),
    name: string().trim().required("Name is required").max(40, "Name must be within 40 characters"),
    categoryId: number().required("Category is required"),
    shortDescription: string().trim().max(255, "Short description must be within 255 characters"),
    description: string().trim().max(5000, "Description must be within 5000 characters"),
    price: number().when("hasVariations", {
        is: (value) => value === false,
        then: schema => {
            console.log('call then');
            return number().required('required')
        }
    }),
    images: array().min(1, "At least 1 image required").max(20, "Only 20 images are allowed")
    // image: string().trim().required("Image is required")
})

export const settingSchema = object({
    about: string().trim().required("About is required").max(5000, "About must be within 5000 characters"),
    mobile: number().required("Mobile is required").min(1000000000, "Invalid mobile").max(9999999999, "Invalid mobile"),
    email: string().required("Email is required").email("Invalid email").max(40, "Email must be within 40 characters"),
    gst: number().required("Gst is required"),
    shippingCost: number().required("Shipping cost is required")
})