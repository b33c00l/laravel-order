<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSpecialOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($user = Auth::user()->role == 'admin') {
            return true;
        } else {
            return false;
        }

    }

    public function rules()
    {
        return [
            'filename' => 'required',
            'games' => 'required',
        ];
    }
}
