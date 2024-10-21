@extends('layouts.auth')

@section('title', 'Login')

@section('content')
{{-- Hero Section --}}
<div class="flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <h2 class="mt-8 text-2xl font-bold leading-9 tracking-tight text-gray-900">Masuk ke akun Anda</h2>
            </div>

            <div class="mt-10">
                <div>
                    <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                        @csrf {{-- Token CSRF untuk keamanan --}}
                        
                        {{-- Username atau Email --}}
                        <div>
                            <label for="login" class="block text-sm font-medium leading-6 text-gray-900">Email atau Username</label>
                            <div class="mt-2">
                                <input id="login" name="login" type="text" autocomplete="username" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                @error('login')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Kata Sandi</label>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                Masuk
                            </button>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Belum punya akun? 
                                <a href="/register" class="font-semibold text-indigo-600 hover:text-indigo-500">
                                    Daftar disini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
        <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1704447840243-a0d84a38198b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
    </div>
</div>
@endsection