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
            'name' => (string) $buyer->name,
            'email' => (string) $buyer->email,
            'isVerified' => (boolean) $buyer->verified,
            'dateCreated' => (string) $buyer->created_at,
            'dateUpdated' => (string) $buyer->updated_at,
            'dateDeleted' => ((string) $buyer->deleted_at) ?? null,
        ];
    }
}
