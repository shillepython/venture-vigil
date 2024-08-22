<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TransferUserNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $reason;

    public function __construct(User $user, $reason)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'transfer_user_id' => $this->user->id,
            'reason' => $this->reason,
        ];
    }
}
