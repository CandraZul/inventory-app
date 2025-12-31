@extends('layouts.app')

@section('title', 'Login - Inventory TIK')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Logo & Title -->
        <div>
            <div class="flex justify-center">
                <div class="bg-primary-600 text-white p-4 rounded-2xl">
                    <i class="fas fa-laptop-code text-4xl"></i>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Inventory Laboratorium PTIK
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Sistem Manajemen Inventori dan Peminjaman
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-colors"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1 relative">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm transition-colors"
                            placeholder="••••••••">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword()">
                            <i id="password-icon" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Ingat saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-500">
                                Lupa password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center items-center py-3 px-4 text-sm
                            font-semibold rounded-lg text-white bg-[#475569] hover:bg-[#334155] focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-[#3b82f6] transition-all duration-300 shadow-md hover:shadow-lg active:scale-[0.98]">

                        <!-- Icon kiri -->
                        <span class="absolute left-3 inset-y-0 flex items-center text-slate-300 group-hover:text-white transition">
                            <i class="fas fa-sign-in-alt"></i>
                        </span>

                        Masuk ke Sistem
                    </button>

                </div>
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">
                            Belum punya akun?
                        </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('register') }}"
                           class="w-full flex justify-center py-3 px-4 border border-primary-600 rounded-lg
                               shadow-sm text-sm font-medium text-primary-600 bg-white hover:bg-accent-50
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500
                               transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>
                            Daftar Akun Baru
                        </a>
                    </div>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="text-center px-1.5 bg-white text-gray-500">
                            Laboratorium Pendidikan Teknik Informatika dan Komputer
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');

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
</script>
@endsection
