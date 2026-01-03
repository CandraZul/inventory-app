@extends('layouts.app')

@section('title', 'Profil Saya')

@section('subtitle', 'Kelola informasi dan pengaturan akun Anda')

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar Profil -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm sticky top-6">
                    <!-- User Profile Card -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="text-center">
                            <!-- Avatar -->
                            <div class="relative inline-block mb-4">
                                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-accent-500 to-accent-600
                                        flex items-center justify-center text-white text-4xl font-bold
                                        shadow-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>

                            <!-- User Info -->
                            <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-gray-600 mt-1">{{ $email }}</p>

                            <!-- Role Badge -->
                            <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($role == 'admin') bg-purple-100 text-purple-800
                                    @elseif($role == 'staff') bg-blue-100 text-blue-800
                                    @elseif($role == 'dosen') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                <i class="fas
                                @if($user->role == 'admin') fa-user-shield
                                @elseif($user->role == 'staff') fa-user-tie
                                @elseif($user->role == 'dosen') fa-chalkboard-teacher
                                @else fa-user-graduate @endif
                                mr-2"></i>
                                {{ ucfirst($role) }}
                            </div>

                            <!-- Member Since -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm text-gray-500">Bergabung sejak</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $user->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="p-4 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-800 mb-3">Statistik Singkat</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Peminjaman</span>
                                <span class="text-sm font-semibold text-gray-800">{{ $totalRiwayat ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informasi Profil -->
                <section id="profile-info" class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="p-3 bg-accent-50 rounded-lg mr-4">
                                    <i class="fas fa-user-circle text-accent-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">Informasi Profil</h2>
                                    <p class="text-gray-600 text-sm mt-1">Kelola informasi akun Anda</p>
                                </div>
                            </div>
                            <button onclick="editProfile()"
                                    class="px-4 py-2 text-sm font-medium text-accent-600 hover:text-accent-700
                                       hover:bg-accent-50 rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Profil
                            </button>
                        </div>
                    </div>

                    <!-- Profile Info Form (Read-only View) -->
                    <div id="profile-view" class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <i class="fas fa-user text-gray-400 mr-3"></i>
                                    <span class="text-gray-800">{{ $user->name }}</span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                    <span class="text-gray-800">{{ $email }}</span>
                                </div>
                            </div>

                            <!-- NIM/NIP -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">NIM/NIP</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <i class="fas fa-id-card text-gray-400 mr-3"></i>
                                    <span class="text-gray-800">{{ $id_number }}</span>
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <i class="fas fa-phone text-gray-400 mr-3"></i>
                                    <span class="text-gray-800">{{ $phone}}</span>
                                </div>
                            </div>

                            <!-- Role -->
                            <?php
                                $role = $user->getRoleNames()->first()
                            ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Role</label>
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <i class="fas
                                    @if($role == 'admin') fa-user-shield
                                    @elseif($role == 'staff') fa-user-tie
                                    @elseif($role == 'dosen') fa-chalkboard-teacher
                                    @else fa-user-graduate @endif
                                    text-gray-400 mr-3"></i>
                                    <span class="text-gray-800 capitalize">{{ $role }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Edit Form (Hidden by default) -->
                    <form id="profile-edit" method="POST" action="/profile"
                          class="p-6 hidden" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="edit-name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input type="text" id="edit-name" name="name"
                                           value="{{ $user->name }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-accent-500
                                              focus:border-accent-500 transition-colors"
                                           required>
                                </div>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="edit-email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" id="edit-email" name="email"
                                           value="{{ $email }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-accent-500
                                              focus:border-accent-500 transition-colors"
                                           required>
                                </div>
                                @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIM/NIP -->
                            <div>
                                <label for="edit-id_number" class="block text-sm font-medium text-gray-700 mb-2">
                                    NIM/NIP
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input type="text" id="edit-id_number" name="id_number"
                                           value="{{ $id_number }}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-accent-500
                                              focus:border-accent-500 transition-colors">
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="edit-phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel" id="edit-phone" name="phone"
                                           value="{{ $phone}}"
                                           class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-accent-500
                                              focus:border-accent-500 transition-colors">
                                </div>
                            </div>

                        </div>


                        <!-- Form Actions -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-3">
                            <button type="button" onclick="cancelEdit()"
                                    class="px-6 py-3 border border-gray-300 text-gray-700 hover:bg-gray-50
                                       rounded-lg transition-colors flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </button>
                            <button type="submit"
                                    class="px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white
                                       rounded-lg transition-colors flex items-center shadow-sm">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Keamanan -->
                <section id="security" class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-50 rounded-lg mr-4">
                                <i class="fas fa-shield-alt text-green-600"></i>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">Keamanan Akun</h2>
                                <p class="text-gray-600 text-sm mt-1">Kelola kata sandi dan keamanan</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Change Password -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-800 mb-4">Ubah Kata Sandi</h3>
                            <form method="POST" action="{{ route('profile.update-password') }}">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <!-- Current Password -->
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Kata Sandi Saat Ini <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-lock text-gray-400"></i>
                                            </div>
                                            <input type="password" id="current_password" name="current_password"
                                                   class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                                      focus:outline-none focus:ring-2 focus:ring-accent-500
                                                      focus:border-accent-500 transition-colors"
                                                   required>
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                    onclick="togglePassword('current_password')">
                                                <i id="current_password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Kata Sandi Baru <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-key text-gray-400"></i>
                                            </div>
                                            <input type="password" id="password" name="new_password"
                                                   class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                                      focus:outline-none focus:ring-2 focus:ring-accent-500
                                                      focus:border-accent-500 transition-colors"
                                                   required>
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                    onclick="togglePassword('password')">
                                                <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                            </button>
                                        </div>
                                        @error('new_password')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                            Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-key text-gray-400"></i>
                                            </div>
                                            <input type="password" id="password_confirmation" name="new_password_confirmation"
                                                   class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg
                                                      focus:outline-none focus:ring-2 focus:ring-accent-500
                                                      focus:border-accent-500 transition-colors"
                                                   required>
                                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                                    onclick="togglePassword('password_confirmation')">
                                                <i id="password_confirmation-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="pt-2">
                                        <button type="submit"
                                                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white
                                                   rounded-lg transition-colors flex items-center shadow-sm">
                                            <i class="fas fa-save mr-2"></i>
                                            Ubah Kata Sandi
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>


    <!-- JavaScript untuk toggle edit mode -->
    <script>
        function editProfile() {
            document.getElementById('profile-view').classList.add('hidden');
            document.getElementById('profile-edit').classList.remove('hidden');

            // Update active nav item
            document.querySelectorAll('nav ul li a').forEach(link => {
                link.classList.remove('active-sidebar-item', 'bg-accent-50', 'border-accent-500');
                link.classList.add('border-transparent');
            });
        }

        function cancelEdit() {
            document.getElementById('profile-view').classList.remove('hidden');
            document.getElementById('profile-edit').classList.add('hidden');

            // Reset active nav item
            document.querySelector('nav ul li:first-child a').classList.add('active-sidebar-item', 'bg-accent-50', 'border-accent-500');
        }

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

        // Smooth scroll untuk navigasi
        document.querySelectorAll('nav ul li a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Update active nav item
                    document.querySelectorAll('nav ul li a').forEach(link => {
                        link.classList.remove('active-sidebar-item', 'bg-accent-50', 'border-accent-500');
                        link.classList.add('border-transparent');
                    });

                    this.classList.add('active-sidebar-item', 'bg-accent-50', 'border-accent-500');
                    this.classList.remove('border-transparent');

                    // Smooth scroll
                    window.scrollTo({
                        top: targetElement.offsetTop - 20,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Handle hash on page load
        window.addEventListener('load', function() {
            if (window.location.hash) {
                const targetId = window.location.hash;
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    // Update active nav item
                    document.querySelectorAll('nav ul li a').forEach(link => {
                        link.classList.remove('active-sidebar-item', 'bg-accent-50', 'border-accent-500');
                        link.classList.add('border-transparent');

                        if (link.getAttribute('href') === targetId) {
                            link.classList.add('active-sidebar-item', 'bg-accent-50', 'border-accent-500');
                            link.classList.remove('border-transparent');
                        }
                    });

                    // Scroll to section
                    setTimeout(() => {
                        window.scrollTo({
                            top: targetElement.offsetTop - 20,
                            behavior: 'smooth'
                        });
                    }, 100);
                }
            }
        });
    </script>
@endsection
