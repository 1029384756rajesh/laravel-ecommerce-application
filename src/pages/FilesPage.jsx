import { useEffect, useState } from "react"
import axios from "../utils/axios"
import { useParams } from "react-router-dom"

export default function FilesPage() {
    const [images, setImages] = useState([])
    const [isLoading, setIsLoading] = useState(true)
    const { type } = useParams()

    const handleSubmit = () => {
        window.opener.setUrl(type === "single" ? images.find(image => image.selected).url : images.filter(image => image.selected).map(image => image.url))
        window.self.close()
    }

    const fetchImages = async () => {
        const { data } = await axios.get("/files")
        setImages(data)
        setIsLoading(false)
    }

    const handleSelect = selectedIndex => {
        setImages(images.map((image, index) => ({
            ...image,
            selected: type === "single" ? index === selectedIndex : (index === selectedIndex ? true : image.selected) 
        })))
    }

    useEffect(() => {
        fetchImages()
    }, [])

    return (
        <div className="p-6">
            <div className="card">
                <div className="card-header card-header-title">Search</div>
                <input type="search" name="search" className="form-control w-full m-6" />
            </div>

            <div className="card mt-4">
                <div className="card-header card-header-title">Upload</div>
                <input type="file" name="files" className="m-6 form-control" />
            </div>

            <div className="card mt-4">
                <div className="card-header card-header-title">Images</div>
                <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-6">
                    {images.map((image, index) => (
                        <button onClick={() => (handleSelect(index))} className={`${image.selected ? 'border-indigo-600 ring-indigo-600 ring-1' : ''} border border-gray-300 rounded-md overflow-hidden`}>
                            <img src={image.url} className="w-full object-cover" />
                            <p className="text-center p-2">{image.name}</p>
                        </button>
                    ))}
                </div>
                <div className="card-footer flex justify-end">
                    <button onClick={handleSubmit} className="btn btn-primary">Select</button>
                </div>
            </div>
        </div>
    )
}