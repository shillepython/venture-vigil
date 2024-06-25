<?php

namespace App\Livewire;

use Dasundev\LivewireDropzone\Http\Livewire\Dropzone as BaseDropzone;

class CustomDropzone extends BaseDropzone
{
    public string $label;

    public function mount(array $rules = ['mimes:png,jpg,jpeg,svg,gif', 'max:10420'], bool $multiple = false, string $label = 'Upload files'): void
    {
        parent::mount($rules, $multiple);
        $this->label = $label;
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.custom-dropzone');
    }
}
