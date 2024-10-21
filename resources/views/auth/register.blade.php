@extends('layouts.auth')

@section('title', 'Register')

@section('content')
{{-- Hero Section --}}
<div class="flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Buat Akun Baru</h2>
            </div>

            <div class="mt-6">
                <div>
                    <form action="{{ route('register.store') }}" method="POST" class="space-y-4" id="registerForm">
                        @csrf {{-- Token CSRF untuk keamanan --}}
                        
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama</label>
                            <div class="mt-2">
                                <input id="name" name="name" type="text" autocomplete="name" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div>
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <input id="username" name="username" type="text" autocomplete="username" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <p id="usernameMessage" class="mt-1 text-sm"></p>
                            </div>
                            @error('username')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Alamat Email</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <p id="passwordStrength" class="mt-1 text-sm"></p>
                            </div>
                            @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Konfirmasi Kata Sandi</label>
                            <div class="mt-2">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                <p id="passwordMatchMessage" class="mt-1 text-sm"></p>
                            </div>
                        </div>

                        {{-- Hidden Role Field --}}
                        <input type="hidden" name="role" value="user"> {{-- Default role sebagai "user" --}}

                        {{-- Submit Button --}}
                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Daftar Akun
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="/login" class="font-semibold text-indigo-600 hover:text-indigo-500">
                            Masuk disini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1528265417219-1a288ae08573?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('username');
        const usernameMessage = document.getElementById('usernameMessage');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordStrengthText = document.getElementById('passwordStrength');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');

        // Event listener untuk mengecek validasi username
        usernameInput.addEventListener('input', function() {
            const username = usernameInput.value;
            const usernamePattern = /^[a-zA-Z0-9]+$/;

            if (!usernamePattern.test(username)) {
                usernameMessage.textContent = 'Username hanya boleh menggunakan huruf dan angka tanpa spasi';
                usernameMessage.style.color = 'red';
            } else {
                usernameMessage.textContent = '';
            }
        });

        // Event listener untuk mengecek kekuatan password
        passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(passwordInput.value);
            passwordStrengthText.textContent = strength.message;
            passwordStrengthText.style.color = strength.color;
        });

        // Event listener untuk mengecek kecocokan password
        passwordConfirmationInput.addEventListener('input', function() {
            if (passwordInput.value !== passwordConfirmationInput.value) {
                passwordMatchMessage.textContent = 'Kata sandi tidak cocok';
                passwordMatchMessage.style.color = 'red';
            } else {
                passwordMatchMessage.textContent = 'Kata sandi cocok';
                passwordMatchMessage.style.color = 'green';
            }
        });

        // Fungsi untuk mengecek kekuatan password
        function checkPasswordStrength(password) {
            let message = '';
            let color = 'red';
            if (password.length < 6) {
                message = 'Kata sandi terlalu pendek';
            } else if (!/[A-Z]/.test(password) || !/[0-9]/.test(password) || !/[!@#$%^&*_-]/.test(password)) {
                message = 'Kekuatan sedang (Tambahkan huruf besar, angka, dan simbol)';
                color = 'orange';
            } else {
                message = 'Kekuatan kuat';
                color = 'green';
            }
            return { message, color };
        }
    });
</script>
@endsection