<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;

class BuyerProductController extends ApiController
{
    public function index(Buyer $buyer)
    {
        return $this->seeAll($buyer->products);
    }
}
