<?php

namespace App\Livewire;

use App\Models\Orders;
use App\Models\User;
use App\Traits\LogsActivity;
use Livewire\Component;
use Livewire\WithPagination;

class Order extends Component
{
    use WithPagination;
    use LogsActivity;

    public function sumbitAmmount($amount, $userId, $orderId)
    {
        $order = Orders::find($orderId);
        $user = User::find($userId);
        $user->balance += round($amount, 2);
        $user->save();

        $order->status = 2;
        $order->save();

        $this->logActivity('Submit withdrawal amount', $order->toArray());
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
