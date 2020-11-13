<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Buyer $buyer)
    {
        return [
            'identifier' => (int) $buyer->id,
            'nombre' => (string) $buyer->name,
            'correo' => (string) $buyer->email,
            'es_verificado' => (boolean) $buyer->verified,
            'fecha_creacion' => (string) $buyer->created_at,
            'fecha_actualizacion' => ((string) $buyer->updated_at) ?? null,
            'fecha_eliminacion' => ((string) $buyer->deleted_at) ?? null,
        ];
    }
}
