<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Validation\Rules\Password;


class EmployeeController extends Controller
{
    public function index()
    {

        $this->authorize('viewAny', User::class);

        $employees = DB::table('users')
            ->join('roles', 'users.fk_role', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->where('users.fk_role', '!=', 3)
            ->where('users.fk_role', '!=', auth()->id())
            ->orderBy('users.first_name')
            ->get();

        $roles = DB::table('roles')->get();

        return view('employees', compact('employees', 'roles'));
    }

    public function store(Request $request)
    {

        $this->authorize('store', User::class);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'prefix' => ['nullable', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:255'],
            'date_of_birth' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYears(12)->toDateString(),
                'after_or_equal:' . Carbon::now()->subYears(105)->toDateString(),
            ],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'first_name.required' => 'Vul je voornaam in.',
            'first_name.max' => 'Je voornaam is te lang.',
            'surname.required' => 'Vul je achternaam in.',
            'surname.max' => 'Je achternaam is te lang.',
            'date_of_birth.required' => 'Vul je geboortedatum in.',
            'date_of_birth.date' => 'Vul een geldige geboortedatum in.',
            'date_of_birth.before_or_equal' => 'Je moet minimaal 12 jaar oud zijn.',
            'date_of_birth.after_or_equal' => 'Je mag maximaal 100 jaar oud zijn.',
            'email.required' => 'Vul je e-mailadres in.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Er bestaat al een account met dit e-mailadres.',
            'password.required' => 'Vul een wachtwoord in.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
        ]);

        DB::table('users')->insert([
        'first_name' => $request->first_name,
        'prefix' => $request->prefix,
        'surname' => $request->surname,
        'date_of_birth' => $request->date_of_birth,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'fk_role' => $request->fk_role,
        'created_at' => now(),
        'updated_at' => now(),
        ]);

        return redirect()->route('medewerkers.index')
            ->with('success', 'Medewerker toegevoegd!');
    }

    public function update(Request $request, $id)
    {

        $employee = User::findOrFail($id);

        $this->authorize('update', $employee);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'prefix' => ['nullable', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:255'],
            'date_of_birth' => [
                'required',
                'date',
                'before_or_equal:' . Carbon::now()->subYears(12)->toDateString(),
                'after_or_equal:' . Carbon::now()->subYears(105)->toDateString(),
            ],
            // ADD THE ID HERE to tell Laravel to ignore this specific user when checking uniqueness
            'email' => ['required', 'email', 'unique:users,email,' . $id],

            'password' => [
                'nullable', // CHANGE TO NULLABLE so they can leave it blank
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'first_name.required' => 'Vul je voornaam in.',
            'first_name.max' => 'Je voornaam is te lang.',
            'surname.required' => 'Vul je achternaam in.',
            'surname.max' => 'Je achternaam is te lang.',
            'date_of_birth.required' => 'Vul je geboortedatum in.',
            'date_of_birth.date' => 'Vul een geldige geboortedatum in.',
            'date_of_birth.before_or_equal' => 'Je moet minimaal 12 jaar oud zijn.',
            'date_of_birth.after_or_equal' => 'Je mag maximaal 100 jaar oud zijn.',
            'email.required' => 'Vul je e-mailadres in.',
            'email.email' => 'Vul een geldig e-mailadres in.',
            'email.unique' => 'Er bestaat al een account met dit e-mailadres.',
            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
        ]);

        $data = [
        'first_name' => $request->first_name,
        'prefix' => $request->prefix,
        'surname' => $request->surname,
        'date_of_birth' => $request->date_of_birth,
        'email' => $request->email,
        'fk_role' => $request->fk_role,
        'updated_at' => now(),
        ];

        // Only update password if a new one is typed in the modal
        if ($request->filled('password')) {
        $data['password_hash'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);

        return redirect()->route('medewerkers.index')
            ->with('success', 'Medewerker bijgewerkt!');
    }

    public function destroy($id)
    {
        $worker = User::findOrFail($id);
        $this->authorize('destroy', $worker);

        // Hard Delete: entirely removes the entry from the users table
        DB::table('users')->where('id', $id)->delete();

        return redirect()->route('medewerkers.index')->with('success', 'Medewerker permanent verwijderd!');
    }
}
