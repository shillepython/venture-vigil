<?php

namespace App\Notifications;

use App\Models\OrdersWithdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WithdrawalStatusUpdated extends Notification
{
    use Queueable;

    protected $withdrawal;
    protected $reason;

    public function __construct(OrdersWithdrawal $withdrawal, $reason)
    {
        $this->withdrawal = $withdrawal;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'withdrawal_id' => $this->withdrawal->id,
            'status' => $this->withdrawal->status,
            'reason' => $this->reason,
        ];
    }
}
