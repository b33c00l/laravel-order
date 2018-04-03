<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SpecialOfferMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $special;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($special, $user)
    {
        $this->special = $special;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $description = $this->special->description;
        $expiration_date = $this->special->expiration_date;
        $prices = $this->special->prices;
        foreach($prices as $price){
            $product[] = $price->products;
        }

        return $this->view('emails.offers.special')
            ->with([
                'description' => $description,
                'expiration_date' => $expiration_date,
                'products' => $product,
                'user' => $this->user
            ]);
    }
}
