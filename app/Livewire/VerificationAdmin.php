<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Verification;
use App\Traits\LogsActivity;
use Livewire\Component;

class VerificationAdmin extends Component
{
    use LogsActivity;

    public function sumbitVerification($verificationId)
    {
        $verification = Verification::find($verificationId);
        $verification->status = 1;
        $verification->save();

        $this->logActivity('Submit verification', $verification->toArray());
        $this->reset();
    }
    public function render()
    {
        $currentUser = auth()->user();
        $verificationList = Verification::query();
        $verificationList->where('status', 0);

        if (!auth()->user()->hasRole('admin')) {
            $assignedUserIds = User::where('sales_id', $currentUser->id)->pluck('id');
            $assignedUserIds->push($currentUser->id);
            $verificationList->whereIn('user_id', $assignedUserIds);
        }

        return view('livewire.verification-admin', [
            'verificationList' => $verificationList->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
