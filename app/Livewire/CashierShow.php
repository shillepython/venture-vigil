<?php

namespace App\Livewire;

use Livewire\Component;

class CashierShow extends Component
{
    public $id;

    public function mount()
    {
        $cashier = \App\Models\Cashier::find($this->id) ?? '';
    }
    public function render()
    {
        return view('livewire.cashier-show');
    }
}
