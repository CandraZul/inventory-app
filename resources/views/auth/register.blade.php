@extends('layouts.app')

@section('title', 'Daftar Akun Baru')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-700 to-gray-800 rounded-2xl shadow-lg mb-6">
                    <i class="fas fa-user-plus text-gray-200 text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">
                    Buat Akun Baru
                </h2>
                <p class="mt-2 text-gray-600">
                    Daftar untuk mengakses sistem inventory laboratorium TIK
                </p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="md:flex">
                    <!-- Left Side - Illustration -->
                    <div class="md:w-2/5 bg-gradient-to-br from-gray-700 to-gray-800 p-8 text-gray-100 hidden md:block">
                        <div class="h-full flex flex-col justify-center">
                            <div class="mb-8">
                                <h3 class="text-xl font-bold mb-4">Bergabung Dengan Kami</h3>
                                <p class="text-gray-300">Akses penuh untuk meminjam alat-alat laboratorium TIK</p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <i class="fas fa-check-circle text-gray-300"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium">Akses inventori lengkap</p>
                                        <p class="text-sm text-gray-400">Hardware, software, dan peralatan lab</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <i class="fas fa-check-circle text-gray-300"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium">Peminjaman online</p>
                                        <p class="text-sm text-gray-400">Ajukan peminjaman kapan saja</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <i class="fas fa-check-circle text-gray-300"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-medium">Notifikasi real-time</p>
                                        <p class="text-sm text-gray-400">Pantau status peminjaman</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-12 pt-8 border-t border-gray-600">
                                <p class="text-sm text-gray-300">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="font-semibold text-gray-200 hover:text-white transition-colors">
                                        Masuk di sini
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - Form -->
                    <div class="md:w-3/5 p-8">
                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                                           required autocomplete="name" autofocus
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-gray-500
                                              focus:border-gray-500 transition-colors
                                              @error('name') border-red-500 @enderror"
                                           placeholder="Masukkan nama lengkap">
                                </div>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                           required autocomplete="email"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-gray-500
                                              focus:border-gray-500 transition-colors
                                              @error('email') border-red-500 @enderror"
                                           placeholder="nama@email.com">
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input id="password" type="password" name="password"
                                               required autocomplete="new-password"
                                               class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                                  focus:outline-none focus:ring-2 focus:ring-gray-500
                                                  focus:border-gray-500 transition-colors
                                                  @error('password') border-red-500 @enderror"
                                               placeholder="Minimal 8 karakter">
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                onclick="togglePassword('password')">
                                            <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input id="password-confirm" type="password" name="password_confirmation"
                                               required autocomplete="new-password"
                                               class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                                  focus:outline-none focus:ring-2 focus:ring-gray-500
                                                  focus:border-gray-500 transition-colors"
                                               placeholder="Ulangi password">
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                onclick="togglePassword('password-confirm')">
                                            <i id="password-confirm-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Role Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Daftar sebagai <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Dosen Option -->
                                    <label class="relative flex cursor-pointer">
                                        <input type="radio" name="role" value="dosen"
                                               {{ old('role') == 'dosen' ? 'checked' : '' }}
                                               class="sr-only peer" required>
                                        <div class="flex-1 p-4 border-2 border-gray-200 rounded-xl
                                               peer-checked:border-gray-600 peer-checked:bg-gray-50
                                               hover:border-gray-300 transition-all duration-200">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                    <i class="fas fa-chalkboard-teacher text-gray-600 text-xl"></i>
                                                </div>
                                                <span class="font-medium text-gray-900">Dosen</span>
                                                <span class="text-xs text-gray-500 mt-1">Staff pengajar</span>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Mahasiswa Option -->
                                    <label class="relative flex cursor-pointer">
                                        <input type="radio" name="role" value="mahasiswa"
                                               {{ old('role') == 'mahasiswa' ? 'checked' : '' }}
                                               class="sr-only peer" required>
                                        <div class="flex-1 p-4 border-2 border-gray-200 rounded-xl
                                               peer-checked:border-gray-600 peer-checked:bg-gray-50
                                               hover:border-gray-300 transition-all duration-200">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                    <i class="fas fa-user-graduate text-gray-600 text-xl"></i>
                                                </div>
                                                <span class="font-medium text-gray-900">Mahasiswa</span>
                                                <span class="text-xs text-gray-500 mt-1">Pelajar/mahasiswa</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dynamic Fields -->
                            <div class="space-y-4" id="dynamic-fields">
                                <!-- NIP Field (for Dosen) -->
                                <div id="nip-field" class="hidden animate-fadeIn">
                                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-2">
                                        NIP <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </div>
                                        <input id="nip" type="text" name="nip" value="{{ old('nip') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                                  focus:outline-none focus:ring-2 focus:ring-gray-500
                                                  focus:border-gray-500 transition-colors
                                                  @error('nip') border-red-500 @enderror"
                                               placeholder="Masukkan NIP">
                                    </div>
                                    @error('nip')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- NIM Field (for Mahasiswa) -->
                                <div id="nim-field" class="hidden animate-fadeIn">
                                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-2">
                                        NIM <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-id-card text-gray-400"></i>
                                        </div>
                                        <input id="nim" type="text" name="nim" value="{{ old('nim') }}"
                                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                                  focus:outline-none focus:ring-2 focus:ring-gray-500
                                                  focus:border-gray-500 transition-colors
                                                  @error('nim') border-red-500 @enderror"
                                               placeholder="Masukkan NIM">
                                    </div>
                                    @error('nim')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact -->
                            <div>
                                <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Kontak
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input id="contact" type="text" name="contact" value="{{ old('contact') }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-gray-500
                                              focus:border-gray-500 transition-colors"
                                           placeholder="Contoh: 081234567890">
                                </div>
                                @error('contact')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox"
                                           {{ old('terms') ? 'checked' : '' }}
                                           class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded"
                                           required>
                                </div>
                                <div class="ml-3">
                                    <label for="terms" class="text-sm text-gray-700">
                                        Saya menyetujui
                                        <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">
                                            Syarat & Ketentuan
                                        </a>
                                        dan
                                        <a href="#" class="text-gray-600 hover:text-gray-800 font-medium">
                                            Kebijakan Privasi
                                        </a>
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Akun akan diverifikasi oleh admin sebelum dapat digunakan
                                    </p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-4">
                                <button type="submit"
                                        class="w-full flex justify-center py-3 px-4 border border-transparent
                                           rounded-xl shadow-sm text-sm font-medium text-white
                                           bg-gradient-to-r from-gray-700 to-gray-800
                                           hover:from-gray-800 hover:to-gray-900
                                           focus:outline-none focus:ring-2 focus:ring-offset-2
                                           focus:ring-gray-500 transition-all duration-200">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Daftar Akun
                                </button>
                            </div>

                            <!-- Login Link (Mobile) -->
                            <div class="pt-6 border-t border-gray-200 md:hidden">
                                <p class="text-center text-sm text-gray-600">
                                    Sudah punya akun?
                                    <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-800">
                                        Masuk di sini
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="text-center">
                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Laboratorium TIK. Hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Animasi untuk munculnya field */
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling untuk radio button yang dipilih */
        .peer:checked + div {
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            border-color: #4b5563;
        }

        /* Hover effect untuk form inputs */
        input:not(:focus):hover {
            border-color: #d1d5db;
        }

        /* Focus styles untuk konsistensi */
        input:focus, button:focus {
            outline: none;
            ring-width: 2px;
            ring-color: rgba(107, 114, 128, 0.2);
        }

        /* Smooth transition untuk semua elemen */
        * {
            transition: background-color 0.2s, border-color 0.2s, transform 0.2s;
        }
    </style>

    <script>
        // Toggle password visibility
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

        // Handle role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleRadios = document.querySelectorAll('input[name="role"]');
            const nipField = document.getElementById('nip-field');
            const nimField = document.getElementById('nim-field');

            // Set initial state based on old input
            const initialRole = '{{ old("role") }}';
            if (initialRole === 'dosen') {
                nipField.classList.remove('hidden');
            } else if (initialRole === 'mahasiswa') {
                nimField.classList.remove('hidden');
            }

            // Add event listeners to radio buttons
            roleRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const role = this.value;

                    // Hide both fields first
                    nipField.classList.add('hidden');
                    nimField.classList.add('hidden');

                    // Remove required attribute from both
                    document.getElementById('nip')?.removeAttribute('required');
                    document.getElementById('nim')?.removeAttribute('required');

                    // Show appropriate field
                    if (role === 'dosen') {
                        setTimeout(() => {
                            nipField.classList.remove('hidden');
                            document.getElementById('nip')?.setAttribute('required', 'required');
                        }, 10);
                    } else if (role === 'mahasiswa') {
                        setTimeout(() => {
                            nimField.classList.remove('hidden');
                            document.getElementById('nim')?.setAttribute('required', 'required');
                        }, 10);
                    }
                });
            });

            // Auto-generate email suggestion
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');

            nameField.addEventListener('blur', function() {
                if (!emailField.value && this.value) {
                    const name = this.value.toLowerCase()
                        .replace(/\s+/g, '.')
                        .replace(/[^a-z.]/g, '');

                    if (name.length > 0) {
                        emailField.value = name + '@student.labtik.ac.id';
                    }
                }
            });

            // Auto-format NIP/NIM
            const nipFieldInput = document.getElementById('nip');
            const nimFieldInput = document.getElementById('nim');

            if (nipFieldInput) {
                nipFieldInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        value = value.match(/.{1,3}/g).join('.');
                    }
                    e.target.value = value;
                });
            }

            if (nimFieldInput) {
                nimFieldInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^a-zA-Z0-9]/g, '');
                    if (value.length > 0) {
                        value = value.substring(0, 12);
                    }
                    e.target.value = value;
                });
            }

            // Auto-format phone number
            const contactField = document.getElementById('contact');
            if (contactField) {
                contactField.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (value.startsWith('0')) {
                            value = value.substring(0, 12);
                            if (value.length > 4) {
                                value = value.replace(/(\d{4})(\d{4})(\d{0,4})/, '$1-$2-$3');
                            } else if (value.length > 0) {
                                value = value.replace(/(\d{4})/, '$1');
                            }
                        } else if (value.startsWith('62')) {
                            value = value.substring(0, 14);
                            if (value.length > 4) {
                                value = value.replace(/(\d{4})(\d{4})(\d{0,6})/, '$1-$2-$3');
                            }
                        }
                    }
                    e.target.value = value;
                });
            }
        });
    </script>
@endsection
