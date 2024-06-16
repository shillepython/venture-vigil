<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Livewire\Component;

class Language extends Component
{

    public function changeLang($lang)
    {
        App::setLocale($lang);
        session(['language' => $lang]);
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        return view('livewire.language');
    }
}
