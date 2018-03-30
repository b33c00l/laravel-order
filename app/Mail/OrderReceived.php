<?php

namespace App\Mail;

use App\Services\CartService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceived extends Mailable
{
    protected $order;
    protected $cartService;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this->view('emails.orders.userOrderSent')
            ->with([
                'orderProducts' => $this->order->orderProducts,
                'total' => $this->cartService->getTotalCartPrice($this->order),
            ]);
    }
}
