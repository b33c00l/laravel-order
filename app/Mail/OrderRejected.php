<?php

namespace App\Mail;

use App\Services\CartService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderRejected extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order , CartService $cartService)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(CartService $cartService)
    {
        return $this->view('emails.orders.rejected')
            ->with([
                'order' => $this->order,
                'orderProducts' => $this->order->orderProducts,
                'totalOrder' => $cartService->getTotalCartPrice($this->order)
            ]);
    }
}
