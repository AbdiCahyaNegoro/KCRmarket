@extends('layouts.app')
@section('title', 'LOGIN')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="flex w-full max-w-5xl bg-white shadow-lg rounded-lg overflow-hidden h-screen">
            <div class="hidden md:flex w-1/2 bg-cover bg-center" style="background-image: url('{{ asset('assets/img/backgroundlogin.png') }}');">
            </div>
            <div class="w-full md:w-1/2 flex flex-col justify-center p-8">
                <h2 class="text-2xl font-semibold text-gray-700 text-center mb-6">SELAMAT DATANG</h2>
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label for="email" class="block text-gray-700 text-sm">Email Address</label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror"
                            placeholder="Masukkan Email"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 text-sm">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan Password"
                        >
                        @error('password')
                            <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center text-sm">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-1">
                            <label class="text-gray-700" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-blue-500 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Lupa Password ?') }}
                            </a>
                        @endif
                    </div>

                    <div class="text-center">
                        <button 
                            type="submit" 
                            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition duration-300">
                            Login
                        </button>
                        <p class="text-xs text-gray-700 mt-4">
                            Tidak Punya Akun?
                            <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
