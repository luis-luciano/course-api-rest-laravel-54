<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->seeAll($categories);
    }

    public function update(Product $product, Category $category)
    {
        // syncWithoutDetaching agrega elementos sin repetir a una relacion muchos a muchos
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->seeAll($product->categories);
    }
}
