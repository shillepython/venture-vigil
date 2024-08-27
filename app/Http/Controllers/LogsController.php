<?php

namespace App\Http\Controllers;


class LogsController extends Controller
{
    public function list()
    {
        return view('logs.list');
    }
}
