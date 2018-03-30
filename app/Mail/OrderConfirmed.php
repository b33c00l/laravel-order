<?php

namespace App\Mail;

use App\Services\CartService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $cartService;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order , CartService $cartService)
    {
        $this->order = $order;
        $this->cartService = $cartService;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.orders.confirmed')
            ->with([
                'order' => $this->order,
                'orderProducts' => $this->order->orderProducts,
                'totalOrder' => $this->cartService->getTotalCartPrice($this->order)
            ]);
    }
}
