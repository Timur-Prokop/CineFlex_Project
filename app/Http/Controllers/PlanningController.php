<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Film;
use App\Models\Screening;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class PlanningController extends Controller
{
    public function index()
    {
        $films = DB::table('screenings')
            ->join(
                'films',
                'screenings.fk_film',
                '=',
                'films.id'
            )
            ->join(
                'auditories',
                'screenings.fk_auditory',
                '=',
                'auditories.id'
            )
            ->select(
                'screenings.*',
                'films.title',
                'films.duration',
                'films.pic_path',
                'auditories.number',
                'auditories.seats_quantity'
            )
            ->where('screenings.date_time', '>=', now())
            ->orderBy('screenings.date_time')
            ->get();

        $allFilms = DB::table('films')
            ->orderBy('title')
            ->get();

        $auditories = DB::table('auditories')
            ->orderBy('number')
            ->get();

        return view('planning.timetable', [
            'films' => $films,
            'allFilms' => $allFilms,
            'auditories' => $auditories
        ]);
    }



    public function create(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'fk_film' => ['required', 'integer', 'exists:films,id'],
                'fk_auditory' => ['required', 'integer', 'exists:auditories,id'],
                'date' => ['required', 'date'],
                'time' => ['required', 'date_format:H:i'],
            ],
            [
                'fk_film.required' => 'Kies een film.',
                'fk_auditory.required' => 'Kies een zaal.',
                'date.required' => 'Kies een datum.',
                'time.required' => 'Kies een starttijd.',
            ]
        );

        $film = DB::table('films')
            ->where('id', $validated['fk_film'])
            ->first();

        $start = Carbon::parse(
            $validated['date'] . ' ' . $validated['time']
        );

        $end = $start->copy()->addMinutes($film->duration);


        $openingTime = Carbon::parse(
            $validated['date'] . ' 14:00'
        );

        $latestEndTime = Carbon::parse(
            $validated['date'] . ' 01:30'
        )->addDay();


        if ($start->format('H:i') < '14:00') {
            $start->addDay();

            $end = $start->copy()
                ->addMinutes($film->duration);
        }


        if ($start->lt($openingTime)) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'De bioscoop opent om 14:00.'
                ]);
        }


        if ($end->gt($latestEndTime)) {
            return back()
                ->withInput()
                ->withErrors([
                    'time' => 'De bioscoop werkt vanaf 14 00 tot 2 00.'
                ]);
        }


        $dayStart = Carbon::parse(
            $validated['date'] . ' 14:00'
        );

        $dayEnd = Carbon::parse(
            $validated['date'] . ' 02:00'
        )->addDay();


        $existingScreenings = DB::table('screenings')
            ->join(
                'films',
                'screenings.fk_film',
                '=',
                'films.id'
            )
            ->where(
                'screenings.fk_auditory',
                $validated['fk_auditory']
            )
            ->whereBetween(
                'screenings.date_time',
                [$dayStart, $dayEnd]
            )
            ->select(
                'screenings.id',
                'screenings.date_time',
                'films.duration'
            )
            ->get();


        foreach ($existingScreenings as $screening) {

            $existingStart = Carbon::parse(
                $screening->date_time
            );

            $existingEnd = $existingStart
                ->copy()
                ->addMinutes($screening->duration);

            $newFilmIsBefore =
                $end->copy()
                    ->addMinutes(30)
                    ->lte($existingStart);

            $newFilmIsAfter =
                $start->gte(
                    $existingEnd->copy()
                        ->addMinutes(30)
                );


            if (!$newFilmIsBefore && !$newFilmIsAfter) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'time' =>
                            'Deze voorstelling overlapt met een andere film of er zit minder dan 30 minuten pauze tussen.'
                    ]);
            }
        }


        DB::table('screenings')->insert([
            'fk_film' => $validated['fk_film'],
            'fk_auditory' => $validated['fk_auditory'],
            'date_time' => $start,
        ]);


        return redirect()
            ->route('planning.show')
            ->with(
                'success',
                'De voorstelling is succesvol toegevoegd.'
            );
    }

    public function destroy(Screening $screening)
    {
        $this->authorize('destroy', $screening);

        $exists = Ticket::where(
            'fk_id_screening',
            $screening->id
        )->exists();

        if ($exists) {
            return redirect()->back()->with(
                'error',
                'Er zijn tickets verkocht voor deze voorstelling. Het is niet mogelijk om de voorstelling uit de agenda te verwijderen.'
            );
        }

        $screening->delete();

        return redirect()->back()->with(
            'success',
            'De voorstelling is verwijderd.'
        );
    }
}
