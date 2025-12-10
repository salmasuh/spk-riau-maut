<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the users (with search + pagination).
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $usersQuery = User::query()->orderBy('name');

        if ($q) {
            $usersQuery->where(function($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('username', 'like', "%{$q}%");
            });
        }

        $users = $usersQuery->paginate(10)->withQueryString();

        // Tambahan hitung total user aktif
        $totalAktif = User::where('status', 'aktif')->count();
        $totalSemua = User::count();
        return view('pengguna.index', compact('users', 'q', 'totalAktif', 'totalSemua'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // roles: admin, pimpinan, pengguna/staf (sesuaikan)
        $roles = ['admin' => 'Admin', 'pimpinan' => 'Pimpinan', 'staf' => 'Pengguna'];
        return view('pengguna.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'username' => ['required','string','max:100','unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'role' => ['required', Rule::in(['admin','pimpinan','staf'])],
            'status' => ['required', Rule::in(['aktif','nonaktif'])],
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        Session::flash('success', 'Pengguna berhasil ditambahkan.');
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = ['admin' => 'Admin', 'pimpinan' => 'Pimpinan', 'staf' => 'Pengguna'];
        return view('pengguna.edit', compact('user','roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'username' => ['required','string','max:100', Rule::unique('users','username')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'role' => ['required', Rule::in(['admin','pimpinan','staf'])],
            'status' => ['required', Rule::in(['aktif','nonaktif'])],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // keep existing
        }

        $user->update($data);

        Session::flash('success', 'Data pengguna berhasil diperbarui.');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // optionally, block deleting currently logged in user — up to you
        $user->delete();
        Session::flash('success', 'Pengguna berhasil dihapus.');
        return redirect()->route('users.index');
    }
}