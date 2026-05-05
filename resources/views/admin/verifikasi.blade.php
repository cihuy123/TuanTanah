@extends('layouts.admin')

@section('title', 'Verifikasi Properti')

@section('content')

<h2 class="text-2xl font-semibold text-gray-800 mb-8 font-inria">
    Daftar Properti yang Belum Diverifikasi
</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($properti as $item)

    <a href="{{ route('admin.detail', $item->properti_id) }}"
       class="group block bg-white rounded-2xl overflow-hidden shadow-sm
              hover:shadow-xl hover:-translate-y-1
              transition duration-300 border border-gray-100 cursor-pointer relative">

        {{-- BADGE --}}
        <div class="absolute top-4 left-4
                    bg-blue-100 text-blue-600
                    text-xs font-semibold px-3 py-1 rounded-full z-10 font-inria">
            Perlu Verifikasi
        </div>

        {{-- IMAGE --}}
        <div class="overflow-hidden">
            @php
                $foto = $item->fotos->first();
            @endphp
            <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                class="w-full h-44 object-cover hover:scale-105 transition duration-500"
                    alt="Properti">
        </div>

        {{-- CONTENT --}}
        <div class="p-4 text-sm">

            <h3 class="font-semibold text-gray-800 mb-1 font-inria">
                {{ $item->nama_properti }}
            </h3>

            <p class="text-gray-500 text-xs mb-1 truncate">
                {{ $item->lokasi }}
            </p>

            <p class="text-gray-500 text-xs truncate">
                {{ implode(' • ', array_map('trim', explode(',', $item->fasilitas))) }}
            </p>

            <p class="font-bold text-indigo-600 mt-3">
                Rp {{ number_format($item->harga, 0, ',', '.') }}
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Klik untuk melakukan verifikasi
            </p>

        </div>

    </a>

    @empty
        <p class="text-gray-500 col-span-3 text-center font-inria">
            Tidak ada properti yang perlu diverifikasi.
        </p>
    @endforelse

</div>

@endsection
