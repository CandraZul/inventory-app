<?php

namespace App\Http\Controllers;

use App\Models\ProfileMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $user->assignRole($request['role']);

        if ($request['role'] === 'mahasiswa') {
            ProfileMahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'kontak' => $request->kontak
            ]);
        }

        if ($request['role'] === 'dosen') {
            ProfileMahasiswa::create([
                'user_id' => $user->id,
                'nip' => $request->nip,
                'kontak' => $request->kontak
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $user)
    {
        $roles = Role::pluck('name', 'name');
        $user = User::with(['dosenProfile', 'mahasiswaProfile'])->findOrFail($user);
        $userRole = $user->roles->pluck('name')->first();


        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email
        ]);

         $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        $user = User::findOrFail($user);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
