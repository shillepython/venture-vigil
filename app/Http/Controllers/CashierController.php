<?php

namespace App\Http\Controllers;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier.list');
    }

    public function show($id)
    {
        return view('cashier.show', ['id' => $id]);
    }
}
