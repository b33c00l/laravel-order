<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChatMessageReceived extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $recipient;
    protected $chat_id;
    protected $clientName;
    protected $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recipient, $chat_id, $msg, $clientName = '')
    {
        $this->recipient = $recipient;
        $this->chat_id = $chat_id;
        $this->clientName = $clientName;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->recipient == 'admin') {
            return $this->view('emails.chat.messageToAdmin')
                ->with([
                    'chat_id' => $this->chat_id,
                    'msg'       => $this->msg
                ]);
        } else {
            return $this->view('emails.chat.messageToClient')
                ->with([
                    'chat_id'       => $this->chat_id,
                    'clientName'    => $this->clientName,
                    'msg'           => $this->msg
                ]);
        }
    }
}
