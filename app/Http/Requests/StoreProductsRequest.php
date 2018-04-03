<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PositivePrice;

class StoreProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name'  => 'required',
            'platform_name' => 'required',
            'ean'   => 'required|numeric|unique:products,ean,' . $this->route('product') . ',id|digits:13',
            'stock_amount' => 'required|integer|min:0',
            'price_amount' => ["required", 'numeric', new PositivePrice()],
            'pegi' => 'numeric|nullable',
            'image' => 'mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
