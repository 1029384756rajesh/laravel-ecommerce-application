export default function VariationsPage() {
    return (
        <form action="/admin/products/{{ $product->id }}/variations" method="post" class="card mx-auto max-w-6xl">

            <div class="card-header card-header-title">Variations</div>

            <div class="card-body">
                <div class="table">
                    <table>
                        <thead>
                            <tr>
                                <th>Variation</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td width="20%">
                                    <div>Size - Small</div>
                                    <div>Color - Red</div>
                                </td>

                                <td width="15%">
                                    <input class="form-control" type="number" value="{{ $variation->price }}" name="" />
                                </td>

                                <td width="15%">
                                    <input class="form-control" type="number" value="{{ $variation->stock }}" name="" />
                                </td>

                                <td width="50%">
                                    <input type="hidden" name="variations" value="" />

                                    <div className="flex flex-wrap gap-2">
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">
                                    <div>Size - Small</div>
                                    <div>Color - Red</div>
                                </td>

                                <td width="15%">
                                    <input class="form-control" type="number" value="{{ $variation->price }}" name="" />
                                </td>

                                <td width="15%">
                                    <input class="form-control" type="number" value="{{ $variation->stock }}" name="" />
                                </td>

                                <td width="50%">
                                    <input type="hidden" name="variations" value="" />

                                    <div className="flex flex-wrap gap-2">
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">
                                    <div>Size - Small</div>
                                    <div>Color - Red</div>
                                </td>

                                <td width="15%">
                                    <input class="form-control" type="number" value="{{ $variation->price }}" name="" />
                                </td>

                                <td width="15%">
                                    <input class="form-control" type="number" value="{{ $variation->stock }}" name="" />
                                </td>

                                <td width="50%">
                                    <input type="hidden" name="variations" value="" />

                                    <div className="flex flex-wrap gap-2">
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    <div data-fp="single" data-fp-input="#imageUrl" data-fp-preview="#imagePreview" class="relative group h-20 w-20 rounded border border-gray-300 cursor-pointer">
                                        <input type="hidden" id="imageUrl" value="" name="" />

                                        <div data-fp-reset class="group-hover:flex hidden absolute right-1 top-1 text-lg bg-black bg-opacity-60 rounded-full w-6 h-6 items-center justify-center text-white">
                                            <i class="fa fa-close text-2xl cursor-pointer"></i>
                                        </div>

                                        <img src="https://cdn.pixabay.com/photo/2016/12/06/09/31/blank-1886008__340.png" class="h-full w-full object-cover" />
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer flex gap-2 justify-end">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    )
}