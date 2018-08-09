<?php

namespace App;

use App\Scopes\BuyerScope;

class Buyer extends User
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new BuyerScope);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Mutators
    public function getProductsAttribute()
    {
        return $this->transactions()->with('product')->get()->pluck('product');
    }
}
