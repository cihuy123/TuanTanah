@extends('layouts.pemilik')

@section('title', 'Pembayaran')

@section('content')

<div class="max-w-7xl mx-auto px-4">

    <h2 class="text-2xl font-semibold text-gray-800 mb-10 font-inria">
        Pembayaran Properti
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($properti as $item)

    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1
                transition duration-300 overflow-hidden border border-gray-100 relative">

        {{-- BADGE STATUS --}}
        @if(is_null($item->bukti_pembayaran))
            <div class="absolute top-4 left-4 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow font-inria">
                Belum Dibayar
            </div>

        @elseif($item->status_pembayaran == 'ditolak')
            <div class="absolute top-4 left-4 bg-red-400 text-white text-xs px-3 py-1 rounded-full font-semibold shadow font-inria">
                Ditolak
            </div>
        @endif

        {{-- IMAGE --}}
        <div class="overflow-hidden">
            @php
                $foto = $item->fotos->first();
            @endphp
            <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                class="w-full h-44 object-cover hover:scale-105 transition duration-300">
        </div>

        {{-- CONTENT --}}
        <div class="p-5 text-sm">

            <h3 class="font-semibold text-gray-800 mb-2 font-inria">
                {{ $item->nama_properti }}
            </h3>

            {{-- BIAYA --}}
            <p class="text-gray-400 text-xs mb-4 font-inria">
                Biaya Upload:
                <span class="font-semibold text-gray-700">Rp 10.000</span>
            </p>

            {{-- ALASAN PENOLAKAN --}}
            @if($item->status_pembayaran == 'ditolak')
                <div class="bg-red-50 border border-red-200 text-red-600 text-xs p-2 rounded mb-4">
                    {{ $item->alasan_penolakan_pembayaran }}
                </div>
            @endif

            {{-- ACTION --}}
            <a href="{{ route('pemilik.detail', $item->properti_id) }}"
               class="block text-center
                      {{ $item->status_pembayaran == 'ditolak' ? 'bg-red-500 hover:bg-red-600' : 'bg-indigo-600 hover:bg-indigo-700' }}
                      text-white py-2.5 rounded-xl text-sm font-semibold
                      transition duration-300 shadow font-inria">

                @if(is_null($item->bukti_pembayaran))
                    Bayar Sekarang
                @elseif($item->status_pembayaran == 'pending')
                    Lihat Status
                @elseif($item->status_pembayaran == 'ditolak')
                    Upload Ulang
                @endif

            </a>

        </div>

    </div>

    @empty
        <p class="col-span-3 text-gray-500 text-center font-inria">
            Tidak ada properti yang perlu dibayar.
        </p>
    @endforelse

    </div>

</div>

@endsection
