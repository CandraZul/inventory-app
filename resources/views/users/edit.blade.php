@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('subtitle', 'Edit data pengguna sistem inventory TIK')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <!-- Form Header -->
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-accent-50 rounded-lg mr-4">
                        <i class="fas fa-user-edit text-accent-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Edit Pengguna</h2>
                        <p class="text-gray-600 text-sm mt-1">{{ $user->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form method="POST" action="{{ route('users.update', $user->id) }}" class="px-6 py-8">
                @csrf
                @method('PUT')

                <!-- User Info Summary -->
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-accent-100 flex items-center justify-center">
                            <span class="text-lg font-semibold text-accent-600">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pengguna ID: {{ $user->id }}</p>
                            <p class="text-sm text-gray-600">Bergabung: {{ $user->created_at->format('d M Y') }}</p>
{{--                            <p class="text-sm text-gray-600">Terakhir login:--}}
{{--                                @if($user->last_login_at)--}}
{{--                                    {{ $user->last_login_at->diffForHumans() }}--}}
{{--                                @else--}}
{{--                                    Belum pernah login--}}
{{--                                @endif--}}
{{--                            </p>--}}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Kolom Kiri: Informasi Dasar -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Informasi Dasar</h3>

                            <!-- Nama Lengkap -->
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="name" name="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors"
                                           required>
                                </div>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors"
                                           required>
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password (Opsional untuk update) -->
                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Baru (Opsional)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password" name="password"
                                           class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors"
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                            onclick="togglePassword('password')">
                                        <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                                @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Role & Status -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Role & Status</h3>

                            <!-- Role -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Role Pengguna <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach(['admin', 'dosen', 'mahasiswa'] as $role)
                                        <label class="relative flex cursor-pointer">
                                            <input type="radio" name="role" value="{{ $role }}"
                                                   {{ old('role', $user->getRoleNames()->first()) == $role ? 'checked' : '' }}
                                                   class="sr-only peer">
                                            <div class="flex-1 p-4 border border-gray-300 rounded-lg
                                               peer-checked:border-accent-500 peer-checked:bg-accent-50
                                               hover:border-gray-400 transition-colors">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0">
                                                        @switch($role)
                                                            @case('admin')
                                                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                                    <i class="fas fa-user-shield text-purple-600"></i>
                                                                </div>
                                                                @break
                                                            @case('dosen')
                                                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                                    <i class="fas fa-chalkboard-teacher text-green-600"></i>
                                                                </div>
                                                                @break
                                                            @case('mahasiswa')
                                                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                                                    <i class="fas fa-user-graduate text-gray-600"></i>
                                                                </div>
                                                                @break
                                                        @endswitch
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-900 capitalize">{{ $role }}</p>
                                                        <p class="text-xs text-gray-500">
                                                            @switch($role)
                                                                @case('admin') Akses penuh sistem @break
                                                                @case('dosen') Peminjaman & pengembalian @break
                                                                @case('mahasiswa') Hanya peminjaman @break
                                                            @endswitch
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIM/NIP -->
                            <div id="id-number-wrapper">
                                <label id="id-number-label" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $userRole == 'dosen' ? 'NIP' : 'NIM' }}
                                </label>

                                @if ($userRole == 'dosen')
                                    <input type="text" id="id_number" name="id_number"
                                           value="{{ old('id_number', $user->dosenProfile?->nip) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg
                                            focus:ring-2 focus:ring-accent-500 focus:border-accent-500"
                                           placeholder="Contoh: 198012345678">
                                @endif

                                @if ($userRole == 'mahasiswa')
                                    <input type="text" id="id_number" name="id_number"
                                           value="{{ old('id_number', $user->mahasiswaProfile?->nim) }}"
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg
                                            focus:ring-2 focus:ring-accent-500 focus:border-accent-500"
                                           placeholder="Contoh: K3522890">
                                @endif
                            </div>


                            <!-- Kontak -->
                            <div class="mt-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone"
                                           value="{{ old('phone', $user->mahasiswaProfile?->kontak ?? $user->dosenProfile?->kontak ?? '') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors"
                                           placeholder="081234567890">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                    <div class="flex space-x-3">
                        <a href="{{ route('users.index') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50
                              rounded-lg transition-colors flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>

                        @if($user->id != Auth::id())
                            <button type="button" onclick="confirmResetPassword()"
                                    class="px-6 py-3 border border-yellow-300 text-yellow-700 hover:bg-yellow-50
                                   rounded-lg transition-colors flex items-center">
                                <i class="fas fa-key mr-2"></i>
                                Reset Password
                            </button>
                        @endif
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" onclick="confirmDelete()"
                                class="px-6 py-3 border border-red-300 text-red-700 hover:bg-red-50
                                   rounded-lg transition-colors flex items-center">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Pengguna
                        </button>

                        <button type="submit"
                                class="px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white
                                   rounded-lg transition-colors flex items-center shadow-sm">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div id="resetPasswordModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl shadow-lg max-w-md w-full mx-4">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-key text-yellow-600"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Reset Password</h3>
                        <p class="text-sm text-gray-600">Password akan dikirim ke email pengguna</p>
                    </div>
                </div>

                <form id="resetPasswordForm" method="POST" action="#">
                    @csrf
                    @method('POST')

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Email penerima
                        </label>
                        <input type="email" value="{{ $user->email }}"
                               class="block w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeResetPasswordModal()"
                                class="px-4 py-2 border border-gray-300 text-gray-700 hover:bg-gray-50
                                   rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white
                                   rounded-lg transition-colors">
                            Kirim Reset Password
                        </button>
                    </div>
                </form>
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
                        Apakah Anda yakin ingin menghapus pengguna <strong>{{ $user->name }}</strong>?
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
                    <form id="deleteForm" method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline">
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
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const passwordIcon = document.getElementById(fieldId + '-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }

        function confirmResetPassword() {
            document.getElementById('resetPasswordModal').classList.remove('hidden');
        }

        function closeResetPasswordModal() {
            document.getElementById('resetPasswordModal').classList.add('hidden');
        }

        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modals on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeResetPasswordModal();
                closeDeleteModal();
            }
        });

        // Close modals when clicking outside
        document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResetPasswordModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.querySelectorAll('input[name="role"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const wrapper = document.getElementById('id-number-wrapper');
                const label = document.getElementById('id-number-label');
                const input = document.getElementById('id_number');

                if (this.value === 'admin') {
                    wrapper.style.display = 'none';
                    input.value = '';
                } else {
                    wrapper.style.display = 'block';

                    if (this.value === 'mahasiswa') {
                        label.innerText = 'NIM';
                        input.placeholder = 'Contoh: K3522890';
                    } else if (this.value === 'dosen') {
                        label.innerText = 'NIP';
                        input.placeholder = 'Contoh: 198012345678';
                    }
                }
            });
        });

        document.getElementById('user-form').addEventListener('reset', function () {
            setTimeout(() => {
                const checked = document.querySelector('input[name="role"]:checked');
                if (checked) {
                    checked.dispatchEvent(new Event('change'));
                }
            }, 0);
        });
    </script>
@endsection
