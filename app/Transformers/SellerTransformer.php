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
            'name' => (string) $seller->name,
            'email' => (string) $seller->email,
            'isVerified' => (boolean) $seller->verified,
            'dateCreated' => (string) $seller->created_at,
            'dateUpdated' => (string) $seller->updated_at,
            'dateDeleted' => ((string) $seller->deleted_at) ?? null,
        ];
    }
}
