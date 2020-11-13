<?php

namespace App\Transformers;

use App\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Seller $seller)
    {
        return [
            'identifier' => (int) $seller->id,
            'nombre' => (string) $seller->name,
            'correo' => (string) $seller->email,
            'es_verificado' => (boolean) $seller->verified,
            'fecha_creacion' => (string) $seller->created_at,
            'fecha_actualizacion' => (string) $seller->updated_at,
            'fecha_eliminacion' => ((string) $seller->deleted_at) ?? null,
        ];
    }
}
