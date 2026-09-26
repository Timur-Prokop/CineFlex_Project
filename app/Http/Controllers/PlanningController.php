<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PlanningController extends Controller
{
    public function show(){
        $films = DB::table('screenings')
            ->join('films', 'films.id', '=', 'screenings.film_id')
            ->join('auditories', 'auditories.id', '=', 'screenings.fk_auditories')
            ->select('films.*', 'screenings.*', 'auditories.*')
            ->get();

        return view('planning.timetable', [
            'films' => $films
        ]);

    }
}
