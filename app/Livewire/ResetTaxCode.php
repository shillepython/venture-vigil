<?php

namespace App\Livewire;

use App\Models\Orders;
use App\Models\ResetTaxCode as ResetTaxCodeModel;
use App\Models\User;
use Livewire\Component;

class ResetTaxCode extends Component
{
    public $resetTaxCodes;

    public function mount()
    {
        $this->resetTaxCodes = ResetTaxCodeModel::orderBy('created_at', 'desc')->get();
    }


    public function render()
    {
        return view('livewire.reset-tax-code');
    }
}
