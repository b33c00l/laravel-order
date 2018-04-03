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
    protected $orderComment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $backOrder, $preOrder, $orderComment)
    {
        $this->order = $order;
        $this->backOrder = $backOrder;
        $this->preOrder = $preOrder;
        $this->orderComment = $orderComment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(CartService $cartService)
    {
        return
            $this->view('emails.orders.userOrderSent')
            ->with([
                'orderProducts'     => ($this->order != null ? $this->order->orderProducts : null),
                'backOrderProducts' => ($this->backOrder != null ? $this->backOrder->orderProducts : null),
                'preOrderProducts'  => ($this->preOrder != null ? $this->preOrder->orderProducts : null),
                'orderComment'      => ($this->orderComment != null ? $this->orderComment : null),
                'totalOrder'        => ($this->order != null ? $cartService->getTotalCartPrice($this->order) : null),
                'totalBackOrder'    => ($this->backOrder != null ? $cartService->getTotalCartPrice($this->backOrder) : null),
                'totalPreOrder'     => ($this->preOrder != null ? $cartService->getTotalCartPrice($this->preOrder) : null),
            ]);
    }
}
