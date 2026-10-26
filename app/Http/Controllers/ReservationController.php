<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Screening;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    /**
     * Display the user's reservations.
     */
    public function index()
    {
        $reservations = Reservation::with([
            'seat',
            'screening.film',
            'screening.auditory',
        ])
            ->where('fk_user', Auth::id())
            ->get();

        $now = now();

        $upcomingReservations = $reservations
            ->filter(function ($reservation) use ($now) {
                return $reservation->screening->date_time->isAfter($now);
            })
            ->sortBy(function ($reservation) {
                return $reservation->screening->date_time->getTimestamp();
            });

        $pastReservations = $reservations
            ->filter(function ($reservation) use ($now) {
                return $reservation->screening->date_time->lessThanOrEqualTo($now);
            })
            ->sortByDesc(function ($reservation) {
                return $reservation->screening->date_time->getTimestamp();
            });

        // Fetch all seats and all system reservations to build the modal grids
        $seats = \App\Models\Seat::all();
        $allReservations = Reservation::all();

        return view('reservations.reservations', [
            'upcomingReservationsByScreening' => $upcomingReservations->groupBy('fk_screening'),
            'pastReservationsByScreening'     => $pastReservations->groupBy('fk_screening'),
            'seats'                           => $seats,             // Added for modal
            'allReservations'                 => $allReservations,   // Added for modal
        ]);
    }

    /**
     * Store a new reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'screening_id' => [
                'required',
                'integer',
                'exists:screenings,id',
            ],

            'seat_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'seat_ids.*' => [
                'required',
                'integer',
                'distinct',
                'exists:seats,id',
            ],
            [
                'seat_ids.required' => 'Geen zitplaatsen gekozen',
                'screening_id.exists' => 'Dit voorstelling bestaat niet meer',
                'seat_ids.*.exists' => "Er zijn geen zitplaatsen met nummer dat u gekozen heeft"
            ]
        ]);

        $userId = Auth::id();

        DB::transaction(function () use ($validated, $userId) {

            /*
             * Lock the screening while checking and creating
             * reservations. This prevents two users from booking
             * the same screening simultaneously between the
             * availability check and the insert.
             */
            $screening = Screening::query()
                ->lockForUpdate()
                ->findOrFail($validated['screening_id']);

            $seatIds = collect($validated['seat_ids'])
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            /*
             * Only allow seats that actually belong to the
             * auditorium of this screening.
             */
            $validSeatIds = Seat::query()
                ->where('fk_auditory', $screening->fk_auditory)
                ->whereIn('id', $seatIds)
                ->pluck('id');

            if ($validSeatIds->count() !== $seatIds->count()) {
                throw ValidationException::withMessages([
                    'seat_ids' => 'Een of meer geselecteerde plaatsen zijn niet geldig voor deze zaal.',
                ]);
            }

            /*
             * Check whether one of the selected seats has already
             * been reserved for this screening.
             */
            $occupiedSeatIds = Reservation::query()
                ->where('fk_screening', $screening->id)
                ->whereIn('fk_seat', $seatIds)
                ->pluck('fk_seat');

            if ($occupiedSeatIds->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'seat_ids' => 'Een of meer geselecteerde plaatsen zijn inmiddels bezet. Kies opnieuw je plaatsen.',
                ]);
            }

            $bookingCutoff = $screening->date_time->copy()->subMinutes(30);

            if (now()->greaterThanOrEqualTo($bookingCutoff)) {
                throw ValidationException::withMessages([
                    'screening_id' => 'Reserveren is niet mogelijk binnen 30 minuten voor aanvang.',
                ]);
            }

            /*
             * Create one reservation row per seat.
             */
            $reservations = $seatIds->map(function ($seatId) use ($screening, $userId) {
                return [
                    'fk_seat' => $seatId,
                    'fk_screening' => $screening->id,
                    'fk_user' => $userId,
                ];
            })->all();

            Reservation::insert($reservations);
        });

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Je reservering is succesvol geplaatst.');
    }

    public function destroy(Request $request)
    {
        // 1. Validate the incoming data from the modal
        $request->validate([
            'screening_id' => 'required|integer|exists:screenings,id',
            'seat_ids'     => 'required|array',
            'seat_ids.*'   => 'integer|exists:seats,id',
        ]);

        $screeningId = $request->input('screening_id');
        $seatIds = $request->input('seat_ids');
        $userId = Auth::id();

        // 2. Fetch the screening to enforce the 24-hour rule on the backend
        $screening = Screening::findOrFail($screeningId);

        if (\Carbon\Carbon::parse($screening->date_time)->isBefore(now()->addDay())) {
            return back()->withErrors([
                'error' => 'Je kunt een reservering alleen tot 24 uur voor de voorstelling annuleren.'
            ]);
        }

        // 3. Find and delete the specific reservations.
        // We strictly check fk_user to prevent users from deleting other people's seats!
        $deletedCount = Reservation::where('fk_user', $userId)
            ->where('fk_screening', $screeningId)
            ->whereIn('fk_seat', $seatIds)
            ->delete();

        // 4. Return to the page with a success or error message
        if ($deletedCount > 0) {
            $message = $deletedCount === 1
                ? '1 plaats is succesvol geannuleerd.'
                : $deletedCount . ' plaatsen zijn succesvol geannuleerd.';

            return back()->with('success', $message);
        }

        return back()->withErrors([
            'error' => 'Er is iets misgegaan. Controleer of je de juiste plaatsen hebt geselecteerd.'
        ]);
    }
}
