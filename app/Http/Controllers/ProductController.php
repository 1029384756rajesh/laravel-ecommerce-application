<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request, Product $product)
    {
        $request->validate([
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'limit' => 'integer',
            'offset' => 'integer'
        ]);

        $query = Product::orderBy('id', 'desc');

        $query->where('is_featured', $request->is_featured ? ((bool) $request->is_featured) : true);

        $query->where('is_active', $request->is_active ? ((bool) $request->is_active) : true);

        $query->limit($request->limit ? $request->limit : 10);

        $query->skip($request->offset ? $request->offset : 0);

        if($request->category_id)
        {
            $query->whereIn('category_id', $request->category_id);
        }

        if($request->search)
        {
            $query->where('name', 'like', '%' . $request->search . '%');
            $query->orWhere('short_description', 'like', '%' . $request->search . '%');
            $query->orWhere('long_description', 'like', '%' . $request->search . '%');
        }

        $products = $query->with('skus')->get()->toArray();

        for ($i=0; $i < count($products); $i++) 
        { 
            if(count($products[$i]['skus']) > 1)
            {
                $min = $products[$i]['skus'][0]['price'];

                $max = 0;

                foreach ($products[$i]['skus'] as $sku) 
                {
                    if($sku['price'] < $min)
                    {
                        $min = $sku['price'];
                    }

                    if($sku['price'] > $max)
                    {
                        $max = $sku['price'];
                    }
                }

                $products[$i]['minPrice'] = $min;
                $products[$i]['maxPrice'] = $max;
            }
            else 
            {
                $products[$i]['maxPrice'] = $products[$i]['skus'][0]['price'];
                $products[$i]['minPrice'] = 0;
            }

            $products[$i] = [
                'name' => $products[$i]['name'],
                'minPrice' => $products[$i]['minPrice'],
                'maxPrice' => $products[$i]['maxPrice'],
                'imageUrl' => $products[$i]['image_url'],
            ];
        }

        return response()->json($products);
    }

    public function product(Product $product)
    {
        $skus = $product->skus()->get()->toArray();

        for ($i=0; $i < count($skus); $i++) 
        { 
            $skus[$i] = [
                'stock' => $skus[$i]['stock'],
                'price' => $skus[$i]['price'],
                'values' => explode("|", $skus[$i]['values']),
                'gallery' => explode("|", $skus[$i]['gallery'])
            ];
        }

        $variants = $product->variants()->get()->toArray();

        for ($i=0; $i < count($variants); $i++) 
        { 
            $variants[$i] = [
                'values' => explode("|", $variants[$i]['values']),
                'name' => $variants[$i]['name']
            ];
        }

        $product->skus = $skus;
        $product->variants = $variants;

        $product = $product->toArray();

        if(count($product['skus']) > 1)
        {
            $min = $product['skus'][0]['price'];

            $max = 0;

            foreach ($product['skus'] as $sku) 
            {
                if($sku['price'] < $min)
                {
                    $min = $sku['price'];
                }

                if($sku['price'] > $max)
                {
                    $max = $sku['price'];
                }
            }

            $product['minPrice'] = $min;
            $product['maxPrice'] = $max;
        }
        else 
        {
            $product['maxPrice'] = $product['skus'][0]['price'];
            $product['minPrice'] = 0;
        }

        return response()->json([
            'id' => $product['id'],
            'name' => $product['name'],
            'shortDescription' => $product['short_description'],
            'longDescription' => $product['long_description'],
            'minPrice' => $product['minPrice'],
            'maxPrice' => $product['maxPrice'],
            'skus' => $product['skus'],
            'variants' => $product['variants'],
        ]);
    }
}
