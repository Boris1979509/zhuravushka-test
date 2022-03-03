<?php

namespace App\Mail;

use App\Models\Shop\Order;
use App\UseCases\Table\TextTable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Order $order
     */
    public $order;
    /**
     * @var TextTable $table
     */
    public $table;
    /**
     * @var array $data
     */
    public $data;

    /**
     * OrderShipped constructor.
     * @param array $data
     * @param Order $order
     */

    public function __construct(array $data, Order $order)
    {
        $this->order = $order;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->table = new TextTable($this->data['columns'], $this->data['data'], array_fill(0, 4, 'L'));
        return $this->subject('Ваш заказ ' . $this->order->number)
            ->markdown('emails.orders.shipped');
    }
}
