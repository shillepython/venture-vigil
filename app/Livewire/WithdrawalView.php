<?php

namespace App\Livewire;

use App\Models\ResetTaxCode as ResetTaxCodeModel;
use App\Traits\LogsActivity;
use Livewire\Component;

use Livewire\WithPagination;
use App\Models\OrdersWithdrawal;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WithdrawalStatusUpdated;

class WithdrawalView extends Component
{
    use WithPagination;
    use LogsActivity;

    public $reason;
    public $withdrawalId;
    public $statusUpdate;
    public $confirmingAction = false;

    protected $rules = [
        'reason' => 'nullable|string|max:255',
    ];

    public function render()
    {
        $currentUser = auth()->user();
        $withdrawals = OrdersWithdrawal::query();
        $withdrawals->where('status', 0);

        if (!auth()->user()->hasRole('admin')) {
            $assignedUserIds = User::where('sales_id', $currentUser->id)->pluck('id');
            $assignedUserIds->push($currentUser->id);
            $withdrawals->whereIn('user_id', $assignedUserIds);
        }

        return view('livewire.withdrawal-view', [
            'withdrawals' => $withdrawals->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }

    public function confirmAction($id, $status)
    {
        $this->withdrawalId = $id;
        $this->statusUpdate = $status;
        $this->confirmingAction = true;
    }

    public function updateWithdrawal()
    {
        $this->validate();

        $withdrawal = OrdersWithdrawal::findOrFail($this->withdrawalId);
        $user = User::find($withdrawal->user_id);

        if ($this->statusUpdate == 2 && empty($this->reason)) {
            $this->reason = "Для вывода средств необходимо пополнить баланс на бирже";
        }

        if ($this->statusUpdate == 1) {
            $this->reason = "Ваш запрос на вывод одобрен, ожидайте поступлений!";

            $user->balance = $user->balance - $withdrawal->amount;
            if ($user->balance < 0) {
                $user->balance = 0;
            }
            $user->save();
        }

        $withdrawal->status = $this->statusUpdate;
        $withdrawal->save();


        $user->notify(new WithdrawalStatusUpdated($withdrawal, $this->reason));

        $this->logActivity('Submit withdrawal', $withdrawal->toArray());

        $this->confirmingAction = false;
        $this->reset(['reason', 'withdrawalId', 'statusUpdate']);
        session()->flash('message', 'Статус запроса успешно обновлён.');
    }

    public function delete($withdrawalId)
    {
        $ordersWithdrawal = OrdersWithdrawal::find($withdrawalId);
        $payload = $ordersWithdrawal->toArray();
        $ordersWithdrawal->delete();

        $this->logActivity('Delete withdrawal', $payload);

        $this->reset(['reason', 'withdrawalId', 'statusUpdate']);
    }
}
