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
            'name' => 'required|unique:users,name',
            'role' => 'required',
            'client_name' => 'required_if:role,user',
            'email' => 'required' ,
            'contact_person' => 'required_if:role,user' ,
            'phone' => 'required_if:role,user' ,
            'payment_terms' => 'required_if:role,user' ,
            'country_id' => 'required_if:role,user',
            'price_coefficient' => 'nullable|numeric|required_if:role,user',
        ];
    }
}
