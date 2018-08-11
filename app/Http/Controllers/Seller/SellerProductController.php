<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Product;
use App\Seller;
use App\Services\Product as ProductService;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class SellerProductController extends ApiController
{
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->seeAll($products);
    }

    public function store(ProductStoreRequest $request, User $seller)
    {
        $product = new Product($request->all());

        // By default generate name random
        $product->image = $this->productService->storeImage($request->file('image'));
        $product->seller_id = $seller->id;

        $product->save();

        return $this->showOne($product, Response::HTTP_CREATED);
    }

    public function update(ProductUpdateRequest $request, Seller $seller, Product $product)
    {
        $this->authorize('update', [$product, $seller]);

        $product->image = $this->productService->storeImage($request->file('image'), $product->image);

        // Except image to avoid collisions
        $product->fill($request->except('image'));

        if ($product->isClean()) {
            return $this->successResponse();
        }

        $product->save();

        return $this->showOne($product);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->authorize('destroy', [$product, $seller]);

        $product->delete();

        $this->productService->deleteImage($product->image);

        return $this->showOne($product);
    }
}
