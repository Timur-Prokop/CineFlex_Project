<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function show () {
        return view('auth.reset-password');
    }

    public function store () {

    }
}
