<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct() {
        if (Product::count() === 0){
            Cache::flush();
        }
    }
   
    public function getAll()
    {
        $products = Product::paginate();

        if ($products->count() === 0)
        {
            return $products;
        }

        $cachedProducts = Cache::remember('products', random_int(120, 300), function () use ($products) {
            return $products;
        });

        return $cachedProducts;
    }

    public function createProduct(array $productDetails)
    {
        $newProduct = Product::create($productDetails);

        // update the cache
        Cache::pull("products");
        Cache::put("products", Product::paginate(), random_int(120, 300));

        return $newProduct;
    }

    public function findProduct(int $id)
    {
        $key = "product_{$id}";

        $product = Cache::remember($key, random_int(120, 300), function () use ($id) {
            return Product::findOrFail($id);
        });

        return $product;
    }

    public function update(int $id, array $fields)
    {
        // update the product
        $product = $this->findProduct($id);
        $product->update($fields);

        // update the cache
        Cache::pull("product_{$id}");
        Cache::put("product_{$id}", $product, random_int(120, 300));

        return $product;
        
        
    }

    public function deleteProduct(int $id)
    {
        $product = $this->findProduct($id);
        $product->delete();

        // update cache
        Cache::forget("product_{$id}");
        Cache::forget("products");
    }
}
