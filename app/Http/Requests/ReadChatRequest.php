<?php

namespace App\Http\Requests;

use App\Chat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReadChatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $chat_id = $this->route('chat');
        $chat = Chat::findOrFail($chat_id);
        if (Auth::user()->role !== 'admin' && $chat->user_id !== Auth::id()) {
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
            //
        ];
    }
}
