<?php
namespace App\Livewire;

use App\Models\User;
use App\Notifications\TransferUserNotification;
use App\Notifications\UserNotification;
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
        $user = User::find($sender->id);

        if ($sender->balance < $this->amount) {
            session()->flash('error', 'Недостаточно средств для перевода.');
            return;
        }

        $sender->balance -= $this->amount;
        $recipient->balance += $this->amount;

        $sender->save();
        $recipient->save();

        session()->flash('message', 'Перевод пользователю: ' . $this->email . ' успешно выполнен.');
        
        $messageToRecipient = 'Пользователь: ' . $sender->email . ' перевёл вам сумму: ' . $this->amount . ' USD';
        $recipient->notify(new TransferUserNotification($user, $messageToRecipient));

        $this->reset(['email', 'amount']);
    }

    public function render()
    {
        return view('livewire.transfer-funds-form');
    }
}
