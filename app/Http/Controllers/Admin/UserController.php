<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nip'      => ['required', 'string', 'max:20', 'unique:users,nip'],
            'role'     => ['required', 'in:superadmin,guru'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nip.unique' => 'NIP sudah digunakan oleh user lain.',
        ]);

        User::create([
            'name'     => $request->name,
            'nip'      => $request->nip,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip'  => ['required', 'string', 'max:20', 'unique:users,nip,' . $user->id],
            'role' => ['required', 'in:superadmin,guru'],
        ], [
            'nip.unique' => 'NIP sudah digunakan oleh user lain.',
        ]);

        $user->update([
            'name' => $request->name,
            'nip'  => $request->nip,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Password {$user->name} berhasil direset.");
    }

    public function destroy(User $user)
    {
        // Jangan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}