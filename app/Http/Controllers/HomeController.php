<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $films = DB::table('films')
            ->orderBy('id', 'desc')
            ->limit(4)
            ->get();

        return view('home', [
            'films' => $films
        ]);
    }
}
