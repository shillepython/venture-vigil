<?php

namespace App\Http\Controllers;


class WithdrawalController extends Controller
{
    public function list()
    {
        return view('withdrawal.list');
    }
}
