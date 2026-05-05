@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')

<h2 class="text-2xl font-semibold text-gray-800 mb-10 font-inria">
    Daftar Properti Menunggu Validasi Pembayaran
</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

@forelse($properti as $item)

<a href="{{ route('admin.detailpembayaran', $item->properti_id) }}"
   class="group block bg-white rounded-2xl shadow-sm overflow-hidden relative
          hover:shadow-xl hover:-translate-y-1
          transition duration-300 border border-gray-100 cursor-pointer">

    {{-- BADGE --}}
    <div class="absolute top-4 left-4
                bg-yellow-100 text-yellow-700
                text-xs font-semibold px-3 py-1 rounded-full z-10 font-inria">
        Menunggu Validasi
    </div>

    {{-- IMAGE --}}
    <div class="overflow-hidden">
        @php
            $foto = $item->fotos->first();
        @endphp
        <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
            class="w-full h-44 object-cover hover:scale-105 transition duration-500">
    </div>

    {{-- CONTENT --}}
    <div class="p-4 text-sm">

        <h3 class="font-semibold text-gray-800 mb-1 font-inria">
            {{ $item->nama_properti }}
        </h3>

        <p class="text-gray-400 text-xs mb-2 truncate">
            {{ $item->lokasi }}
        </p>

        <p class="font-bold text-indigo-600 mt-3">
            Rp {{ number_format($item->harga, 0, ',', '.') }}
        </p>

        <p class="text-xs text-gray-400 mt-2">
            Klik untuk validasi pembayaran
        </p>

    </div>

</a>

@empty
<p class="text-gray-500 col-span-3 text-center font-inria">
    Tidak ada pembayaran yang perlu divalidasi.
</p>
@endforelse

</div>

@endsection
