<?php

namespace App\Livewire;

use Livewire\Component;

class Cashier extends Component
{

    public $balance;
    public $cashiers;

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
