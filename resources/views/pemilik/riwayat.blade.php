@extends('layouts.pemilik')

@section('title', 'Riwayat Properti')

@section('content')

<div class="bg-gray-50 pb-16">
    {{-- MENUNGGU VERIFIKASI --}}
    <section class="pt-8">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-2xl font-semibold font-inria text-gray-800 mb-8">
                Menunggu Verifikasi
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($menunggu as $item)

                <a href="{{ route('pemilik.edit', $item->properti_id) }}"
                   class="group block bg-white rounded-2xl shadow-sm overflow-hidden relative
                          hover:shadow-xl hover:-translate-y-1
                          transition duration-300 cursor-pointer">

                    {{-- Badge --}}
                    <div class="absolute top-4 left-4
                                bg-yellow-100 text-yellow-700
                                text-xs font-semibold px-3 py-1 rounded-full z-10 font-inria">
                        Menunggu Verifikasi Admin
                    </div>

                    {{-- Image --}}
                    <div class="overflow-hidden">
                        @php
                            $foto = $item->fotos->first();
                        @endphp

                        <div class="overflow-hidden">
                            <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                                class="w-full h-44 object-cover group-hover:scale-105 transition duration-500"
                                alt="Properti">
                        </div>
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-700 text-xs px-3 py-1 rounded-full shadow font-bold font-inria">
                            {{ ucfirst($item->tipe_properti ?? 'properti') }}
                        </div>
                    </div>

                    {{-- Content --}}
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
                            Klik untuk mengubah data
                        </p>

                    </div>

                </a>

                @empty
                    <p class="col-span-3 text-gray-500 text-center font-inria">
                        Tidak ada properti yang sedang menunggu verifikasi.
                    </p>
                @endforelse

            </div>
        </div>
    </section>


    {{-- DITOLAK --}}
    <section class="pt-12">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-2xl font-semibold font-inria text-gray-800 mb-8">
                Ditolak
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($ditolak as $item)

                <a href="{{ route('pemilik.edit', $item->properti_id) }}"
                   class="group block bg-white rounded-2xl shadow-sm overflow-hidden relative
                          hover:shadow-xl hover:-translate-y-1
                          transition duration-300 cursor-pointer border border-red-100">

                    {{-- Badge --}}
                    <div class="absolute top-4 left-4
                                bg-red-100 text-red-600
                                text-xs font-semibold px-3 py-1 rounded-full z-10 font-inria">
                        Ditolak
                    </div>

                    {{-- Image --}}
                    <div class="overflow-hidden">
                        @php
                            $foto = $item->fotos->first();
                        @endphp

                        <div class="overflow-hidden">
                            <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                                class="w-full h-44 object-cover group-hover:scale-105 transition duration-500"
                                alt="Properti">
                        </div>
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-700 text-xs px-3 py-1 rounded-full shadow font-bold font-inria">
                            {{ ucfirst($item->tipe_properti ?? 'properti') }}
                        </div>
                    </div>

                    {{-- Content --}}
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

                        {{-- Alasan Penolakan --}}
                        @if($item->alasan_penolakan)
                            <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-2">
                                <p class="text-[11px] font-semibold text-red-600 mb-1">
                                    Alasan Penolakan:
                                </p>
                                <p class="text-[11px] text-red-700 line-clamp-2">
                                    {{ $item->alasan_penolakan }}
                                </p>
                            </div>
                        @endif

                        <p class="text-xs text-gray-400 mt-2">
                            Klik untuk memperbaiki data
                        </p>

                    </div>

                </a>

                @empty
                    <p class="col-span-3 text-gray-500 text-center font-inria">
                        Tidak ada properti yang ditolak.
                    </p>
                @endforelse

            </div>
        </div>
    </section>

</div>

@endsection
