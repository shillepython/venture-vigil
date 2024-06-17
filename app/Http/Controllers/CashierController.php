<?php

namespace App\Http\Controllers;

use App\Models\Cashier;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier.list');
    }

    public function show($id)
    {
        $cashier = Cashier::find($id);
        if (!$cashier) {
            return redirect()->back();
        }
        return view('cashier.show', ['id' => $id]);
    }
}
