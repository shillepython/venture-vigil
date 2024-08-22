<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Notifications\UserNotification;

class UsersList extends Component
{
    public $users;
    public $userId;
    public $first_name;
    public $last_name;
    public $phone;
    public $balance;
    public $notification; // Свойство для текста уведомления
    public $isModalOpen = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        $this->users = User::all();
        return view('livewire.users-list');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->phone = $user->phone;
        $this->balance = $user->balance;

        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->phone = '';
        $this->balance = '';
        $this->notification = ''; // Сброс текста уведомления
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'balance' => 'required|numeric',
        ]);

        if ($this->userId) {
            $user = User::find($this->userId);
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'balance' => $this->balance,
            ]);
        }

        $this->closeModal();

        $this->dispatch('refreshComponent');
    }

    public function sendNotification()
    {
        $this->validate([
            'notification' => 'required|string|max:255',
        ]);

        if ($this->userId) {
            $user = User::find($this->userId);
            $user->notify(new UserNotification($this->notification));
        }

        $this->notification = ''; // Сброс текста уведомления
        session()->flash('message', 'Уведомление отправлено.');
    }
}
