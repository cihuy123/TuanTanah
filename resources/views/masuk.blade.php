@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-300 flex items-center justify-center px-4">

    {{-- CARD --}}
    <div class="bg-[#151541] w-full max-w-sm rounded-2xl shadow-2xl p-8 text-white relative">

        <a href="{{ url()->previous() ?: route('pelanggan.beranda') }}"
        class="absolute top-4 left-4 flex items-center justify-center w-9 h-9
                rounded-full bg-white/10 backdrop-blur-md
                border border-white/20
                shadow-md
                hover:bg-indigo-500 hover:shadow-lg hover:scale-110
                transition duration-300 group">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 text-gray-200 group-hover:text-white transition"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7" />
            </svg>

        </a>

        <h2 class="text-2xl font-semibold text-center mb-8 mt-4 font-inria tracking-wide">
            Selamat Datang
        </h2>

        <form method="POST" action="{{ route('masuk') }}" class="space-y-5">
            @csrf

            <div>
                <label class="text-xs uppercase tracking-wide text-gray-300 font-inria">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Masukkan email Anda"
                       class="w-full mt-2 px-4 py-2.5 rounded-lg bg-white text-black text-sm
                              placeholder:text-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">

                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs uppercase tracking-wide text-gray-300 font-inria">
                    Password
                </label>

                <input type="password"
                       name="password"
                       placeholder="Masukkan password Anda"
                       class="w-full mt-2 px-4 py-2.5 rounded-lg bg-white text-black text-sm
                              placeholder:text-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">

                @error('password')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700
                           py-3 rounded-lg text-sm font-semibold
                           shadow-md hover:shadow-lg
                           transition duration-300 mt-3 cursor-pointer font-inria">
                Masuk
            </button>

        </form>

        <p class="text-xs text-gray-300 mt-6 text-center font-inria">
            Belum punya akun?
            <a href="{{ route('daftar') }}"
               class="text-white font-semibold hover:underline ml-1">
                Daftar
            </a>
        </p>

    </div>

</div>

@endsection
