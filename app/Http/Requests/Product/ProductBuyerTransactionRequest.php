<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductBuyerTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $buyer = $this->route('buyer');
        $product = $this->route('product');

        // Buyer and Seller must be different
        if ($buyer->id == $product->seller_id) {
            return false;
        }

        // Check if the buyer and seller is verified
        if (!$buyer->verified && !$product->seller->verified) {
            return false;
        }

        // Check if the product is available
        if (!$product->available) {
            return false;
        }

        // Check of the quantity available of the product
        if ($product->quantity < $this->input('quantity')) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'required|integer|min:1',
        ];
    }
}
