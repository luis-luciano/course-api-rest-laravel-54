<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int) $transaction->id,
            'amount' => (int) $transaction->quantity,
            'buyer' => (int) $transaction->buyer_id,
            'product' => (int) $transaction->product_id,
            'dateCreated' => (string) $transaction->created_at,
            'dateUpdated' => (string) $transaction->updated_at,
            'dateDeleted' => ((string) $transaction->deleted_at) ?? null,
        ];
    }
}
