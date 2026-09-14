<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
public function index()
{
// Only get users where deleted_at is NULL (Soft Deletes)
$employees = DB::table('users')
->join('role', 'users.fk_role', '=', 'role.id')
->select('users.*', 'role.name as role_name')
->whereNull('users.deleted_at')
->where('users.fk_role', '!=', 3) // Example: hide normal customers
->orderBy('users.first_name')
->get();

$roles = DB::table('role')->get();

return view('admin.employees.index', compact('employees', 'roles'));
}

public function store(Request $request)
{
$request->validate([
'first_name' => 'required|string|max:255',
'prefix' => 'nullable|string|max:50',
'surname' => 'required|string|max:255',
'date_of_birth' => 'required|date',
'email' => 'required|email|unique:users,email',
'password' => 'required|min:8',
'fk_role' => 'required|integer|exists:role,id',
]);

DB::table('users')->insert([
'first_name' => $request->first_name,
'prefix' => $request->prefix,
'surname' => $request->surname,
'date_of_birth' => $request->date_of_birth,
'email' => $request->email,
'password_hash' => Hash::make($request->password),
'fk_role' => $request->fk_role,
'created_at' => now(),
'updated_at' => now(),
]);

return redirect()->route('medewerkers.index')->with('success', 'Medewerker toegevoegd!');
}

public function update(Request $request, $id)
{
$request->validate([
'first_name' => 'required|string|max:255',
'prefix' => 'nullable|string|max:50',
'surname' => 'required|string|max:255',
'date_of_birth' => 'required|date',
'email' => 'required|email|unique:users,email,'.$id,
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

return redirect()->route('medewerkers.index')->with('success', 'Medewerker bijgewerkt!');
}

public function destroy($id)
{
// Soft Delete: update the deleted_at column instead of deleting the row
DB::table('users')->where('id', $id)->update([
'deleted_at' => now(),
'updated_at' => now()
]);

return redirect()->route('medewerkers.index')->with('success', 'Medewerker verwijderd!');
}
}
