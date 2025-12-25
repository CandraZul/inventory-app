@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('subtitle', 'Tambahkan pengguna baru ke sistem inventory TIK')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <!-- Form Header -->
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 bg-accent-50 rounded-lg mr-4">
                        <i class="fas fa-user-plus text-accent-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Tambah Pengguna Baru</h2>
                        <p class="text-gray-600 text-sm mt-1">Laboratorium TIK</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form method="POST" id="user-form" action="{{ route('users.store') }}" class="px-6 py-8">
                @csrf

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
                                           value="{{ old('name') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors placeholder-gray-400"
                                           placeholder="Masukkan nama lengkap"
                                           required autofocus>
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
                                           value="{{ old('email') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors placeholder-gray-400"
                                           placeholder="nama@email.com"
                                           required>
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password" name="password"
                                           class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors placeholder-gray-400"
                                           placeholder="Minimal 8 karakter"
                                           required>
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                            onclick="togglePassword('password')">
                                        <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
                                @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors placeholder-gray-400"
                                           placeholder="Ulangi password"
                                           required>
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                            onclick="togglePassword('password_confirmation')">
                                        <i id="password_confirmation-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                    </button>
                                </div>
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
                                    @php
                                        $roles = ['dosen', 'mahasiswa'];

                                        if(auth()->user()->hasRole('super admin')) {
                                            $roles[] = 'admin';
                                        }
                                    @endphp
                                    @foreach($roles as $role)
                                        <label class="relative flex cursor-pointer">
                                            <input type="radio" name="role" value="{{ $role }}"
                                                   {{ old('role', 'mahasiswa') == $role ? 'checked' : '' }}
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

{{--                            <!-- Status Aktif -->--}}
{{--                            <div class="mb-6">--}}
{{--                                <label class="block text-sm font-medium text-gray-700 mb-2">--}}
{{--                                    Status Akun--}}
{{--                                </label>--}}
{{--                                <div class="flex items-center space-x-6">--}}
{{--                                    <label class="flex items-center cursor-pointer">--}}
{{--                                        <div class="relative">--}}
{{--                                            <input type="checkbox" name="is_active" value="1"--}}
{{--                                                   {{ old('is_active', true) ? 'checked' : '' }}--}}
{{--                                                   class="sr-only peer">--}}
{{--                                            <div class="w-12 h-6 bg-gray-200 peer-focus:outline-none rounded-full--}}
{{--                                                   peer peer-checked:after:translate-x-6 peer-checked:after:border-white--}}
{{--                                                   after:content-[''] after:absolute after:top-[2px] after:left-[2px]--}}
{{--                                                   after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all--}}
{{--                                                   peer-checked:bg-green-500"></div>--}}
{{--                                        </div>--}}
{{--                                        <span class="ml-3 text-sm text-gray-700">Aktif</span>--}}
{{--                                    </label>--}}
{{--                                    <span class="text-xs text-gray-500">--}}
{{--                                    Akun tidak aktif tidak dapat login--}}
{{--                                </span>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <!-- NIM/NIP (Opsional) -->
                            <div id="id-number-wrapper">
                                <label id="id-number-label"
                                       class="block text-sm font-medium text-gray-700 mb-2">
                                    NIM
                                </label>
                                <input type="text" id="id_number" name="id_number"
                                       value="{{ old('id_number') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg
                                       focus:ring-2 focus:ring-accent-500 focus:border-accent-500"
                                       placeholder="Contoh: K3522890">
                            </div>


                            <!-- Kontak -->
                            <div class="mt-6">
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon (Opsional)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="phone" name="phone"
                                           value="{{ old('phone') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                           focus:ring-2 focus:ring-accent-500 focus:border-accent-500
                                           transition-colors placeholder-gray-400"
                                           placeholder="081234567890">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

{{--                <!-- Informasi Tambahan -->--}}
{{--                <div class="mt-8 pt-6 border-t border-gray-200">--}}
{{--                    <h3 class="text-lg font-medium text-gray-800 mb-4">Informasi Tambahan (Opsional)</h3>--}}

{{--                    <!-- Departemen/Prodi -->--}}
{{--                    <div class="mb-6">--}}
{{--                        <label for="department" class="block text-sm font-medium text-gray-700 mb-2">--}}
{{--                            Departemen/Program Studi--}}
{{--                        </label>--}}
{{--                        <select id="department" name="department"--}}
{{--                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg--}}
{{--                               focus:ring-2 focus:ring-accent-500 focus:border-accent-500--}}
{{--                               transition-colors">--}}
{{--                            <option value="">Pilih Departemen/Prodi</option>--}}
{{--                            <option value="informatika" {{ old('department') == 'informatika' ? 'selected' : '' }}>Informatika</option>--}}
{{--                            <option value="sistem_informasi" {{ old('department') == 'sistem_informasi' ? 'selected' : '' }}>Sistem Informasi</option>--}}
{{--                            <option value="teknik_komputer" {{ old('department') == 'teknik_komputer' ? 'selected' : '' }}>Teknik Komputer</option>--}}
{{--                            <option value="lainnya" {{ old('department') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}

{{--                    <!-- Catatan -->--}}
{{--                    <div>--}}
{{--                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">--}}
{{--                            Catatan (Opsional)--}}
{{--                        </label>--}}
{{--                        <textarea id="notes" name="notes" rows="3"--}}
{{--                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg--}}
{{--                               focus:ring-2 focus:ring-accent-500 focus:border-accent-500--}}
{{--                               transition-colors placeholder-gray-400"--}}
{{--                                  placeholder="Catatan tambahan tentang pengguna...">{{ old('notes') }}</textarea>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <!-- Informasi Penting -->
                <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-yellow-400 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Informasi Penting</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Pastikan data pengguna sudah benar sebelum disimpan</li>
                                    <li>Password akan dikirim ke email pengguna</li>
                                    <li>Role menentukan hak akses dalam sistem</li>
{{--                                    <li>Pengguna non-aktif tidak dapat login ke sistem</li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                    <a href="{{ route('users.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50
                          rounded-lg transition-colors flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>

                    <div class="flex space-x-3">
                        <button type="reset"
                                class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50
                                   rounded-lg transition-colors flex items-center">
                            <i class="fas fa-redo mr-2"></i>
                            Reset Form
                        </button>

                        <button type="submit"
                                class="px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white
                                   rounded-lg transition-colors flex items-center shadow-sm">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Pengguna
                        </button>
                    </div>
                </div>
            </form>
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

        // Auto-generate email dari nama (opsional)
        document.getElementById('name').addEventListener('blur', function() {
            const emailField = document.getElementById('email');
            if (!emailField.value) {
                const name = this.value.toLowerCase().replace(/\s+/g, '.');
                if (name) {
                    emailField.value = name + '@labtik.ac.id';
                }
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
