<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class EmployeeController extends Controller
{
    public function index()
    {

        $this->authorize('viewAny', User::class);

        // Only get users where deleted_at is NULL (Soft Deletes)
        $employees = DB::table('users')
            ->join('roles', 'users.fk_role', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->whereNull('users.deleted_at')
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
            'first_name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:50',
            'surname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // <-- Added |confirmed
            'fk_role' => 'required|integer|exists:role,id',
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
            'first_name' => 'required|string|max:255',
            'prefix' => 'nullable|string|max:50',
            'surname' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:8|confirmed', // <-- Added this line
            'fk_role' => 'required|integer|exists:role,id',
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
