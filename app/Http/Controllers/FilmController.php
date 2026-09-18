<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = DB::table('films')
            ->join('age_groups', 'films.fk_id_age_group', '=', 'age_groups.id')
            ->select('films.*', 'age_groups.pic_path as age_group_pic',
                             'age_groups.age as age_group')
            ->get();

        $warnings = DB::table('films_warnings')
            ->join(
                'warnings',
                'films_warnings.fk_id_warning',
                '=',
                'warnings.id'
            )
            ->select(
                'films_warnings.fk_id_film',
                'warnings.id',
                'warnings.name',
                'warnings.pic_path'
            )
            ->get()
            ->groupBy('fk_id_film');

        return view('films.films', [
            'films' => $films,
            'warnings' => $warnings
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $this->authorize('create', Film::class);

        $validated = $request->validate([
                'title' => 'required',
                'duration' => ['required', 'integer', 'min:25', 'max:400'],
                'age-group' => 'required',
                'pic-path' => ['required', 'string'],
                'page-pic-path' => ['reqired', 'string'],
                'description' => ['required', 'min:50', 'max:1000']
            ],
            [
                'title.required' => 'Voeg een titel van de film toe.',
                'duration.required' => 'Wat is de lengte van de film?',
                'age-group.required' => 'Kies een leeftijdskijkwijzer voor de film.',
                'pic-path.required' => 'Voeg een afbeelding toe.',
                'page-pic-path.required' => 'Voeg een afbeelding toe.',
                'description.required' => 'Voeg een beschrijving.',
            ]
        );

        $film = Film::create([
           ''
        ]);

        return redirect('/films');
    }

    public function new(){
        return view('films.add_film');
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
