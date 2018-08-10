<?php

namespace App\Policies;

use App\Category;
use App\Product;
use App\Seller;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

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

    public function categoryDetach(User $user, Product $product, Category $category)
    {
        return $this->belongsTo($product, $category);
    }

    private function belongsTo(Product $product, Model $model)
    {
        // Product has a Category
        if ($this->isOfType($model, Category::class)) {
            return $this->belongsToCategory($product, $model);
        }

        // Product belongs to Seller
        return $this->isOfType($model, Seller::class) && $model->id === $product->seller_id;
    }

    private function belongsToCategory(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return false;
        }

        return true;
    }
    private function isOfType(Model $model, $destinyClass)
    {
        return $model instanceof $destinyClass;
    }
}
