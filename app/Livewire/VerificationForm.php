<?php

namespace App\Livewire;

use App\Models\Verification;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;

class VerificationForm extends Component
{

    use WithFileUploads;
    public $isVerified;
    public $verifiedStatus;

    public $passportFrontImage;
    public $passportFrontImageView;
    public $passportBackImage;
    public $passportBackImageView;
    public $proofOfAddress;
    public $proofOfAddressView;

    public function mount()
    {
        $verificationModel = Verification::where(['user_id' => auth()->user()->id])->first();
        if ($verificationModel && $verificationModel->status == 1) {
            $this->isVerified = true;
            $this->verifiedStatus = true;
            return;
        }

        if ($verificationModel) {
            $this->isVerified = true;
            $this->verifiedStatus = false;
            return;
        }

        $this->isVerified = false;
        $this->verifiedStatus = false;
    }

    public function updatedPassportFrontImage()
    {
        $this->validate([
            'passportFrontImage' => 'mimes:svg,jpg,jpeg,gif,png',
        ]);

        $originalName = Str::random(40) . $this->passportFrontImage->getClientOriginalName();
        $this->passportFrontImage->storeAs('verification', $originalName, 'public');
        $this->passportFrontImageView = '/storage/verification/' . $originalName;
    }

    public function updatedPassportBackImage()
    {
        $this->validate([
            'passportBackImage' => 'mimes:svg,jpg,jpeg,gif,png',
        ]);

        $originalName = Str::random(40) . $this->passportBackImage->getClientOriginalName();
        $this->passportBackImage->storeAs('verification', $originalName, 'public');
        $this->passportBackImageView = '/storage/verification/' . $originalName;
    }

    public function updatedProofOfAddress()
    {
        $this->validate([
            'proofOfAddress' => 'mimes:svg,jpg,jpeg,gif,png,pdf',
        ]);

        $originalName = Str::random(40) . $this->proofOfAddress->getClientOriginalName();
        $this->proofOfAddress->storeAs('verification', $originalName, 'public');
        $this->proofOfAddressView = '/storage/verification/' . $originalName;;
    }

    public function saveKYC()
    {
        Verification::create([
            'user_id' => auth()->user()->id,
            'front_passport' => $this->passportFrontImageView,
            'back_passport' => $this->passportBackImageView,
            'billing' => $this->proofOfAddressView,
        ]);
        $this->isVerified = true;
    }
    public function render()
    {
        return view('profile.verification-form');
    }
}
