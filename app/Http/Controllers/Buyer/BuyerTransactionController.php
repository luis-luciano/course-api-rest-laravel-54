<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerTransactionController extends ApiController
{
    public function index(Buyer $buyer)
    {
        return $this->seeAll($buyer->transactions);
    }
}
