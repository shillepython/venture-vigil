<?php
namespace App\Livewire;

use App\Traits\LogsActivity;
use Livewire\Component;
use App\Models\User;
use App\Enum\UserSettings;
use App\Notifications\UserNotification;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;
    use LogsActivity;

    public $userId;
    public $first_name;
    public $last_name;
    public $phone;
    public $balance;
    public $successRate;
    public $minDeposit;
    public $taxCodeResetAmount;
    public $notification;
    public $settings = []; // Свойство для управления настройками
    public $editUserModal;
    public $hasSalesRole;
    public $salesUserId;
    public $salesUsers = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        $users = User::query();
        $users->role(['lid', 'admin']);

        $userSales = User::role('sales')->paginate(10);

        if (!auth()->user()->hasRole('admin')) {
            $users->where('sales_id', auth()->id());
        }

        return view('livewire.users-list', [
            'users' => $users->orderBy('created_at', 'desc')->paginate(10),
            'userSales' => $userSales,
        ]);
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
        $this->taxCodeResetAmount = $user->tax_code_reset_amount;
        $this->hasSalesRole = $user->hasRole('sales');

        $this->salesUsers = User::role('sales')->get();
        $this->salesUserId = $user->sales_id;
        // Заполнение значений настроек
        foreach (UserSettings::cases() as $setting) {
            $this->settings[$setting->value] = (bool) $user->getSetting($setting);
        }

        $this->editUserModal = true;
    }

    public function addSalesRole($userId)
    {
        $userAddedSales = User::find($userId);
        $userAddedSales->assignRole('sales');

        $this->logActivity('Added sales to user', $userAddedSales->toArray());
        $this->dispatch('refreshComponent');
    }

    public function closeEditUser()
    {
        $this->resetInputFields();
        $this->editUserModal = false;
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
        $this->taxCodeResetAmount = '';
        $this->settings = [];
        $this->salesUsers = [];
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'balance' => 'required|numeric',
            'successRate' => 'required',
            'minDeposit' => 'required|numeric',
            'taxCodeResetAmount' => 'required|numeric',
        ]);


        if ($this->userId) {
            $user = User::find($this->userId);

            $payloadLog = [$user->toArray()];

            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'balance' => $this->balance,
                'successRate' => $this->successRate,
                'min_deposit' => $this->minDeposit,
                'tax_code_reset_amount' => $this->taxCodeResetAmount,
                'sales_id' => !empty($this->salesUserId) ? $this->salesUserId : null,
            ]);

            $payloadLog[] = $user->toArray();

            $this->logActivity('Updated user', $payloadLog);

            if ($this->hasSalesRole && !$user->hasRole('sales')) {
                $user->assignRole('sales');
                $this->logActivity('Assign sales role', $user->toArray());
            }

            if (!$this->hasSalesRole && $user->hasRole('sales')) {
                $user->removeRole('sales');
                $this->logActivity('Remove sales role', $user->toArray());
                $usersForSales = User::where('sales_id', $user->id)->get();
                foreach ($usersForSales as $usersForSale) {
                    $usersForSale->sales_id = null;
                    $usersForSale->save();
                }
            }

            foreach ($this->settings as $key => $value) {
                $user->setSetting(UserSettings::from($key), $value ? 1 : 0);
            }
        }

        $this->closeEditUser();

        $this->dispatch('refreshComponent');
    }

    public function updatedSuccessRate()
    {
        if ($this->successRate > 100) {
            $this->successRate = 100;
            return;
        }

        if ($this->successRate < 0) {
            $this->successRate = 0;
        }
    }

    public function updatedMinDeposit()
    {
        if ($this->minDeposit > 1000) {
            $this->minDeposit = 1000;
            return;
        }

        if ($this->minDeposit < 100) {
            $this->minDeposit = 100;
        }
    }

    public function updatedTaxCodeResetAmount()
    {
        if ($this->taxCodeResetAmount > 10000) {
            $this->taxCodeResetAmount = 10000;
            return;
        }

        if ($this->taxCodeResetAmount < 100) {
            $this->taxCodeResetAmount = 100;
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
