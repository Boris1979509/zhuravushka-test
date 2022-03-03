<?php

namespace App\Mail;

use App\Models\Shop\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserOrder extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Order $order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Номер заказа ' . $this->order->number)
            ->markdown('emails.orders.userOrder');
    }
}
