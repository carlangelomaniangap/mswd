<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AdminManageAccountController extends Controller
{
    public function index()
    {
        return view('pages.admin.manage_account');
    }

    public function fetchData()
    {
        $users = User::orderBy('id', 'asc')->get();

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'role' => $user->role,
                'name' => $user->name,
                'email' => $user->email,
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password successfully reset.',
        ]);
    }
}