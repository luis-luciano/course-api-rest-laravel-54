<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductBuyerTransactionRequest;
use App\Product;
use App\Transaction;
use App\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductBuyerTransactionController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductBuyerTransactionRequest $request, Product $product, User $buyer)
    {
        try {
            DB::beginTransaction();

            $product->quantity -= $product->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->input('quantity'),
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            DB::commit();

            return $this->showOne($transaction, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollback();
        }
    }
}
