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
            'titulo' => (string) $product->name,
            'descripcion' => (string) $product->description,
            'cantidad_disponible' => $product->quantity,
            'status' => (string) $product->status,
            'imagen' => url("img/{$product->image}"),
            'vendedor' => (int) $product->seller_id,
            'fecha_creacion' => (string) $product->created_at,
            'fecha_actualizacion' => ((string) $product->updated_at) ?? null,
            'fecha_eliminacion' => ((string) $product->deleted_at) ?? null,
        ];
    }
}
