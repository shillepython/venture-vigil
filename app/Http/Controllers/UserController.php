<?php

namespace App\Http\Controllers;

use App\Models\CallBackForm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list()
    {
        return view('users.list');
    }

    public function callbackForm(Request $request)
    {
        $callBackForm = CallBackForm::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone' => $request['phone'],
        ]);

        $callBackForm->notify(new \App\Notifications\CallBackForm());

        return true;
    }
}
