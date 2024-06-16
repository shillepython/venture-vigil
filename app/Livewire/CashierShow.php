<?php

namespace App\Livewire;

use Livewire\Component;

class CashierShow extends Component
{
    public $id;
    public $cashier;
    public $fiatUsd = 100;

    public function mount()
    {
        $this->cashier = \App\Models\Cashier::find($this->id) ?? '';
    }

    public function createOrder()
    {

    }

    public function setUsd($fiat)
    {
        $this->fiatUsd = $fiat;
    }

    public function render()
    {
        return view('livewire.cashier-show');
    }
}
