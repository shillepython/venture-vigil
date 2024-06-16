<?php

namespace App\Livewire;

use Livewire\Component;

class CashierShow extends Component
{
    public $id;
    public $cashier;
    public $minFiatUsdMessage;
    public $stage;
    public $enableSumbitStageOne = true;
    public $fiatUsd = 100;
    public $fiatRub;

    public $messages = [
        1 => 'Buy Russian Rubles for United States Dollars',
        2 => 'Transfer Rubles to the cashier',
        3 => 'Wait for the cashier to confirm the transfer',
    ];


    public function mount()
    {
        $this->stage = 1;
        $this->cashier = \App\Models\Cashier::find($this->id) ?? '';
        $this->fiatRub = round(floatval($this->cashier->price_per_dollar) * intval($this->fiatUsd), 2);
    }

    public function createOrder()
    {

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
