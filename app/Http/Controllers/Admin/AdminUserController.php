<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['vehicles', 'reservations']);
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->only('name', 'email', 'role'));
        return back();
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back();
    }
}
