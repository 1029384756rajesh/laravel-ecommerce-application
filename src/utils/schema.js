import { string, object } from "yup";

export const categorySchema = object({
    name: string().trim().required("Name is required").max(20, "Name must be within 20 characters")
})