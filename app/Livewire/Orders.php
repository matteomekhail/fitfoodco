<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderDeliveredMail; // Assumi che questa sia la tua classe Mail per le email di consegna

class Orders extends Component
{
    public $orders;

    public function mount()
    {
        $this->loadOrders();
    }

    public function setCooked($orderProductId)
    {
        $orderProduct = OrderProduct::find($orderProductId);
        $orderProduct->is_cooked = !$orderProduct->is_cooked;
        $orderProduct->save();
        $this->loadOrders();
    }

    public function setDelivered($orderProductId)
    {
        $orderProduct = OrderProduct::find($orderProductId);
        $orderProduct->is_delivered = !$orderProduct->is_delivered;
        $orderProduct->save();

        if ($orderProduct->is_delivered) {
            Mail::to($orderProduct->order->user->email)->send(new OrderDeliveredMail());
        }
        $this->loadOrders();
    }

    public function setAllCooked($orderId)
    {
        $order = Order::find($orderId);
        foreach ($order->orderProducts as $orderProduct) {
            $orderProduct->is_cooked = true;
            $orderProduct->save();
        }
        $this->loadOrders();
    }

    public function setAllUncooked($orderId)
    {
        $order = Order::find($orderId);
        foreach ($order->orderProducts as $orderProduct) {
            $orderProduct->is_cooked = false;
            $orderProduct->save();
        }
        $this->loadOrders();
    }

    public function setAllDelivered($orderId)
    {
        $order = Order::find($orderId);
        foreach ($order->orderProducts as $orderProduct) {
            $orderProduct->is_delivered = true;
            $orderProduct->save();
        }

        Mail::to($order->user->email)->send(new OrderDeliveredMail());
        $this->loadOrders();
    }

    public function setAllUndelivered($orderId)
    {
        $order = Order::find($orderId);
        foreach ($order->orderProducts as $orderProduct) {
            $orderProduct->is_delivered = false;
            $orderProduct->save();
        }
        $this->loadOrders();
    }

    private function loadOrders()
    {
        $this->orders = Order::with(['user', 'orderProducts.product', 'address'])
            ->orderBy('created_at', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.orders', [
            'orders' => $this->orders,
        ]);
    }
}
