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

    public $passportFront;
    public $passportBack;
    public $proofOfAddress;

    protected $listeners = ['fileUploaded'];

    public function updatedPassportFront()
    {
//        dd('123');
        $this->validateOnly('passportFront', [
            'passportFront' => 'image|mimes:png,jpg,jpeg|max:10240',
        ]);
    }

    public function updatedPassportBack()
    {
        $this->validateOnly('passportBack', [
            'passportBack' => 'image|mimes:png,jpg,jpeg|max:10240',
        ]);
    }

    public function updatedProofOfAddress()
    {
        $this->validateOnly('proofOfAddress', [
            'proofOfAddress' => 'file|mimes:png,jpg,jpeg,pdf|max:10240',
        ]);
    }

    public function submit()
    {
//        dd($this->passportFront, $this->passportBack, $this->proofOfAddress);
//        $this->validate([
//            'passportFront' => 'mimes:png,jpg,jpeg|max:10240',
//            'passportBack' => 'mimes:png,jpg,jpeg|max:10240',
//            'proofOfAddress' => 'mimes:png,jpg,jpeg|max:10240',
//        ]);

        $paths = [
            'passport_front' => $this->passportFront->store('verification', 'public'),
            'passport_back' => $this->passportBack->store('verification', 'public'),
            'proof_of_address' => $this->proofOfAddress->store('verification', 'public'),
        ];

        // Here you can save the paths to your database if needed

        session()->flash('message', 'Documents uploaded successfully.');
    }



    public function mount()
    {
//        $verificationModel = Verification::where(['user_id' => auth()->user()->id])->first();
//        if ($verificationModel && $verificationModel->status == 1) {
//            $this->isVerified = true;
//            $this->verifiedStatus = true;
//            return;
//        }
//
//        if ($verificationModel) {
//            $this->isVerified = true;
//            $this->verifiedStatus = false;
//            return;
//        }
//
//        $this->isVerified = false;
//        $this->verifiedStatus = false;
    }

//    public function updatedPassportFrontImage()
//    {
////        $this->validate([
////            'passportFrontImage' => 'mimes:svg,jpg,jpeg,gif,png',
////        ]);
//
//        $originalName = Str::random(40) . $this->passportFrontImage->getClientOriginalName();
//        $this->passportFrontImage->storeAs('verification', $originalName, 'public');
//        $this->passportFrontImageView = '/storage/verification/' . $originalName;
//
//        $this->files['passportFront'] = [
//            'name' => $originalName,
//            'temporaryUrl' => $this->passportFrontImage->temporaryUrl(),
//            'size' => $this->passportFrontImage->getSize(),
//            'extension' => $this->passportFrontImage->getClientOriginalExtension(),
//        ];
//    }

//    public function updatedPassportBackImage()
//    {
//        $this->validate([
//            'passportBackImage' => 'mimes:svg,jpg,jpeg,gif,png',
//        ]);
//
//        $originalName = Str::random(40) . $this->passportBackImage->getClientOriginalName();
//        $this->passportBackImage->storeAs('verification', $originalName, 'public');
//        $this->passportBackImageView = '/storage/verification/' . $originalName;
//
//        $this->files['passportBack'] = [
//            'name' => $originalName,
//            'temporaryUrl' => $this->passportBackImage->temporaryUrl(),
//            'size' => $this->passportBackImage->getSize(),
//            'extension' => $this->passportBackImage->getClientOriginalExtension(),
//        ];
//    }

//    public function updatedProofOfAddress()
//    {
//        $this->validate([
//            'proofOfAddress' => 'mimes:svg,jpg,jpeg,gif,png,pdf',
//        ]);
//
//        $originalName = Str::random(40) . $this->proofOfAddress->getClientOriginalName();
//        $this->proofOfAddress->storeAs('verification', $originalName, 'public');
//        $this->proofOfAddressView = '/storage/verification/' . $originalName;
//
//        $this->files['proofOfAddress'] = [
//            'name' => $originalName,
//            'temporaryUrl' => $this->proofOfAddress->temporaryUrl(),
//            'size' => $this->proofOfAddress->getSize(),
//            'extension' => $this->proofOfAddress->getClientOriginalExtension(),
//        ];
//    }

//    public function saveKYC()
//    {
//        $this->validate([
//            'passportFrontImage' => 'required',
//            'passportBackImage' => 'required',
//            'proofOfAddress' => 'required',
//        ]);
//        Verification::create([
//            'user_id' => auth()->user()->id,
//            'front_passport' => $this->passportFrontImageView,
//            'back_passport' => $this->passportBackImageView,
//            'billing' => $this->proofOfAddressView,
//        ]);
//        $this->isVerified = true;
//
//        $this->files = [];
//    }

//    public function removeUpload($key)
//    {
//        unset($this->files[$key]);
//    }
    public function render()
    {
        return view('profile.verification-form');
    }
}
