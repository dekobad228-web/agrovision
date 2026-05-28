<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'roles' => 'required|array',
            ],
            [
                'name.unique' => 'Пользователь с таким именем уже существует',
                'email.unique' => 'Пользователь с таким email уже существует',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Пользователь успешно создан!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:users,name,' . $user->id,
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
            ],
            [
                'name.unique' => 'Пользователь с таким именем уже существует',
                'email.unique' => 'Пользователь с таким email уже существует',
            ]
        );

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('admin.users.show', $user->id)
            ->with('success', 'Пользователь обновлён');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
        ->route('admin.users.index')
        ->with('success','Пользователь удален');
    }
}
