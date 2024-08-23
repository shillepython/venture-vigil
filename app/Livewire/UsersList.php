<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Enum\UserSettings;
use App\Notifications\UserNotification;

class UsersList extends Component
{
    public $users;
    public $userId;
    public $first_name;
    public $last_name;
    public $phone;
    public $balance;
    public $successRate;
    public $minDeposit;
    public $notification;
    public $settings = []; // Свойство для управления настройками
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
        $this->successRate = $user->successRate;
        $this->minDeposit = $user->min_deposit;

        // Заполнение значений настроек
        foreach (UserSettings::cases() as $setting) {
            $this->settings[$setting->value] = (bool) $user->getSetting($setting);
        }

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
        $this->successRate = '';
        $this->minDeposit = '';
        $this->notification = '';
        $this->settings = []; // Сброс настроек
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'successRate' => 'required',
            'minDeposit' => 'required|numeric',
            'balance' => 'required|numeric',
        ]);

        if ($this->userId) {
            $user = User::find($this->userId);
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'balance' => $this->balance,
                'successRate' => $this->successRate,
                'min_deposit' => $this->minDeposit,
            ]);

            // Сохранение настроек
            foreach ($this->settings as $key => $value) {
                $user->setSetting(UserSettings::from($key), $value ? 1 : 0);
            }
        }

        $this->closeModal();

        $this->dispatch('refreshComponent');
    }

    public function updatedSuccessRate()
    {
        if ($this->successRate > 100) {
            $this->successRate = 100;
        }

        if ($this->successRate < 0) {
            $this->successRate = 0;
        }
    }

    public function updatedMinDeposit()
    {
        if ($this->minDeposit > 1000) {
            $this->minDeposit = 1000;
        }

        if ($this->minDeposit < 100) {
            $this->minDeposit = 100;
        }
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

        $this->notification = '';
        session()->flash('message', 'Уведомление отправлено.');
    }
}
