<?php

namespace App\Livewire;

use App\Models\ActivityLogs;
use Livewire\Component;

class Logs extends Component
{
    public function render()
    {
        $activityLogs = ActivityLogs::orderBy('created_at', 'desc')->paginate(50);

        return view('livewire.logs', [
            'activityLogs' => $activityLogs
        ]);
    }
}
