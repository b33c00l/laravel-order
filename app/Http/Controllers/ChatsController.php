<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Requests\DisableChatRequest;
use App\Http\Requests\EnableChatRequest;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

    public function index()
    {
        if (Auth::user()->role == "user") {
            return redirect()->route('chat.user');
        }
        $chats = Chat::where('status', Chat::ACTIVE)->orderBy('id', 'DESC')->get();
        return view('chat.index', compact('chats'));
    }

    public function create()
    {
        $orders = Order::all();
        return view('chat.create', compact('orders'));
    }

    public function store(StoreChatRequest $request)
    {
        $chat = Chat::create($request->only('topic', 'order_id') + ['user_id' => Auth::id()]);
        $chat->messages()->create($request->only('message') + ['user_id' => Auth::id()]);

        return redirect()->route('chat.show', $chat->id);
    }

    public function show($id)
    {
        $chat = Chat::findOrFail($id);
        if (Auth::user()->role !== 'admin' && $chat->user_id !== Auth::id()) {
            return redirect()->route('chat.user');
        }
        $messages = $chat->messages()->get();
        return view('chat/show', compact('chat', 'messages'));
    }

    public function storeMessage(StoreMessageRequest $request)
    {
        $chat = Chat::findOrFail($request->chat_id);
        if (Auth::user()->role == 'admin') {
            if ($chat->admin_id === null) {
                $chat->update(['admin_id' => Auth::id()]);
            }
        }
        $chat->messages()->create($request->only('message') + ['user_id' => Auth::id()]);
        return redirect()->route('chat.show', $request->chat_id);
    }

    public function disable(DisableChatRequest $request)
    {
        $chat = Chat::findOrFail($request->chat_id);
        $chat->update(['status' => Chat::INACTIVE]);
        return redirect()->back();
    }

    public function enable(EnableChatRequest $request)
    {
        $chat = Chat::findOrFail($request->chat_id);
        $chat->update(['status' => Chat::ACTIVE]);
        return redirect()->back();
    }

    public function getUserChats()
    {
        Chat::where('user_id', Auth::id())->get();
    }
}
