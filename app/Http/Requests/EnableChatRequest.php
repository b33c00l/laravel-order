<?php

namespace App\Http\Requests;

use App\Chat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EnableChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $chat_id = $this->get('chat_id');
        $chat = Chat::where('id', $chat_id)->first();

        if (Auth::id() == $chat->user_id || Auth::user()->role == 'admin') {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
