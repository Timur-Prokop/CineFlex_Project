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
//        $this->authorize('create', Film::class);

        $validated = $request->validate(
            [
                'title' => ['required', 'string'],
                'duration' => ['required', 'integer', 'min:25', 'max:400'],
                'fk_id_age_group' => ['required', 'integer'],
                'pic_path' => ['required', 'string'],
                'page_pic_path' => ['required', 'string'],
                'description' => ['required', 'string', 'min:50', 'max:1000'],
                'warnings' => ['required', 'array'],
                'warnings.*' => ['integer'],
            ],
            [
                'title.required' => 'Voeg een titel van de film toe.',
                'duration.required' => 'Wat is de lengte van de film?',
                'fk_id_age_group.required' => 'Kies een leeftijdskijkwijzer voor de film.',
                'pic_path.required' => 'Voeg een afbeelding toe.',
                'page_pic_path.required' => 'Voeg een afbeelding toe.',
                'description.required' => 'Voeg een beschrijving toe.',
                'warnings.required' => 'Kies minimaal één kijkwijzer.',
            ]
        );

        $film = Film::create([
            'title' => $validated['title'],
            'duration' => $validated['duration'],
            'fk_id_age_group' => $validated['fk_id_age_group'],
            'pic_path' => $validated['pic_path'],
            'page_pic_path' => $validated['page_pic_path'],
            'description' => $validated['description'],
        ]);

        foreach ($validated['warnings'] as $warningId) {
            DB::table('films_warnings')->insert([
                'fk_id_film' => $film->id,
                'fk_id_warning' => $warningId,
            ]);
        }
        return redirect('/films');
    }



    public function new(){
        $warnings = DB::table('warnings')->get();
        $age_groups = DB::table('age_groups')->get();

        return view('films.add_film', [
            'warnings' => $warnings,
            'age_groups' => $age_groups
        ]);
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
        $this->authorize('update', $film);

        $age_groups = DB::table('age_groups')->get();

        $warnings = DB::table('warnings')->get();

        $filmWarnings = DB::table('films_warnings')
            ->where('fk_id_film', $film->id)
            ->pluck('fk_id_warning');

        return view('films.edit_film', [
            'film' => $film,
            'age_groups' => $age_groups,
            'warnings' => $warnings,
            'filmWarnings' => $filmWarnings,
        ]);
    }

    public function update(
        Request $request,
        Film $film
    ): RedirectResponse
    {
        $this->authorize('update', $film);

        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'string'
                ],

                'duration' => [
                    'required',
                    'integer',
                    'min:25',
                    'max:400'
                ],

                'fk_id_age_group' => [
                    'required',
                    'integer'
                ],

                'pic_path' => [
                    'required',
                    'string'
                ],

                'page_pic_path' => [
                    'required',
                    'string'
                ],

                'description' => [
                    'required',
                    'string',
                    'min:50',
                    'max:1000'
                ],

                'warnings' => [
                    'required',
                    'array'
                ],

                'warnings.*' => [
                    'integer'
                ],
            ],
            [
                'title.required'
                => 'Voeg een titel van de film toe.',

                'duration.required'
                => 'Wat is de lengte van de film?',

                'fk_id_age_group.required'
                => 'Kies een leeftijdsgroep.',

                'pic_path.required'
                => 'Voeg een afbeelding toe.',

                'page_pic_path.required'
                => 'Voeg een afbeelding toe.',

                'description.required'
                => 'Voeg een beschrijving toe.',

                'warnings.required'
                => 'Kies minimaal één kijkwijzer.',
            ]
        );


        $film->update([
            'title' => $validated['title'],

            'duration' => $validated['duration'],

            'fk_id_age_group' =>
                $validated['fk_id_age_group'],

            'pic_path' =>
                $validated['pic_path'],

            'page_pic_path' =>
                $validated['page_pic_path'],

            'description' =>
                $validated['description'],
        ]);


        DB::table('films_warnings')
            ->where('fk_id_film', $film->id)
            ->delete();


        foreach ($validated['warnings'] as $warningId) {

            DB::table('films_warnings')->insert([
                'fk_id_film' => $film->id,
                'fk_id_warning' => $warningId,
            ]);

        }

        return redirect('/films');
    }

    public function destroy(Film $film)
    {
        $this->authorize('delete', $film);

        DB::table('films_warnings')
            ->where('fk_id_film', $film->id)
            ->delete();

        $film->delete();

        return redirect('/films')
            ->with('success', 'Film is verwijderd.');
    }
}
