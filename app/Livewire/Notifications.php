<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Notifications\DatabaseNotification;

class Notifications extends Component
{
    public $showNotifications = false;

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function toggleNotifications()
    {
        $this->showNotifications = !$this->showNotifications;
    }

    public function deleteNotification($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->delete();

        $this->dispatch('refreshNotifications');
    }

    public function render()
    {
        return view('livewire.notifications', [
            'notifications' => auth()->user()->notifications()->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
