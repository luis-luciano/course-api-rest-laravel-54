<?php

namespace App\Policies;

use App\Product;
use App\seller;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given product can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return bool
     */
    public function update(User $user, Product $product, Seller $seller)
    {
        return $this->belongsTo($product, $seller);
    }

    /**
     * Determine if the given product can be updated by the user.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return bool
     */
    public function destroy(User $user, Product $product, Seller $seller)
    {
        return $this->belongsTo($product, $seller);
    }

    private function belongsTo(Product $product, Seller $seller)
    {
        return $seller->id === $product->seller_id;
    }
}
