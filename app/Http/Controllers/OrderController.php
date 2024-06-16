<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OrderController extends Controller
{
    public function index()
    {
        App::setLocale('en');
        return view('orders.list');
    }
}
