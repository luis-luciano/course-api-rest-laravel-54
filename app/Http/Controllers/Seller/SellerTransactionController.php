<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;

class SellerTransactionController extends ApiController
{
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions') // unicamente transactions
            ->collapse(); // une todas las listas en una sola con collapse

        return $this->seeAll($transactions);
    }
}
