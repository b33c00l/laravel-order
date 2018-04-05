<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|unique:users,name,' . $this->route('user'),
            'role' => 'required',
            'vat_number' => 'required_if:role,user',
            'registration_number' => 'required_if:role,user' ,
            'registration_address' => 'required_if:role,user' ,
            'shipping_address' => 'required_if:role,user' ,
            'email' => 'required_if:role,user' ,
            'contact_person' => 'required_if:role,user' ,
            'phone' => 'required_if:role,user' ,
            'payment_terms' => 'required_if:role,user' ,
            'price_coefficient' => 'nullable|numeric|required_if:role,user'
        ];
    }
}
