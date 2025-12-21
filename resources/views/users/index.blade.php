@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('subtitle', 'Kelola akses pengguna sistem inventory TIK')

@section('content')
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Pengguna</h2>
                <p class="text-gray-600 mt-1">Total {{ $users->total() }} pengguna terdaftar</p>
            </div>

            <div class="mt-4 md:mt-0">
                @can('create users')
                <a href="{{ route('users.create') }}"
                    class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Pengguna
                </a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengguna
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Terdaftar
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                <span class="font-bold text-primary-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($user->getRoleNames() as $role)
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                    @if($role === 'admin') bg-purple-100 text-purple-800
                                    @elseif($role === 'staff') bg-blue-100 text-blue-800
                                    @elseif($role === 'dosen') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($role) }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                            @can('update', $user)
                            <a href="{{ route('users.edit', $user->id) }}"
                                class="text-green-600 hover:text-green-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @if($user->id != Auth::id())
                                @can('delete', $user)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900"
                                        title="Hapus"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Statistik Pengguna -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 text-purple-600 rounded-lg mr-4">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Admin</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['admin'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mr-4">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Staff</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['staff'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg mr-4">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Dosen</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['dosen'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 bg-gray-100 text-gray-600 rounded-lg mr-4">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Mahasiswa</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['mahasiswa'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
