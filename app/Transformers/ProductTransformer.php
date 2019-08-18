<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier' => (int) $product->id,
            'title' => (string) $product->name,
            'details' => (string) $product->description,
            'amountAvailables' => $product->quantity,
            'status' => (string) $product->status,
            'image' => url("img/{$product->image}"),
            'seller' => (int) $product->seller_id,
            'dateCreated' => (string) $product->created_at,
            'dateUpdated' => (string) $product->updated_at,
            'dateDeleted' => ((string) $product->deleted_at) ?? null,
        ];
    }
}
