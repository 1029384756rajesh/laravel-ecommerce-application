import { CKEditor } from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { useFormik } from 'formik';
import { toast } from 'react-toastify';
import axios from 'axios';
import { productSchema } from '../utils/schema';
import { MdFeedback } from 'react-icons/md';
import { useEffect, useState } from 'react';

export default function CreateProductPage() {
    const [categories, setCategories] = useState([])
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


    const { setFieldValue, setFieldErrors, handleSubmit, values, errors, touched, setTouched } = useFormik({
        validationSchema: productSchema,
        initialValues: {
            name: "",
            shortDescription: "",
            description: "",
            price: "",
            stock: "",
            hasVariations: false,
            categoryId: 1,
            images: []
        },
        onSubmit: async (values, { resetForm, setSubmitting }) => {
         
            setSubmitting(true)

            await axios.post("/products", values)

            toast.success("Product created successfully")

            resetForm()

            setSubmitting(false)
        }
    })

    const handleVariations = event => {
        setFieldValue("hasVariations", event.target.checked)
        // if (event.target.checked) {
        //     setFieldValue("price", "")
        //     setFieldValue("stock", "")
        // } else {
        //     setFieldValue("price", "")
        //     setFieldValue("stock", "")     
        // }
    }

    const handleImages = () => {
        setTouched({...touched, images: true})
        window.open("/files/multiple", "FileManager", "width=900", "height=600")
        window.setUrl = images => setFieldValue("images", images)
    }

    return (
        <div class="card mx-auto max-w-3xl">
            <div class="card-header card-header-title">Create New Product</div>
            {JSON.stringify(touched)}
            {JSON.stringify(values)}
            {JSON.stringify(errors)}
            <form onSubmit={handleSubmit} class="card-body" method="post">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>

                    <input type="text" name="name" id="name" value={values.name} onBlur={() => setTouched({...touched, name: true })} onChange={event => setFieldValue("name", event.target.value)} class={`form-control ${errors.name && touched.name ? 'form-control-error' : ''}`} />

                    {touched.name && errors.name && <div className="invalid-feedback">{errors.name}</div>}
                </div>

                <div class="form-group">
                    <label for="categoryId" class="form-label">Category</label>

                    <select id='categoryId' value={values.categoryId} onBlur={() => setTouched({...touched, categoryId: true })} onChange={event => setFieldValue("categoryId", event.target.value)} class={`form-control ${errors.categoryId && touched.categoryId ? 'form-control-error' : ''}`} name="category_id">
                        <option></option>

                        {categories.map(category => <option value={category.id}>{category.name}</option>)}
                    </select>

                    {touched.categoryId && errors.categoryId && <div className="invalid-feedback">{errors.categoryId}</div>}
                </div>

                <div class="form-group">
                    <label for="shortDescription" class="form-label">Short Description</label>

                    <input type="text" name="short_description" id="shortDescription" value={values.shortDescription} onBlur={() => setTouched({...touched, shortDescription: true })} onChange={event => setFieldValue("shortDescription", event.target.value)} class={`form-control ${errors.shortDescription && touched.shortDescription ? 'form-control-error' : ''}`} />

                    {touched.shortDescription && errors.shortDescription && <div className="invalid-feedback">{errors.shortDescription}</div>}
                </div>

                <div class="form-group">
                    <label class="form-label" for="editor">Description</label>

                    <CKEditor
                        editor={ClassicEditor}
                        data={values.description}
                        onReady={editor => {
                            // You can store the "editor" and use when it is needed.
                            console.log('Editor is ready to use!', editor);
                        }}
                        onChange={(event, editor) => {
                            setFieldValue("description", editor.getData())

                        }}
                        onBlur={(event, editor) => {
                            setTouched({...touched, description: true })
                            console.log('Blur.', editor);
                        }}
                        onFocus={(event, editor) => {
                            console.log('Focus.', editor);
                        }}
                    />

                    {touched.description && errors.description && <div className="invalid-feedback">{errors.description}</div>}
                </div>

                {/* {!values.hasVariations && (
                    <>
                    <div class="form-group">
                    <label for="price" class="form-label">Price</label>

                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        value={values.price} 
                        onChange={event=>setFieldValue("price", event.target.value)} 
                        onBlur={()=>setTouched({price:true})} 
                        class={`form-control ${touched.price && errors.price ? 'form-control-error' : ''}`} 
                    />

                    {errors.price && touched.price && <div className="invalid-feedback">{errors.price}</div>}
                </div>

                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>

                    <input 
                        type="number" 
                        name="stock" 
                        id="stock" 
                        value={values.stock} 
                        onChange={event=>setFieldValue("stock", event.target.value)} 
                        onBlur={()=>setTouched({stock:true})} 
                        class={`form-control ${touched.stock && errors.stock ? 'form-control-error' : ''}`} 
                    />

{errors.stock && touched.stock && <div className="invalid-feedback">{errors.stock}</div>}
                </div>
                    </>
                )} */}

                <>
                    <div class="form-group">
                        <label for="price" class="form-label">Price</label>

                        <input
                            type="number"
                            name="price"
                            id="price"
                            value={values.price}
                            onChange={event => setFieldValue("price", event.target.value)}
                            onBlur={() => setTouched({ ...touched, price: true })}
                            class={`form-control ${touched.price && errors.price ? 'form-control-error' : ''}`}
                        />

                        {errors.price && touched.price && <div className="invalid-feedback">{errors.price}</div>}
                    </div>

                    <div class="form-group">
                        <label for="stock" class="form-label">Stock</label>

                        <input
                            type="number"
                            name="stock"
                            id="stock"
                            value={values.stock}
                            onChange={event => setFieldValue("stock", event.target.value)}
                            onBlur={() => setTouched({ stock: true })}
                            class={`form-control ${touched.stock && errors.stock ? 'form-control-error' : ''}`}
                        />

                        {errors.stock && touched.stock && <div className="invalid-feedback">{errors.stock}</div>}
                    </div>
                </>

                <div class="form-group form-check">
                    <input type="hidden" name="has_variations" value="0" />

                    <input type="checkbox"  name="has_variations" id="hasVariations" onChange={(event) => setFieldValue("hasVariations", event.target.checked)} checked={values.hasVariations} class="form-check-input" />

                    <label for="hasVariations" class="form-check-label">Has Variations</label>
                </div>

                <div class="form-group">
                    <label class="form-label">Gallery</label>

                    <div class="flex flex-wrap gap-2">
                        <ul id="gallery" class="flex flex-wrap gap-2">
                            {values.images.map(image => (
                                <li class="relative group h-20 w-20 rounded border border-gray-300 overflow-hidden">
                                    <div data-fp-remove class="group-hover:flex hidden absolute inset-0 bg-black bg-opacity-50 items-center justify-center text-white">
                                        <i class="fa fa-close text-2xl cursor-pointer"></i>
                                    </div>

                                    <input type="hidden" name="images[]" value="" />

                                    <img src={image} class="w-full h-full object-cover" />
                                </li>
                            ))}
                        </ul>

                        <img src="/images/placeholder.png" onClick={handleImages} data-fp="multiple" data-fp-container="#gallery" data-fp-name="images[]" class="rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer" />
                    </div>

                    {touched.images && errors.images && <div className='invalid-feedback'>{errors.images}</div>}
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    )
}
// export default function CreateProductPage() {

//     const [inputs, setInputs] = useState({
//         name: "",
//         shortDescription: "",
//         description: "",
//         price: "",
//         stock: "",
//         hasVariations: false,
//         categoryId: 1,
//         images: []
//     })

//     const [isLoading, setIsLoading] = useState(false)
    
//     const { setFieldValue, setFieldErrors, handleSubmit, values, errors, touched, setTouched } = useFormik({
//         validationSchema: productSchema,
//         initialValues: {
          
//         },
//         onSubmit: async (values, { resetForm, setSubmitting }) => {
//             console.log(values);
//             return
//             setSubmitting(true)

//             await axios.post("/products", values)

//             toast.success("Product created successfully")

//             resetForm()

//             setSubmitting(false)
//         }
//     })

//     const handleVariations = event => {
//         setFieldValue("hasVariations", event.target.checked)
//         // if (event.target.checked) {
//         //     setFieldValue("price", "")
//         //     setFieldValue("stock", "")
//         // } else {
//         //     setFieldValue("price", "")
//         //     setFieldValue("stock", "")     
//         // }
//     }

//     const handleImages = () => {
//         window.open("/files/multiple", "FileManager", "width=900", "height=600")
//         window.setUrl = images => setFieldValue("images", images)
//     }

//     return (
//         <div class="card mx-auto max-w-3xl">
//             <div class="card-header card-header-title">Create New Product</div>
//             {JSON.stringify(touched)}
//             {JSON.stringify(values)}
//             {JSON.stringify(errors)}
//             <form onSubmit={handleSubmit} class="card-body" method="post">
//                 <div class="form-group">
//                     <label for="name" class="form-label">Name</label>

//                     <input type="text" name="name" id="name" value={values.name} onBlur={() => setTouched({...touched, name: true })} onChange={event => setFieldValue("name", event.target.value)} class={`form-control ${errors.name && touched.name ? 'form-control-error' : ''}`} />

//                     {touched.name && errors.name && <div className="invalid-feedback">{errors.name}</div>}
//                 </div>

//                 <div class="form-group">
//                     <label for="categoryId" class="form-label">Category</label>

//                     <select id='categoryId' value={values.name} onBlur={() => setTouched({...touched, categoryId: true })} onChange={event => setFieldValue("categoryId", event.target.value)} class={`form-control ${errors.categoryId && touched.categoryId ? 'form-control-error' : ''}`} name="category_id">
//                         <option></option>
//                     </select>

//                     {touched.categoryId && errors.categoryId && <div className="invalid-feedback">{errors.categoryId}</div>}
//                 </div>

//                 <div class="form-group">
//                     <label for="shortDescription" class="form-label">Short Description</label>

//                     <input type="text" name="short_description" id="shortDescription" value={values.shortDescription} onBlur={() => setTouched({...touched, shortDescription: true })} onChange={event => setFieldValue("shortDescription", event.target.value)} class={`form-control ${errors.shortDescription && touched.shortDescription ? 'form-control-error' : ''}`} />

//                     {touched.shortDescription && errors.shortDescription && <div className="invalid-feedback">{errors.shortDescription}</div>}
//                 </div>

//                 <div class="form-group">
//                     <label class="form-label" for="editor">Description</label>

//                     <CKEditor
//                         editor={ClassicEditor}
//                         data={values.description}
//                         onReady={editor => {
//                             // You can store the "editor" and use when it is needed.
//                             console.log('Editor is ready to use!', editor);
//                         }}
//                         onChange={(event, editor) => {
//                             setFieldValue("description", editor.getData())

//                         }}
//                         onBlur={(event, editor) => {
//                             setTouched({...touched, description: true })
//                             console.log('Blur.', editor);
//                         }}
//                         onFocus={(event, editor) => {
//                             console.log('Focus.', editor);
//                         }}
//                     />

//                     {touched.description && errors.description && <div className="invalid-feedback">{errors.description}</div>}
//                 </div>

//                 {/* {!values.hasVariations && (
//                     <>
//                     <div class="form-group">
//                     <label for="price" class="form-label">Price</label>

//                     <input 
//                         type="number" 
//                         name="price" 
//                         id="price" 
//                         value={values.price} 
//                         onChange={event=>setFieldValue("price", event.target.value)} 
//                         onBlur={()=>setTouched({price:true})} 
//                         class={`form-control ${touched.price && errors.price ? 'form-control-error' : ''}`} 
//                     />

//                     {errors.price && touched.price && <div className="invalid-feedback">{errors.price}</div>}
//                 </div>

//                 <div class="form-group">
//                     <label for="stock" class="form-label">Stock</label>

//                     <input 
//                         type="number" 
//                         name="stock" 
//                         id="stock" 
//                         value={values.stock} 
//                         onChange={event=>setFieldValue("stock", event.target.value)} 
//                         onBlur={()=>setTouched({stock:true})} 
//                         class={`form-control ${touched.stock && errors.stock ? 'form-control-error' : ''}`} 
//                     />

// {errors.stock && touched.stock && <div className="invalid-feedback">{errors.stock}</div>}
//                 </div>
//                     </>
//                 )} */}

//                 <>
//                     <div class="form-group">
//                         <label for="price" class="form-label">Price</label>

//                         <input
//                             type="number"
//                             name="price"
//                             id="price"
//                             value={values.price}
//                             onChange={event => setFieldValue("price", event.target.value)}
//                             onBlur={() => setTouched({ ...touched, price: true })}
//                             class={`form-control ${touched.price && errors.price ? 'form-control-error' : ''}`}
//                         />

//                         {errors.price && touched.price && <div className="invalid-feedback">{errors.price}</div>}
//                     </div>

//                     <div class="form-group">
//                         <label for="stock" class="form-label">Stock</label>

//                         <input
//                             type="number"
//                             name="stock"
//                             id="stock"
//                             value={values.stock}
//                             onChange={event => setFieldValue("stock", event.target.value)}
//                             onBlur={() => setTouched({ stock: true })}
//                             class={`form-control ${touched.stock && errors.stock ? 'form-control-error' : ''}`}
//                         />

//                         {errors.stock && touched.stock && <div className="invalid-feedback">{errors.stock}</div>}
//                     </div>
//                 </>

//                 <div class="form-group form-check">
//                     <input type="hidden" name="has_variations" value="0" />

//                     <input type="checkbox" checked={values.hasVariations} name="has_variations" id="hasVariations" onChange={handleVariations} class="form-check-input" value="1" />

//                     <label for="hasVariations" class="form-check-label">Has Variations</label>
//                 </div>

//                 <div class="form-group">
//                     <label class="form-label">Gallery</label>

//                     <div class="flex flex-wrap gap-2">
//                         <ul id="gallery" class="flex flex-wrap gap-2">
//                             {values.images.map(image => (
//                                 <li class="relative group h-20 w-20 rounded border border-gray-300 overflow-hidden">
//                                     <div data-fp-remove class="group-hover:flex hidden absolute inset-0 bg-black bg-opacity-50 items-center justify-center text-white">
//                                         <i class="fa fa-close text-2xl cursor-pointer"></i>
//                                     </div>

//                                     <input type="hidden" name="images[]" value="" />

//                                     <img src={image} class="w-full h-full object-cover" />
//                                 </li>
//                             ))}
//                         </ul>

//                         <img src="/images/placeholder.png" onClick={handleImages} data-fp="multiple" data-fp-container="#gallery" data-fp-name="images[]" class="rounded border border-gray-300 object-cover h-20 w-20 cursor-pointer" />
//                     </div>
//                 </div>

//                 <button type="submit" class="btn btn-primary">Save</button>
//             </form>
//         </div>
//     )
// }