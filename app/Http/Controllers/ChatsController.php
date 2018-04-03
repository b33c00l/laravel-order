<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Http\Requests\DisableChatRequest;
use App\Http\Requests\EnableChatRequest;
use App\Http\Requests\ReadChatRequest;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\StoreMessageRequest;
use App\Mail\AdminChatMessageReceived;
use App\Mail\ChatMessageReceived;
use App\Mail\ChatTopicCreated;
use App\Order;
use App\Services\ContactService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChatsController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index()
    {
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

        if (Auth::user()->role == 'user') {
            $adminEmail = $this->contactService->getEmailForCountry(Auth::user()->country);
            Mail::to($adminEmail)->send(new ChatTopicCreated($chat->id));
        }

        return redirect()->route('chat.show', $chat->id);
    }

    public function show(ReadChatRequest $request, $id)
    {
        $chat = Chat::findOrFail($id);
        $messages = $chat->messages()->get();
        return view('chat/show', compact('chat', 'messages'));
    }

    public function storeMessage(StoreMessageRequest $request)
    {
        $chat = Chat::findOrFail($request->chat_id);
        $client = $chat->user;
        $message = $request->get('message');

        if (Auth::user()->role == 'admin') {
            if ($chat->admin_id === null) {
                $chat->update(['admin_id' => Auth::id()]);
            }
        }

        if ($chat->admin_id == null) {
            $adminEmail = $this->contactService->getEmailForCountry(Auth::user()->country);
            Mail::to($adminEmail)->send(new ChatMessageReceived('admin', $chat->id, $message));
        } else {
            $admin = $chat->admin;
            $adminTrack = $admin->user_online;
            $adminRole = $admin->role;
            $adminEmail = $this->contactService->getEmailForCountry($admin->country);
            $diffTimeAdmin = carbon::now()->diffInMinutes($adminTrack);
            if ($adminRole == 'admin' && $diffTimeAdmin > config('session.active_time')) {
                Mail::to($adminEmail)->send(new ChatMessageReceived('admin', $chat->id, $message));
            }
        }

        $clientTrack = $client->user_online;
        $clientRole = $client->role;
        $clientEmail = $client->client->email;

        $diffTimeClient = carbon::now()->diffInMinutes($clientTrack);

        $chat->messages()->create($request->only('message') + ['user_id' => Auth::id()]);

        if ($clientRole == 'user' && $diffTimeClient > config('session.active_time')) {
            Mail::to($clientEmail)->send(new ChatMessageReceived('client', $chat->id, $message, $client->name));
        }

        return redirect()->back();
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
