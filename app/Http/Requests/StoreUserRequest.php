<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required',
            'password' =>'required',
            'role' => 'required',
            'vat_number' => 'required_if:role,user',
            'registration_number' => 'required_if:role,user' ,
            'registration_address' => 'required_if:role,user' ,
            'shipping_address' => 'required_if:role,user' ,
            'email' => 'required_if:role,user' ,
            'contact_person' => 'required_if:role,user' ,
            'phone_number' => 'required_if:role,user' ,
            'payment_terms' => 'required_if:role,user' ,
        ];
    }
}
