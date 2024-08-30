<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function upload(Request $request)
    {
        $urls = [];

        foreach ($request->file('files') as $file) {
            $urls[] = "http://localhost:8000/uploads/" . $file->store('images', 'public');
        }

        return $urls;
    }

    public function products(Request $request)
    {
        $request->validate([
            'perPage' => 'nullable|integer',
            'page' => 'nullable|integer',
            'search' => 'nullable|string'
        ]);

        $perPage = $request->get('per_page', 10);

        Log::info($request->all());

        $currentPage = $request->get('current_page', 1);

        $offset = $currentPage * $perPage - $perPage;

        $sortDir = $request->get('sort_dir', 'asc');

        $sortCol = $request->get('sort_col', 'id');

        $sql = "
            SELECT 
                products.id,
                products.name,
                product_variations.price,
                product_variation_images.src
            FROM products 
            INNER JOIN product_variations ON product_variations.product_id = products.id
            INNER JOIN 
            (
                SELECT 
                    ROW_NUMBER() 
                    OVER (PARTITION BY product_variation_id ORDER BY position ASC) AS seriel, 		 
                    src,
                    product_variation_id
                FROM product_variation_images
            ) AS product_variation_images
            ON product_variations.id = product_variation_images.product_variation_id
        ";

        if ($request->has('search')) {
            $sql .= " WHERE products.name LIKE '%$request->search%' OR products.short_description LIKE '%$request->search%' OR products.description LIKE '%$request->search%'";
        }

        $sql .= "
            GROUP BY products.id 
            ORDER BY $sortCol $sortDir
        ";

        $totalPage = count(DB::select(DB::raw($sql)));

        $sql .= "
            LIMIT $perPage 
            OFFSET $offset
        ";

        return ['products' => DB::select(DB::raw($sql)), 'totalPage' => ceil($totalPage / $perPage)];
    }

    public function show(Request $request, Product $product)
    {
        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'short_description' => $product->short_description,
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
            'description' => $product->description,
            'has_variations' => $product->has_variations === 1,
            'is_downloadable' => $product->is_downloadable === 1,
            'gst' => $product->gst,
            'attributes' => $product->attributes()->get()->map(fn($attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'type' => $attribute->type,
                'position' => $attribute->position,
                'options' => $attribute->options()->get()->map(fn($option) => [
                    'id' => $option->id,
                    'name' => $option->name,
                    'value' => $option->value,
                    'position' => $option->position,
                ]),
            ]),
            'variations' => $product->variations()->with('options', 'options.attribute')->get()->map(fn($variation) => [
                'id' => $variation->id,
                'price' => $variation->price,
                'stock' => $variation->stock,
                'length' => $variation->length,
                'breadth' => $variation->breadth,
                'height' => $variation->height,
                'weight' => $variation->weight,
                'link' => $variation->link,
                'expiry' => $variation->expiry,
                'limit' => $variation->limit,
                'images' => $variation->images->map(fn($image) => [
                    'id' => $image->id,
                    'src' => $image->src,
                    'position' => $image->position,
                ]),
                'attributes' => $variation->options->map(fn($option) => [
                    'name' => $option->attribute->name,
                    'option' => $option->name
                ])
            ])
        ];

        $data['details'] = $data['variations'][0];
        return view('bs.product-frontend', ['product' => $data]);
        return ProductVariation::where('id', $variationId)->with([
            'images' => fn(Builder $builder) => $builder->orderBy('position'),
            'options' => fn(Builder $builder) => $builder->orderBy('position'),
            'options.attribute',
            'product',
            'product.attributes' => fn(Builder $builder) => $builder->orderBy('position'),
            'product.attributes.options' => fn(Builder $builder) => $builder->orderBy('position'),
            'product.variations',
        ])->get()->map(fn($variation) => [
                'id' => $variation->product->id,
                'name' => $variation->product->name,
                'short_description' => $variation->product->short_description,
                'description' => $variation->product->description,
                'has_variations' => $variation->product->has_variations,
                'category_id' => $variation->product->category_id,
                'created_at' => $variation->product->created_at,
                'updated_at' => $variation->product->updated_at,
                'selected' => [
                    'id' => $variation->id,
                    'length' => $variation->length,
                    'breadth' => $variation->breadth,
                    'height' => $variation->height,
                    'weight' => $variation->weight,
                    'stock' => $variation->stock,
                    'price' => $variation->price,
                    'shipping_class_id' => $variation->shipping_class_id,
                    'tax_class_id' => $variation->tax_class_id,
                    'images' => $variation->images->map(fn($image) => [
                        'id' => $image->id,
                        'src' => $image->src,
                        'position' => $image->position,
                    ]),
                    'attributes' => $variation->options->map(fn($option) => [
                        'name' => $option->attribute->name,
                        'option' => $option->name
                    ]),
                ],
                'variations' => $variation->product->variations->map(fn($variation) => [
                    'id' => $variation->id,
                    'length' => $variation->length,
                    'breadth' => $variation->breadth,
                    'height' => $variation->height,
                    'weight' => $variation->weight,
                    'stock' => $variation->stock,
                    'price' => $variation->price,
                    'shipping_class_id' => $variation->shipping_class_id,
                    'tax_class_id' => $variation->tax_class_id,
                    'images' => $variation->images->map(fn($image) => [
                        'id' => $image->id,
                        'src' => $image->src,
                        'position' => $image->position,
                    ]),
                    'attributes' => $variation->options->map(fn($option) => [
                        'name' => $option->attribute->name,
                        'option' => $option->name
                    ]),
                ]),
                'attributes' => $variation->product->attributes->map(fn($attribute) => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'position' => $attribute->position,
                    'options' => $attribute->options->map(fn($option) => [
                        'id' => $option->id,
                        'name' => $option->name,
                        'position' => $option->position,
                    ]),
                ]),
            ]);
        return Product::where('id', $variationId)->with([
            'attributes' => fn(Builder $builder) => $builder->orderBy('position'),
            'attributes.options' => fn(Builder $builder) => $builder->orderBy('position'),
            'variations',
            'variations.images' => fn(Builder $builder) => $builder->orderBy('position'),
            'variations.options' => fn(Builder $builder) => $builder->orderBy('position'),
            'variations.options.attribute'
        ])->get()->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'short_description' => $product->short_description,
                'description' => $product->description,
                'has_variations' => $product->has_variations,
                'category_id' => $product->category_id,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'variations' => $product->variations->map(fn($variation) => [
                    'id' => $variation->id,
                    'length' => $variation->length,
                    'breadth' => $variation->breadth,
                    'height' => $variation->height,
                    'weight' => $variation->weight,
                    'stock' => $variation->stock,
                    'price' => $variation->price,
                    'shipping_class_id' => $variation->shipping_class_id,
                    'tax_class_id' => $variation->tax_class_id,
                    'images' => $variation->images->map(fn($image) => [
                        'id' => $image->id,
                        'src' => $image->src,
                        'position' => $image->position,
                    ]),
                    'attributes' => $variation->options->map(fn($option) => [
                        'name' => $option->attribute->name,
                        'option' => $option->name
                    ]),
                ]),
                'attributes' => $product->attributes->map(fn($attribute) => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'position' => $attribute->position,
                    'options' => $attribute->options->map(fn($option) => [
                        'id' => $option->id,
                        'name' => $option->name,
                        'position' => $option->position,
                    ]),
                ]),
            ]);
    }

    public function product(Request $request, Product $product)
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'short_description' => $product->short_description,
            'description' => $product->description,
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
            'has_variations' => $product->has_variations === 1,
            'is_downloadable' => $product->is_downloadable === 1,
            'is_active' => $product->is_active === 1,
            'gst_rate' => $product->gst_rate,
            'attributes' => $product->attributes()->get()->map(fn($attribute) => [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'type' => $attribute->type,
                'position' => $attribute->position,
                'options' => $attribute->options()->get()->map(fn($option) => [
                    'id' => $option->id,
                    'name' => $option->name,
                    'value' => $option->value,
                    'position' => $option->position,
                ]),
            ]),
            'variations' => $product->variations()->with('options', 'options.attribute')->get()->map(fn($variation) => [
                'id' => $variation->id,
                'price' => $variation->price,
                'stock' => $variation->stock,
                'length' => $variation->length,
                'breadth' => $variation->breadth,
                'height' => $variation->height,
                'weight' => $variation->weight,
                'link' => $variation->link,
                'expiry' => $variation->expiry,
                'limit' => $variation->limit,
                'images' => $variation->images->map(fn($image) => [
                    'id' => $image->id,
                    'src' => $image->src,
                    'position' => $image->position,
                ]),
                'attributes' => $variation->options->map(fn($option) => [
                    'name' => $option->attribute->name,
                    'option' => $option->name
                ])
            ])
        ];

        $data['details'] = $data['variations'][0];
        return view('bs.product-frontend', ['product' => $data]);
        return ProductVariation::where('id', $variationId)->with([
            'images' => fn(Builder $builder) => $builder->orderBy('position'),
            'options' => fn(Builder $builder) => $builder->orderBy('position'),
            'options.attribute',
            'product',
            'product.attributes' => fn(Builder $builder) => $builder->orderBy('position'),
            'product.attributes.options' => fn(Builder $builder) => $builder->orderBy('position'),
            'product.variations',
        ])->get()->map(fn($variation) => [
                'id' => $variation->product->id,
                'name' => $variation->product->name,
                'short_description' => $variation->product->short_description,
                'description' => $variation->product->description,
                'has_variations' => $variation->product->has_variations,
                'category_id' => $variation->product->category_id,
                'created_at' => $variation->product->created_at,
                'updated_at' => $variation->product->updated_at,
                'selected' => [
                    'id' => $variation->id,
                    'length' => $variation->length,
                    'breadth' => $variation->breadth,
                    'height' => $variation->height,
                    'weight' => $variation->weight,
                    'stock' => $variation->stock,
                    'price' => $variation->price,
                    'shipping_class_id' => $variation->shipping_class_id,
                    'tax_class_id' => $variation->tax_class_id,
                    'images' => $variation->images->map(fn($image) => [
                        'id' => $image->id,
                        'src' => $image->src,
                        'position' => $image->position,
                    ]),
                    'attributes' => $variation->options->map(fn($option) => [
                        'name' => $option->attribute->name,
                        'option' => $option->name
                    ]),
                ],
                'variations' => $variation->product->variations->map(fn($variation) => [
                    'id' => $variation->id,
                    'length' => $variation->length,
                    'breadth' => $variation->breadth,
                    'height' => $variation->height,
                    'weight' => $variation->weight,
                    'stock' => $variation->stock,
                    'price' => $variation->price,
                    'shipping_class_id' => $variation->shipping_class_id,
                    'tax_class_id' => $variation->tax_class_id,
                    'images' => $variation->images->map(fn($image) => [
                        'id' => $image->id,
                        'src' => $image->src,
                        'position' => $image->position,
                    ]),
                    'attributes' => $variation->options->map(fn($option) => [
                        'name' => $option->attribute->name,
                        'option' => $option->name
                    ]),
                ]),
                'attributes' => $variation->product->attributes->map(fn($attribute) => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'position' => $attribute->position,
                    'options' => $attribute->options->map(fn($option) => [
                        'id' => $option->id,
                        'name' => $option->name,
                        'position' => $option->position,
                    ]),
                ]),
            ]);
        return Product::where('id', $variationId)->with([
            'attributes' => fn(Builder $builder) => $builder->orderBy('position'),
            'attributes.options' => fn(Builder $builder) => $builder->orderBy('position'),
            'variations',
            'variations.images' => fn(Builder $builder) => $builder->orderBy('position'),
            'variations.options' => fn(Builder $builder) => $builder->orderBy('position'),
            'variations.options.attribute'
        ])->get()->map(fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'short_description' => $product->short_description,
                'description' => $product->description,
                'has_variations' => $product->has_variations,
                'category_id' => $product->category_id,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'variations' => $product->variations->map(fn($variation) => [
                    'id' => $variation->id,
                    'length' => $variation->length,
                    'breadth' => $variation->breadth,
                    'height' => $variation->height,
                    'weight' => $variation->weight,
                    'stock' => $variation->stock,
                    'price' => $variation->price,
                    'shipping_class_id' => $variation->shipping_class_id,
                    'tax_class_id' => $variation->tax_class_id,
                    'images' => $variation->images->map(fn($image) => [
                        'id' => $image->id,
                        'src' => $image->src,
                        'position' => $image->position,
                    ]),
                    'attributes' => $variation->options->map(fn($option) => [
                        'name' => $option->attribute->name,
                        'option' => $option->name
                    ]),
                ]),
                'attributes' => $product->attributes->map(fn($attribute) => [
                    'id' => $attribute->id,
                    'name' => $attribute->name,
                    'position' => $attribute->position,
                    'options' => $attribute->options->map(fn($option) => [
                        'id' => $option->id,
                        'name' => $option->name,
                        'position' => $option->position,
                    ]),
                ]),
            ]);
    }

    public function store(StoreProductRequest $request)
    {
        $product = DB::transaction(function () use ($request) {

            $product = $this->saveProduct($request->all());

            if ($request->has_variations) {
                $savedAttributes = $this->saveAttributes($product, $request->get('attributes'));

                $this->saveVariations($product, $request->variations, $savedAttributes);
            } else {
                $variation = $this->saveVariation($product, $request->all());

                $this->saveVariationImages($variation, $request->images);
            }

            return $product;
        });

        return ['id' => $product->id];
    }
    public function storedd(StoreProductRequest $request)
    {
        $product = Product::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_variant' => $request->is_variant,
            'is_virtual' => $request->is_virtual,
            'is_active' => $request->is_active,
            'is_featured' => $request->is_featured,
            'tax_class_id' => $request->tax_class_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
        ]);

        if ($request->is_variant) {
            $savedAttributes = collect();

            foreach ($request->get('attributes') as $attribute) {
                $savedAttribute = $product->attributes()->create([
                    'name' => $attribute['name'],
                    'type' => $attribute['type'],
                    'position' => $attribute['position'],
                ]);

                $savedOption = $savedAttribute->options()->create([
                    'name' => $attribute['name'],
                    'value' => $attribute['value'],
                    'label' => $attribute['label'],
                    'position' => $attribute['position'],
                    'is_default' => $attribute['is_default'],
                ]);

                $savedAttributes->push([
                    'attribute' => $savedAttribute->name,
                    'option' => $savedOption->name,
                    'id' => $savedOption->id
                ]);
            }

            foreach ($request->variations as $variation) {
                $savedVariation = ProductVariation::create([
                    'regular_price' => $variation['regular_price'],
                    'sale_price' => $variation['sale_price'],
                    'sale_start_at' => $variation['sale_start_at'],
                    'sale_end_at' => $variation['sale_end_at'],
                    'manage_stock' => $variation['manage_stock'],
                    'stock_quantity' => $variation['stock_quantity'],
                    'allow_backorder' => $variation['allow_backorder'],
                    'stock_thresold' => $variation['stock_thresold'],
                    'stock_status' => $variation['stock_status'],
                    'download_link' => $variation['download_link'],
                    'link_expires_at' => $variation['link_expires_at'],
                    'download_limit' => $variation['download_limit'],
                ]);

                foreach ($variation['images'] as $image) {
                    $savedVariation->images()->store([
                        'src' => $image['src'],
                        'position' => $image['position'],
                    ]);
                }

                $optionIds = collect();

                foreach ($variation['attributes'] as $attribute) {
                    foreach ($savedAttributes as $savedAttribute) {
                        if ($attribute['attribute'] == $savedAttribute['attribute'] && $attribute['option'] == $savedAttribute['option']) {
                            $optionIds->push($savedAttribute['id']);
                        }
                    }
                }

                $savedVariation->options()->attach($optionIds);
            }
        }
        $product = DB::transaction(function () use ($request) {

            $product = $this->saveProduct($request->all());

            if ($request->has_variations) {
                $savedAttributes = $this->saveAttributes($product, $request->get('attributes'));

                $this->saveVariations($product, $request->variations, $savedAttributes);
            } else {
                $variation = $this->saveVariation($product, $request->all());

                $this->saveVariationImages($variation, $request->images);
            }

            return $product;
        });

        return ['id' => $product->id];
    }
    public function get_products(StoreProductRequest $request)
    {
        $start = microtime(true);

        $products = Product::take(50)->skip(10000)->with([
            'variations' => function ($query) {
                $query->select('product_id', 'regular_price', 'sale_price', 'sale_start_at', 'sale_end_at', DB::raw("JSON_UNQUOTE(JSON_EXTRACT(images, '$[0]')) AS image"))->with([
                    'options' => function ($query) {
                        $query->where('is_default', 1)->select('product_variation_id');
                    }
                ]);
            }
        ])->select('id', 'title')->get()->map(function ($product) {
            $selectedVariation = $product->variations->first(function ($variation) {
                return $variation->options->count() == $variation->options->where('is_default', 1)->count();
            });

            if (!$selectedVariation) {
                $selectedVariation = $product->variations->first();
            }

            $onSale = false;

            if ($selectedVariation->sale_start_at && $selectedVariation->sale_end_at) {
                $currTime = strtotime(date('Y-m-d H:i:s'));
                if ($currTime >= strtotime($selectedVariation->sale_start_at) && $currTime <= strtotime($selectedVariation->sale_end_at)) {
                    $onSale = true;
                }
            } else if ($selectedVariation->sale_price != null) {
                $onSale = true;
            }

            return [
                'id' => $selectedVariation->id,
                'title' => $product->title,
                'image' => $selectedVariation->image,
                'on_sale' => $onSale
            ];

            $selectedVariation = null;

            $product->variations->each(function ($variation) {

                $totalMatch = 0;

                $variation->options->each(function ($option) use ($totalMatch) {

                    if ($option->is_default)
                        $totalMatch++;
                });

                if ($totalMatch == $variation->options->count()) {
                    $selectedVariation = $variation;
                }
            });

            if ($selectedVariation == null) {
                $selectedVariation = $product->variations->first();
            }

            $onSale = false;

            if ($selectedVariation->sale_start_at && $selectedVariation->sale_end_at) {
                $currTime = strtotime(date('Y-m-d H:i:s'));
                if ($currTime >= strtotime($selectedVariation->sale_start_at) && $currTime <= strtotime($selectedVariation->sale_end_at)) {
                    $onSale = true;
                }
            } else if ($selectedVariation->sale_price != null) {
                $onSale = true;
            }

            return [
                'id' => $selectedVariation->id,
                'title' => $product->title,
                // 'image' => json_decode()$selectedVariation->images,
                'on_sale' => $onSale
            ];
        });




        // End time
        $end = microtime(true);

        // Calculate execution time
        $time = $end - $start;

        return ['time' => $time, 'products' => $products];
        $product = Product::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'is_variant' => $request->is_variant,
            'is_virtual' => $request->is_virtual,
            'is_active' => $request->is_active,
            'is_featured' => $request->is_featured,
            'tax_class_id' => $request->tax_class_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
        ]);

        if ($product->is_variant && $request->is_variant) {
            if ($this->isAttributesChanged($request->get('attributes'), $product->attributes()->with('options')->get())) {
                foreach ($request->get('attributes') as $attribute) {
                    $savedAttribute = $product->attributes()->where('id', $attribute['id'])->first();

                    if ($savedAttribute) {
                        $savedAttribute->update([
                            'name' => $attribute['name'],
                            'position' => $attribute['position'],
                            'type' => $attribute['type']
                        ]);

                        foreach ($attribute['options'] as $option) {
                            $savedAttribute->options()->where('id', $option['id'])->update([
                                'name' => $option['name'],
                                'value' => $option['value'],
                                'position' => $option['position'],
                                'is_default' => $option['is_default']
                            ]);
                        }
                    }
                }
            } else {

            }




            $attributeChanged = false;

            $totalMatchedAttributes = 0;

            foreach ($request->get('attributes') as $attribute) {
                foreach ($product->attributes()->with('options')->get() as $savedAttribute) {
                    if ($attribute['name'] == $savedAttribute['name'] && count($attribute['options']) == $savedAttribute->options->count()) {
                        $totalMatchedOption = 0;

                        foreach ($attribute['options'] as $option) {
                            foreach ($savedAttribute->options as $savedOption) {
                                if ($savedOption['name'] == $option['name']) {
                                    $totalMatchedOption++;
                                }
                            }
                        }

                        if ($totalMatchedOption == count($attribute['options'])) {
                            $totalMatchedAttributes++;
                        }
                    }
                }
            }

            $savedAttributes = collect();

            foreach ($request->get('attributes') as $attribute) {
                $savedAttribute = $product->attributes()->create([
                    'name' => $attribute['name'],
                    'type' => $attribute['type'],
                    'position' => $attribute['position'],
                ]);

                $savedOption = $savedAttribute->options()->create([
                    'name' => $attribute['name'],
                    'value' => $attribute['value'],
                    'label' => $attribute['label'],
                    'position' => $attribute['position'],
                    'is_default' => $attribute['is_default'],
                ]);

                $savedAttributes->push([
                    'attribute' => $savedAttribute->name,
                    'option' => $savedOption->name,
                    'id' => $savedOption->id
                ]);
            }

            foreach ($request->variations as $variation) {
                $savedVariation = ProductVariation::create([
                    'regular_price' => $variation['regular_price'],
                    'sale_price' => $variation['sale_price'],
                    'sale_start_at' => $variation['sale_start_at'],
                    'sale_end_at' => $variation['sale_end_at'],
                    'manage_stock' => $variation['manage_stock'],
                    'stock_quantity' => $variation['stock_quantity'],
                    'allow_backorder' => $variation['allow_backorder'],
                    'stock_thresold' => $variation['stock_thresold'],
                    'stock_status' => $variation['stock_status'],
                    'download_link' => $variation['download_link'],
                    'link_expires_at' => $variation['link_expires_at'],
                    'download_limit' => $variation['download_limit'],
                ]);

                foreach ($variation['images'] as $image) {
                    $savedVariation->images()->store([
                        'src' => $image['src'],
                        'position' => $image['position'],
                    ]);
                }

                $optionIds = collect();

                foreach ($variation['attributes'] as $attribute) {
                    foreach ($savedAttributes as $savedAttribute) {
                        if ($attribute['attribute'] == $savedAttribute['attribute'] && $attribute['option'] == $savedAttribute['option']) {
                            $optionIds->push($savedAttribute['id']);
                        }
                    }
                }

                $savedVariation->options()->attach($optionIds);
            }
        }
        $product = DB::transaction(function () use ($request) {

            $product = $this->saveProduct($request->all());

            if ($request->has_variations) {
                $savedAttributes = $this->saveAttributes($product, $request->get('attributes'));

                $this->saveVariations($product, $request->variations, $savedAttributes);
            } else {
                $variation = $this->saveVariation($product, $request->all());

                $this->saveVariationImages($variation, $request->images);
            }

            return $product;
        });

        return ['id' => $product->id];
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {

            $hasVariations = $product->has_variations;

            $this->updateProduct($product, $request->all());

            if ($hasVariations && $request->has_variations) {
                if ($this->isAttributesChanged($product->attributes()->with('options')->get(), $request->input('attributes'))) {
                    $product->attributes()->delete();

                    $product->variations()->delete();

                    $savedAttributes = $this->saveAttributes($product, $request->input('attributes'));

                    $this->saveVariations($product, $request->variations, $savedAttributes);
                } else {
                    $this->updateAttributes($product, $request->get('attributes'));

                    $this->updateVariations($product->variations(), $prooduct->is_virtual, $request->variations);
                }
            } else if ($hasVariations == false && $request->has_variations == false) {
                $variation = $product->variations()->first();

                $this->updateVariation($variation, $request->all(), $product->is_downloadable);

                $this->updateVariationImages($variation, $request->images);
            } else if ($hasVariations == false && $request->has_variations) {
                $product->variations()->delete();

                $savedAttributes = $this->saveAttributes($product, $request->input('attributes'));

                $this->saveVariations($product, $request->variations, $savedAttributes);
            } else if ($hasVariations && $request->has_variations == false) {
                $product->attributes()->delete();

                $product->variations()->delete();

                $variation = $this->saveVariation($product, $request->all());

                $this->saveVariationImages($variation, $request->images);
            }
        });

        return response()->json(['id' => $product->id]);
    }

    public function delete(Product $product)
    {
        $product->delete();

        return response()->json($product);
    }


    private function isAttributesChanged($attributes1, $attributes2)
    {
        if (count($attributes1) !== count($attributes2))
            return true;

        $totalAttributes = 0;

        foreach ($attributes1 as $attribute1) {
            foreach ($attributes2 as $attribute2) {
                if (strtolower($attribute1['name']) === strtolower($attribute2['name']) && count($attribute1['options']) === count($attribute2['options'])) {
                    $totalOptions = 0;

                    foreach ($attribute1['options'] as $option1) {
                        foreach ($attribute2['options'] as $option2) {
                            if (strtolower($option1['name']) === strtolower($option2['name']))
                                $totalOptions++;
                        }
                    }

                    if (count($attribute1['options']) === $totalOptions)
                        $totalAttributes++;
                }
            }
        }

        return count($attributes1) !== $totalAttributes;
    }

    private function saveProduct(array $product): Product
    {
        return Product::create([
            'name' => $product['name'],
            'short_description' => $product['short_description'],
            'description' => $product['description'],
            'category_id' => $product['category_id'],
            'brand_id' => $product['brand_id'],
            'has_variations' => $product['has_variations'],
            'is_downloadable' => $product['is_downloadable'],
            'gst_rate' => $product['gst_rate'],
            'is_active' => $product['is_active'],
        ]);
    }

    private function updateProduct(Product $product, array $newProduct): Product
    {
        $product->name = $newProduct['name'] ?? $product->name;

        $product->short_description = array_key_exists('short_description', $newProduct) ? $newProduct['short_description'] : $product->short_description;

        $product->description = array_key_exists('description', $newProduct) ? $newProduct['description'] : $product->description;

        $product->category_id = $newProduct['category_id'] ?? $product->category_id;

        $product->brand_id = array_key_exists('brand_id', $newProduct) ? $newProduct['brand_id'] : $product->brand_id;

        $product->has_variations = $newProduct['has_variations'] ?? $product->has_variations;

        $product->is_downloadable = $newProduct['is_downloadable'] ?? $product->is_downloadable;

        $product->gst_rate = array_key_exists('gst_rate', $newProduct) ? $newProduct['gst_rate'] : $product->gst_rate;

        $product->is_active = array_key_exists('is_active', $newProduct) ? $newProduct['is_active'] : $product->is_active;

        $product->save();

        Log::info($newProduct);

        return $product;
    }

    private function saveAttributes(Product $product, array $attributes)
    {
        $result = [];

        foreach ($attributes as $attribute) {
            $savedAttribute = $product->attributes()->create([
                'name' => $attribute['name'],
                'type' => $attribute['type'],
                'position' => $attribute['position']
            ]);

            foreach ($attribute['options'] as $option) {
                $savedOption = $savedAttribute->options()->create([
                    'name' => $option['name'],
                    'value' => $option['value'],
                    'position' => $option['position'],
                    'is_default' => $option['is_default']
                ]);

                $result[] = [
                    'name' => $savedAttribute['name'],
                    'option' => $savedOption['name'],
                    'option_id' => $savedOption['id']
                ];
            }
        }

        return $result;
    }

    private function updateAttributes(Product $product, array $attributes)
    {
        foreach ($attributes as $attribute) {
            $savedAttribute = $product->attributes()->where('id', $attribute['id'])->firstOrFail();

            $savedAttribute->update([
                'name' => $attribute['name'],
                'position' => $attribute['position'],
                'type' => $attribute['type']
            ]);

            foreach ($attribute['options'] as $option) {
                $savedAttribute->options()->where('id', $option['id'])->update([
                    'name' => $option['name'],
                    'value' => $option['value'],
                    'position' => $option['position'],
                    'is_default' => $option['is_default']
                ]);
            }
        }
    }

    private function saveVariation($product, $newVariation)
    {
        return $product->variations()->create([
            'regular_price' => $newVariation['regular_price'],
            'sale_stock' => $newVariation['stock_price'],
            'sale_start_at' => $newVariation['sale_start_at'],
            'sale_end_at' => $newVariation['sale_end_at'],
            'manage_stock' => $newVariation['manage_stock'],
            'stock_quantity' => $newVariation['manage_stock'] ? $newVariation['stock_quantity'] : null,
            'stock_thresold' => $newVariation['manage_stock'] ? $newVariation['stock_thresold'] : null,
            'allow_backorder' => $newVariation['manage_stock'] ? $newVariation['allow_backorder'] : null,
            'stock_status' => $newVariation['manage_stock'] ? null : $newVariation['stock_status'],
            'download_link' => $isVirtual ? $newVariation['download_link'] : null,
            'link_expires_at' => $isVirtual ? $newVariation['link_expires_at'] : null,
            'download_limit' => $isVirtual ? $newVariation['download_limit'] : null,
            'length' => $isVirtual ? null : $newVariation['length'],
            'width' => $isVirtual ? null : $newVariation['width'],
            'height' => $isVirtual ? null : $newVariation['height'],
            'weight' => $isVirtual ? null : $newVariation['weight'],
        ]);
    }

    private function saveVariations($product, $savedAttributes, $newVariations)
    {
        foreach ($newVariations as $newVariation) {
            $variation = $this->saveVariation($product, $newVariation);

            $this->saveVariationImages($variation->images(), $newVariation['images']);

            $this->saveVariationAttributes($variation->options(), $newVariation['attributes'], $savedAttributes);
        }
    }

    private function saveVariationAttributes($options, $newAttributes, $savedAttributes)
    {
        foreach ($newAttributes as $newAttributes) {
            foreach ($savedAttributes as $savedAttribute) {
                if ($savedAttribute['name'] === $newAttributes['name'] && $savedAttribute['option'] === $newAttributes['option']) {
                    $options->attach($savedAttribute['option_id']);
                }
            }
        }
    }

    private function updateVariation($variation, $newVariation, $isVirtual)
    {
        $variation->update([
            'regular_price' => $newVariation['regular_price'],
            'sale_stock' => $newVariation['stock_price'],
            'sale_start_at' => $newVariation['sale_start_at'],
            'sale_end_at' => $newVariation['sale_end_at'],
            'manage_stock' => $newVariation['manage_stock'],
            'stock_quantity' => $newVariation['manage_stock'] ? $newVariation['stock_quantity'] : null,
            'stock_thresold' => $newVariation['manage_stock'] ? $newVariation['stock_thresold'] : null,
            'allow_backorder' => $newVariation['manage_stock'] ? $newVariation['allow_backorder'] : null,
            'stock_status' => $newVariation['manage_stock'] ? null : $newVariation['stock_status'],
            'download_link' => $isVirtual ? $newVariation['download_link'] : null,
            'link_expires_at' => $isVirtual ? $newVariation['link_expires_at'] : null,
            'download_limit' => $isVirtual ? $newVariation['download_limit'] : null,
            'length' => $isVirtual ? null : $newVariation['length'],
            'width' => $isVirtual ? null : $newVariation['width'],
            'height' => $isVirtual ? null : $newVariation['height'],
            'weight' => $isVirtual ? null : $newVariation['weight'],
        ]);
    }

    private function updateVariations($variations, $isVirtual, $newVariations)
    {
        foreach ($newVariations as $newVariation) {
            $variation = $variations->where('id', $newVariation['id'])->first();

            if ($variation) {
                $this->updateVariation($variation, $newVariation, $isVirtual);

                $this->updateVariationImages($variation->images(), $newVariation['images']);
            }
        }
    }

    private function saveVariationImages($images, $newImages)
    {
        foreach ($newImages as $newImage) {
            $images->create([
                'src' => $image['src'],
                'position' => $image['position']
            ]);
        }
    }

    private function updateVariationImages($images, $newImages)
    {
        foreach ($images as $image) {
            $isDeleted = true;

            foreach ($newImages as $newImage) {
                if (isset($newImage['id']) && $image->id == $image['id']) {
                    $isDeleted = false;
                }
            }

            if ($isDeleted) {
                $image->delete();
            }
        }

        foreach ($newImages as $newImage) {
            if (empty($newImage['id'])) {
                $images()->create([
                    'src' => $newImage['src'],
                    'position' => $newImage['position']
                ]);
            } else {
                $images()->where('id', $image['id'])->update([
                    'src' => $image['src'],
                    'position' => $image['position']
                ]);
            }
        }
    }
}
