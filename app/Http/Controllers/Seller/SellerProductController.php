<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Product;
use App\Seller;
use App\User;
use Symfony\Component\HttpFoundation\Response;

class SellerProductController extends ApiController
{
    public function index(Seller $seller)
    {
        $products = $seller->products;

        return $this->seeAll($products);
    }

    public function store(ProductStoreRequest $request, User $seller)
    {
        $product = new Product($request->all());

        // By default generate name random
        $product->image = $request->file('image')->store('', 'images');
        $product->seller_id = $seller->id;

        $product->save();

        return $this->showOne($product, Response::HTTP_CREATED);
    }

    public function update(ProductUpdateRequest $request, Seller $seller, Product $product)
    {
        $this->authorize('update', [$product, $seller]);

        $product->fill($request->all());

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

        return $this->showOne($product);
    }
}
