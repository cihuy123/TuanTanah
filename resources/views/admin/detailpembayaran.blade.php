@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')

<div class="max-w-4xl mx-auto mt-6">

    <a href="{{ route('admin.pembayaran') }}"
        class="inline-flex items-center gap-2 mb-8 px-5 py-2.5
                bg-white border border-gray-200 rounded-full shadow-sm
                text-sm font-medium text-gray-700
                hover:bg-indigo-600 hover:text-white hover:shadow-md
                transition duration-300 font-inria">

        <svg xmlns="http://www.w3.org/2000/svg"
            class="w-4 h-4"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 19l-7-7 7-7" />
        </svg>

        Kembali
    </a>

    <div class="grid md:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow-sm p-4">

            <p class="text-sm font-semibold mb-3 text-gray-800 font-inria">
                Bukti Pembayaran
            </p>

            <a href="{{ asset('storage/' . $properti->bukti_pembayaran) }}" target="_blank">
                <img src="{{ asset('storage/' . $properti->bukti_pembayaran) }}"
                     class="w-full h-72 object-contain rounded-lg border hover:opacity-90 transition">
            </a>

            <p class="text-xs text-gray-500 mt-2">
                Klik untuk memperbesar
            </p>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-4">

            <div class="bg-white rounded-xl shadow-sm p-5">

                <div class="flex items-center gap-3 mb-3">
                    @php
                        $foto = $properti->fotos->first();
                    @endphp

                    <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                        class="w-16 h-16 rounded-lg object-cover">

                    <div>
                        <p class="text-xs text-gray-500 font-inria">Properti</p>
                        <p class="font-semibold text-gray-800 font-inria">
                            {{ $properti->nama_properti }}
                        </p>
                    </div>
                </div>

                <div class="mb-4">
                    <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-semibold font-inria">
                        Menunggu Validasi
                    </span>
                </div>

                <div>
                    <p class="text-gray-400 text-sm font-inria">Biaya Upload</p>
                    <p class="text-2xl font-bold text-indigo-600">
                        Rp 10.000
                    </p>
                </div>

            </div>

            {{-- ACTION --}}
            <div class="bg-white rounded-xl shadow-sm p-5 space-y-3">

                <form method="POST"
                      action="{{ route('admin.validasi.pembayaran', $properti->properti_id) }}">
                    @csrf
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700
                               text-white py-3 rounded-lg text-sm font-semibold cursor-pointer font-inria">
                        Validasi Pembayaran
                    </button>
                </form>

                <form method="POST"
                    action="{{ route('admin.tolak.pembayaran', $properti->properti_id) }}"
                    class="space-y-3">
                    @csrf

                    <textarea name="alasan"
                        placeholder="Masukkan alasan penolakan..."
                        required
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm
                            focus:ring-2 focus:ring-red-400 outline-none"></textarea>

                    <button type="submit"
                        class="w-full bg-red-500 hover:bg-red-600
                            text-white py-3 rounded-lg text-sm font-semibold cursor-pointer font-inria">
                        Tolak Pembayaran
                    </button>
                </form>

            </div>

        </div>

    </div>

</div>

@endsection
