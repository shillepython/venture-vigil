<?php
namespace App\Livewire;

use App\Models\OrdersWithdrawal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cashier extends Component
{

    public $balance;
    public $cashiers;
    public $amount;
    public $card;
    public $taxCode = null;
    public $taxCodeType;
    public $confirmingWithdrawal;
    public $disabledConfirmWithdrawal = false;
    public $correctTaxCode = '9yNGCS4AvW3';

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

    public function updatedTaxCode()
    {
        // Проверка введённого кода
        if ($this->taxCodeType && $this->taxCode !== $this->correctTaxCode) {
            $this->disabledConfirmWithdrawal = true;
        } else {
            $this->disabledConfirmWithdrawal = false;
        }
    }

    public function confirmWithdrawal()
    {
        $this->validate([
            'amount' => 'required|integer|min:10',
            'card' => 'required|integer|digits_between:16,20'
        ]);

        if ($this->taxCodeType && $this->taxCode !== $this->correctTaxCode) {
            session()->flash('error', __('Invalid tax code. Please enter the correct code.'));
            return;
        }

        if ($this->amount > $this->balance) {
            $this->amount = $this->balance;
        }

        OrdersWithdrawal::create([
            'user_id' => auth()->user()->id,
            'balance' => $this->balance,
            'amount' => $this->amount,
            'disbursement' => $this->card,
            'referral_code' => $this->taxCode
        ]);

        session()->flash('message', __('Withdrawal request successfully sent'));
        $this->confirmingWithdrawal = false;
    }

    public function mount()
    {
        $this->balance = auth()->user()->balance;
        $this->cashiers = \App\Models\Cashier::all();
        $this->taxCodeType = Auth::user()->getSettingByType(\App\Enum\UserSettings::REF_CODE);
        $this->disabledConfirmWithdrawal = $this->taxCodeType ? true : false;
    }

    public function render()
    {
        return view('livewire.cashier');
    }
}

