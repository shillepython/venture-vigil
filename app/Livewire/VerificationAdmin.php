<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Verification;
use Livewire\Component;

class VerificationAdmin extends Component
{
    public $verificationList;

    public function mount()
    {
        $this->verificationList = Verification::where(['status' => 0])->orderBy('created_at', 'desc')->get();
    }

    public function sumbitVerification($verificationId)
    {
        $verification = Verification::find($verificationId);
        $verification->status = 1;
        $verification->save();

        $this->reset();
        $this->verificationList = Verification::where(['status' => 0])->orderBy('created_at', 'desc')->get();
    }
    public function render()
    {
        return view('livewire.verification-admin');
    }
}
