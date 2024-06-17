<?php

namespace App\Livewire;

use App\Models\Orders;
use App\Models\User;
use Livewire\Component;

class Order extends Component
{
    public $orders;

    public function mount()
    {
        $this->orders = Orders::where(['status' => 1])->get();
    }

    public function sumbitAmmount($amount, $userId, $orderId)
    {
        $order = Orders::find($orderId);
        $user = User::find($userId);
        $user->balance += $amount;
        $user->save();

        $order->status = 2;
        $order->save();

        $this->reset();
    }

    public function render()
    {
        return view('livewire.order');
    }
}
