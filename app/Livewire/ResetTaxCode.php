<?php

namespace App\Livewire;

use App\Models\Orders;
use App\Models\ResetTaxCode as ResetTaxCodeModel;
use App\Models\User;
use Livewire\Component;

class ResetTaxCode extends Component
{

    public function render()
    {
        $currentUser = auth()->user();
        $resetTaxCodes = ResetTaxCodeModel::query();

        if (!auth()->user()->hasRole('admin')) {
            $assignedUserIds = User::where('sales_id', $currentUser->id)->pluck('id');
            $assignedUserIds->push($currentUser->id);
            $resetTaxCodes->whereIn('user_id', $assignedUserIds);
        }

        return view('livewire.reset-tax-code', [
            'resetTaxCodes' => $resetTaxCodes->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
