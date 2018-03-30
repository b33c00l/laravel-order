<?php

namespace App\Mail;

use App\Services\CartService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $backOrder;
    protected $preOrder;
    protected $cartService;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $backOrder, $preOrder, CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->order = $order;
        $this->backOrder = $backOrder;
        $this->preOrder = $preOrder;
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
                'orderProducts' => ($this->order != null ? $this->order->orderProducts : null),
                'backOrderProducts' => ($this->backOrder != null ? $this->backOrder->orderProducts : null),
                'preOrderProducts' => ($this->preOrder != null ? $this->preOrder->orderProducts : null),

                'totalOrder' => ($this->order != null ? $this->cartService->getTotalCartPrice($this->order) : null),
                'totalBackOrder' => ($this->backOrder != null ? $this->cartService->getTotalCartPrice($this->backOrder) : null),
                'totalPreOrder' => ($this->preOrder != null ? $this->cartService->getTotalCartPrice($this->preOrder) : null),
            ]);
    }
}
