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
                                    @if($role === 'super admin') bg-purple-100 text-purple-800
                                    @elseif($role === 'admin') bg-blue-100 text-blue-800
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
                                <div class="inline">
                                    <button
                                        onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                        class="text-red-600 hover:text-red-900"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
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
    @can('view super admin')
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col items-center text-center">
            <div class="p-3 bg-purple-100 text-purple-600 rounded-lg mb-3">
                <i class="fas fa-user-shield text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Super Admin</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['super admin'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    @endcan

    @can('view admin')
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col items-center text-center">
            <div class="p-3 bg-blue-100 text-blue-600 rounded-lg mb-3">
                <i class="fas fa-user-tie text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Admin</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['admin'] ?? 0 }}</p>
            </div>
        </div>
    </div>
    @endcan

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col text-center items-center">
            <div class="p-3 bg-green-100 text-green-600 rounded-lg mb-3">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Dosen</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['dosen'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex flex-col text-center items-center">
            <div class="p-3 bg-gray-100 text-gray-600 rounded-lg mb-3">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-500">Mahasiswa</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['mahasiswa'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Confirmation -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
        <div class="p-6">
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Hapus Pengguna</h3>
                    <p class="text-sm text-gray-600">Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-gray-700 mb-3">
                    Apakah Anda yakin ingin menghapus pengguna <strong id="deleteUserName">{{ $user->name }}</strong>?
                </p>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="text-sm text-red-700 space-y-1">
                        <li class="flex items-center">
                            <i class="fas fa-times-circle mr-2"></i>
                            Semua data terkait akan dihapus
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times-circle mr-2"></i>
                            Riwayat peminjaman akan hilang
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times-circle mr-2"></i>
                            Pengguna tidak dapat login lagi
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50
                               rounded-lg transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white
                                   rounded-lg transition-colors">
                        Ya, Hapus Pengguna
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(userId, userName) {
        document.getElementById('deleteUserName').innerText = userName;

        const form = document.getElementById('deleteForm');
        form.action = `users/${userId}`;

        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
