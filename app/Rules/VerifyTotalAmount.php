<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Product;

class VerifyTotalAmount implements Rule
{
    public $quantity;
    public $productId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($quantity, $productId)
    {
        $this->quantity = $quantity;
        $this->productId = $productId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product = Product::select('price')->where('id', $this->productId)->first();
        if($product) {
            $totalAmount = $product->price * $this->quantity;
            if($totalAmount == $value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
