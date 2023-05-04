import axios from "../utils/axios"
import { useState } from "react"

export default function CreateSliderPage() {
    const [image, setImage] = useState()

    const handleImgClick = () => {
        // axios.post("/sliders", {
        //     image: "image"
        // })
        window.open("http://localhost:8000/laravel-filemanager?type=image", "FileManager", "width=900", "height=600")

        window.SetUrl = items => setImage(items[0].url)
    }

    return (
        <div class="card mx-auto max-w-lg">
            <div class="card-header font-bold text-indigo-600">Create New Slider</div>

            <form action="/admin/sliders" class="card-body" method="post">

                <div class="mb-5">
                    <label class="form-label">Image</label>

                    <div onClick={handleImgClick} class="h-24 w-24 border border-gray-300 cursor-pointer" data-fp="single" data-fp-input="input[name=image_url]" data-fp-preview="img">
                        <input type="hidden" name="image_url" />
                        <img src="/images/placeholder.png" class="h-full w-full object-cover block" />
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    )
}