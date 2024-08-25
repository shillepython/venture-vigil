<?php

namespace App\Livewire;

use App\Models\Orders;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Order extends Component
{
    use WithPagination;

    public function sumbitAmmount($amount, $userId, $orderId)
    {
        $order = Orders::find($orderId);
        $user = User::find($userId);
        $user->balance += round($amount, 2);
        $user->save();

        $order->status = 2;
        $order->save();

        $this->reset();
    }

    public function render()
    {
        $currentUser = auth()->user();
        $orders = Orders::query();
        $orders->where('status', 1);

        if (!auth()->user()->hasRole('admin')) {
            $assignedUserIds = User::where('sales_id', $currentUser->id)->pluck('id');
            $assignedUserIds->push($currentUser->id);
            $orders->whereIn('user_id', $assignedUserIds);
        }

        return view('livewire.order', [
            'orders' => $orders->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
