<?php

namespace App\Livewire;

use Livewire\Component;
class VerificationForm extends Component
{
    public $isVerified = false;
    public function render()
    {
        return view('profile.verification-form');
    }
}
