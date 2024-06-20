<?php

namespace App\Livewire;

use App\Models\Orders;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class CashierShow extends Component
{
    use WithFileUploads;

    public $id;
    public $cashier;

    public $check;
    public $minFiatUsdMessage;
    public $currentStep;
    public $enableSumbitStageOne = true;
    public $fiatUsd = 100;
    public $fiatRub;
    public $order;
    public $timer;
    public $paymentSuccess = false;
    public $defaultTimeOrder = 900;

    public $messages = [
        1 => 'all.buy_usd_to_rub',
        2 => 'all.transfer_rub_to_cashier',
        3 => 'all.wait_submit_transfer',
    ];

    public function mount()
    {
        $order = Orders::where(['user_id' => auth()->user()->id, 'status' => 0])->first();
        $this->cashier = \App\Models\Cashier::find($this->id) ?? '';

        if (isset($order) && ($this->defaultTimeOrder - (time() - strtotime($order->created_at))) <= 0) {
            $order->delete();
            $this->currentStep = 1;
            $this->fiatRub = round(floatval($this->cashier->price_per_dollar) * intval($this->fiatUsd), 2);
            return;
        }

        if (isset($order)) {
            $this->currentStep = 2;
            $this->order = $order;
            $this->enableSumbitStageOne = false;
            $this->fiatRub = round($this->order->amount, 2);
            $this->timer = $this->defaultTimeOrder - (time() - strtotime($this->order->created_at));
            $this->dispatch('start-timer');
            return;
        }
        $this->currentStep = 1;
        $this->fiatRub = round(floatval($this->cashier->price_per_dollar) * intval($this->fiatUsd), 2);
    }

    public function createOrder()
    {
        $this->order = Orders::create([
            'user_id'=> auth()->user()->id,
            'cashier_id' => $this->cashier->id,
            'amount' => $this->fiatRub,
        ]);
        $this->currentStep = 2;

        $this->enableSumbitStageOne = false;
        $this->timer = $this->defaultTimeOrder - (time() - strtotime($this->order->created_at));
        $this->dispatch('start-timer');
    }

    public function submitPayment()
    {
        $this->order->status = 1;
        $this->order->save();
        $this->paymentSuccess = true;
        $this->currentStep = 3;
        $this->dispatch('delete-timer');
    }

    public function resetForm()
    {
        return redirect(request()->header('Referer'));
    }

    #[On('stop-timer')]
    public function stopTimer()
    {
        dd('123');
    }

    public function updatedFiatUsd()
    {
        $this->minFiatUsdMessage = '';
        $this->enableSumbitStageOne = true;
        if ($this->fiatUsd < 100) {
            $this->minFiatUsdMessage = 'USD purchase amount must be at least 100';
            $this->enableSumbitStageOne = false;
            return;
        }
        $this->fiatRub = round(floatval($this->cashier->price_per_dollar) * intval($this->fiatUsd), 2);
    }

    public function updatedFiatRub()
    {
        $this->minFiatUsdMessage = '';
        $this->enableSumbitStageOne = true;
        if ($this->fiatRub < 1) {
            $this->fiatRub = 1;
        }

        $this->fiatUsd = round(intval($this->fiatRub) / floatval($this->cashier->price_per_dollar), 2);
        if ($this->fiatUsd < 100) {
            $this->minFiatUsdMessage = 'USD purchase amount must be at least 100';
            $this->enableSumbitStageOne = false;
        }
    }

    public function setUsd($fiat)
    {
        $this->fiatUsd = round($fiat, 2);
        $this->updatedFiatUsd();
    }

    public function updatedCheck()
    {
        $this->validate([
            'check' => 'mimes:svg,jpg,jpeg,gif,png,pdf',
        ]);

        $originalName = Str::random(40) . $this->check->getClientOriginalName();
        $this->check->storeAs('orders', $originalName, 'public');
        $this->order->check = '/storage/orders/' . $originalName;
        $this->order->save();

        $this->enableSumbitStageOne = true;
    }

    public function render()
    {
        return view('livewire.cashier-show');
    }
}
