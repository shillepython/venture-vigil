<?php

namespace App\Livewire;

use App\Models\Verification;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nette\Utils\Random;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VerificationForm extends Component
{

    use WithFileUploads;
    public $isVerified;
    public $verifiedStatus;

    public $passportFront = [];
    public $passportBack = [];
    public $proofOfAddress = [];

    protected $listeners = ['fileUploaded'];

    public function submit()
    {
        if (empty($this->passportFront) || empty($this->passportBack) || empty($this->proofOfAddress)) {
            $this->validate([
                'passportFront' => 'required',
                'passportBack' => 'required',
                'proofOfAddress' => 'required',
            ]);
            return;
        }

        $userId = auth()->user()->id;
        $path = Random::generate(20) . '_' . $userId . '_';

        $passportFront = new File($this->passportFront[0]['path']);
        $passportFrontPath = $path . 'passportFront.' . $passportFront->getExtension();
        Storage::putFileAs('public/verification', $passportFront, $passportFrontPath);

        $passportBack = new File($this->passportBack[0]['path']);
        $passportBackPath = $path . 'passportBack.' . $passportBack->getExtension();
        Storage::putFileAs('public/verification', $passportBack, $passportBackPath);

        $proofOfAddress = new File($this->proofOfAddress[0]['path']);
        $proofOfAddressPath = $path . 'proofOfAddress.' . $passportFront->getExtension();
        Storage::putFileAs('public/verification', $proofOfAddress, $proofOfAddressPath);

        Verification::create([
            'user_id' => auth()->user()->id,
            'front_passport' => '/storage/verification/' . $passportFrontPath,
            'back_passport' => '/storage/verification/' . $passportBackPath,
            'billing' => '/storage/verification/' . $proofOfAddressPath,
        ]);
        $this->isVerified = true;

        session()->flash('message', 'Documents uploaded successfully.');
    }
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

    public function render()
    {
        return view('profile.verification-form');
    }
}
