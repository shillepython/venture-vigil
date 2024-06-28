<?php

namespace App\Livewire;

use App\Models\OrdersWithdrawal;
use Livewire\Component;

class Cashier extends Component
{

    public $balance;
    public $cashiers;
    public $amount;
    public $card;
    public $confirmingWithdrawal;

    public function openWithdrawal()
    {
        $this->confirmingWithdrawal = true;
    }
    public function cancelOpenWithdrawal()
    {
        $this->confirmingWithdrawal = false;
    }
    public function updatedAmount()
    {
        if ($this->amount > $this->balance) {
            $this->amount = $this->balance;
        }
    }

    public function confirmWithdrawal()
    {
        $this->validate([
            'amount' => 'required|integer|min:10',
            'card' => 'required|integer|digits_between:16,20'
        ]);

        if ($this->amount > $this->balance) {
            $this->amount = $this->balance;
        }

        OrdersWithdrawal::create([
            'user_id' => auth()->user()->id,
            'balance' => $this->balance,
            'amount' => $this->amount,
            'disbursement' => $this->card
        ]);

        session()->flash('message', __('Withdrawal request successfully sent'));
        $this->confirmingWithdrawal = false;
    }

    public function mount()
    {
        $this->balance = auth()->user()->balance;
        $this->cashiers = \App\Models\Cashier::all();
    }
    public function render()
    {
        return view('livewire.cashier');
    }
}
