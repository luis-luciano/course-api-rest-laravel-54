<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'buyer_id',
        'product_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // Relatioships -----------------------------------------------------------------------------------------------------------
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // ------------------------------------------------------------------------------------------------------------------------

    // Mutators ---------------------------------------------------------------------------------------------------------------
    public function getCategoriesAttribute()
    {
        return $this->product->categories;
    }

    public function getSellerAttribute()
    {
        return $this->product->seller;
    }
}
