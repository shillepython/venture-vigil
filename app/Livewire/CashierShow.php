<?php

namespace App\Livewire;

use App\Models\Orders;
use Livewire\Component;
use Livewire\Attributes\On;

class CashierShow extends Component
{
    public $id;
    public $cashier;
    public $minFiatUsdMessage;
    public $currentStep;
    public $enableSumbitStageOne = true;
    public $fiatUsd = 100;
    public $fiatRub;
    public $order;
    public $timer;
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
        if (isset($order)) {
            $this->currentStep = 2;
            $this->order = $order;

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

        $this->timer = $this->defaultTimeOrder - (time() - strtotime($this->order->created_at));
        $this->dispatch('start-timer');
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
        $this->fiatUsd = $fiat;
        $this->updatedFiatUsd();
    }

    public function render()
    {
        return view('livewire.cashier-show');
    }
}
