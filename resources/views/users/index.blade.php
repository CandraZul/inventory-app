@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Manajemen User</h3>

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Tambah User</a>

        <table class="table table-bordered">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>

            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->first() }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}
    </div>
@endsection
