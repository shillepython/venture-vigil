<?php
namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransferFundsForm extends Component
{
    public $email;
    public $amount;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'amount' => 'required|numeric|min:0.01',
    ];

    public function submit()
    {
        $this->validate();

        $recipient = User::where('email', $this->email)->first();
        $sender = Auth::user();

        if ($sender->balance < $this->amount) {
            session()->flash('error', 'Недостаточно средств для перевода.');
            return;
        }

        $sender->balance -= $this->amount;
        $recipient->balance += $this->amount;

        $sender->save();
        $recipient->save();

        session()->flash('message', 'Перевод пользователю: ' . $this->email . ' успешно выполнен.');
        $this->reset(['email', 'amount']);
    }

    public function render()
    {
        return view('livewire.transfer-funds-form');
    }
}
