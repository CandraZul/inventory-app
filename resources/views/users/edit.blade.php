@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Edit User</h3>
        <div class="card mt-3">
            <div class="card-body">

                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>

                    {{-- Role --}}
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control">
                            @foreach ($roles as $key => $role)
                                <option value="{{ $key }}"
                                    {{ $userRole == $key ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    {{-- Tombol Submit --}}
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
