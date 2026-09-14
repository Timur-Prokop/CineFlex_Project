<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = DB::table('films')->get();

        return view('films', [
            'films' => $films
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Film $film)
    {
        //
    }

    public function edit(Film $film)
    {
        //
    }

    public function update(Request $request, Film $film)
    {
        //
    }

    public function destroy(Film $film)
    {
        //
    }
}
