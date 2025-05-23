<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserManageController extends Controller
{
    /**
     * Display a listing of users.
     *
     * @return Factory|View|Application
     */
    // app/Http/Controllers/UserManageController.php
    public function index(): Factory|View|Application
    {
        $users = User::paginate(10);

        return view('users.manage.index', compact('users'));
    }

    public function create()
    {
        // Retrieve all roles from the database
        $roles = Role::pluck('name')->toArray();

        // Pass the roles to the view
        return view('users.manage.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            // Assignar el rol a l'usuari
            $user->assignRole($validatedData['role']);

            DB::commit();

            return redirect()->route('users.manage.index')
                ->with('success', 'Usuari creat correctament');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Hi ha hagut un error en crear l\'usuari. Si us plau, torna-ho a intentar.');
        }
    }
    // app/Http/Controllers/UserManageController.php

    public function edit(User $user)
    {
        // Retrieve all roles from the database
        $roles = Role::pluck('name')->toArray();

        // Pass the user and roles to the view
        return view('users.manage.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar datos básicos del usuario
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
            ]);

            // Sincronizar roles (elimina todos los roles actuales y asigna el nuevo)
            $user->syncRoles($validatedData['role']);

            DB::commit();

            return redirect()->route('users.manage.index')
                ->with('success', 'Usuari actualitzat correctament');
        }
        catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Hi ha hagut un error en actualitzar l\'usuari. Si us plau, torna-ho a intentar.');
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('users.manage.index')->with('success', 'User deleted successfully');
    }

    /**
     * Custom function for testing.
     *
     * @return JsonResponse
     */
    public function testedBy(): JsonResponse
    {
        // Lógica de prueba personalizada, ejemplo:
        $testResult = "Test passed successfully!";
        return response()->json(['message' => $testResult]);
    }
}
