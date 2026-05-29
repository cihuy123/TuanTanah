@extends('layouts.pelanggan')

@section('title', 'Properti')

@section('content')

<div class="bg-gray-50">
    <form method="GET" action="{{ route('pelanggan.properti') }}"
        class="bg-white border border-gray-200
                rounded-xl shadow-md
                px-4 py-3
                mt-6 mb-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">

            <div class="relative">
                <label class="text-[11px] text-gray-500 font-medium font-inria">Lokasi</label>

                <div class="relative">
                    <input type="text" name="lokasi" value="{{ request('lokasi') }}"
                        placeholder="Cari lokasi..."
                        class="w-full border border-gray-200 rounded-lg
                            pl-9 pr-3 py-2 text-sm
                            focus:ring-2 focus:ring-indigo-500 outline-none">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                </div>
            </div>

            <div>
                <label class="text-[11px] text-gray-500 font-medium font-inria">Tipe</label>

                <select name="tipe"
                    class="w-full border border-gray-200 rounded-lg
                        px-3 py-2 text-sm
                        focus:ring-2 focus:ring-indigo-500 outline-none cursor-pointer font-inria">

                    <option value="">Semua</option>
                    <option value="rumah" {{ request('tipe')=='rumah' ? 'selected' : '' }}>Rumah</option>
                    <option value="tanah" {{ request('tipe')=='tanah' ? 'selected' : '' }}>Tanah</option>
                    <option value="ruko" {{ request('tipe')=='ruko' ? 'selected' : '' }}>Ruko</option>
                    <option value="apartemen" {{ request('tipe')=='apartemen' ? 'selected' : '' }}>Apartemen</option>
                </select>
            </div>

            <div class="relative">
                <label class="text-[11px] text-gray-500 font-medium font-inria">Min</label>

                <input type="number" name="min" value="{{ request('min') }}"
                    placeholder="0"
                    class="w-full border border-gray-200 rounded-lg
                        pl-8 pr-3 py-2 text-sm
                        focus:ring-2 focus:ring-indigo-500 outline-none">

                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                    Rp
                </span>
            </div>

            <div class="relative">
                <label class="text-[11px] text-gray-500 font-medium font-inria">Max</label>

                <input type="number" name="max" value="{{ request('max') }}"
                    placeholder="0"
                    class="w-full border border-gray-200 rounded-lg
                        pl-8 pr-3 py-2 text-sm
                        focus:ring-2 focus:ring-indigo-500 outline-none">

                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">
                    Rp
                </span>
            </div>

            <div class="flex gap-2">

                <button type="submit"
                    class="flex-1 flex items-center justify-center gap-2
                        bg-indigo-600 text-white px-4 py-2
                        rounded-lg text-sm font-medium
                        hover:bg-indigo-700 shadow-sm hover:shadow-md transition cursor-pointer font-inria">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>

                    Cari
                </button>

                <a href="{{ route('pelanggan.properti') }}"
                class="px-3 py-2 text-sm rounded-lg border border-gray-200
                        text-gray-600 hover:bg-gray-100 text-center font-inria">
                    Reset
                </a>

            </div>

        </div>

    </form>

    {{-- PROPERTI UNGGULAN --}}
    <section class="py-1">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold font-inria text-gray-800 mb-5">
                Daftar Properti Unggulan
            </h2>

            <div class="grid md:grid-cols-3 gap-10">

                @forelse($unggulan as $item)

                <a href="{{ route('pelanggan.detail', $item->properti_id) }}"
                class="group block bg-white rounded-2xl shadow-sm overflow-hidden
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative overflow-hidden">
                        @php
                            $foto = $item->fotos->first();
                        @endphp

                        <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                            class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">

                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-700 text-xs px-3 py-1 rounded-full shadow font-bold font-inria">
                            {{ ucfirst($item->tipe_properti ?? 'properti') }}
                        </div>
                        <div class="absolute top-3 left-3 bg-gradient-to-r from-yellow-600 to-orange-400 text-white text-xs px-3 py-1 rounded-full shadow font-semibold font-inria">
                            ⭐ Properti Unggulan
                        </div>
                    </div>

                    <div class="p-5 text-sm">

                        <h3 class="font-semibold text-gray-800 mb-1 font-inria group-hover:text-indigo-600 transition">
                            {{ $item->nama_properti }}
                        </h3>

                        <p class="text-gray-500 text-xs mb-1 font-inria">
                            {{ $item->lokasi }}
                        </p>

                        <p class="text-gray-500 text-xs truncate font-inria">
                            {{ implode(' • ', array_map('trim', explode(',', $item->fasilitas))) }}
                        </p>

                        <div class="flex justify-between items-center mt-4">
                            <p class="font-bold text-indigo-600 font-inria">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                </a>

                @empty
                    <p class="text-gray-500 col-span-3 text-center font-inria">
                        Belum ada properti unggulan.
                    </p>
                @endforelse

            </div>
        </div>
    </section>

    <section class="py-7">
        <div class="max-w-7xl mx-auto px-6">

            <h2 class="text-3xl font-bold font-inria text-gray-800 mb-4">
                Daftar Properti
            </h2>

            <div class="grid md:grid-cols-3 gap-10">

                @forelse($properti as $item)

                <a href="{{ route('pelanggan.detail', $item->properti_id) }}"
                class="group block bg-white rounded-2xl shadow-sm overflow-hidden
                        hover:shadow-xl hover:-translate-y-1
                        transition duration-300">

                    <div class="relative overflow-hidden">
                        @php
                            $foto = $item->fotos->first();
                        @endphp

                        <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                            class="w-full h-44 object-cover group-hover:scale-105 transition duration-300">

                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-700 text-xs px-3 py-1 rounded-full shadow font-bold font-inria">
                            {{ ucfirst($item->tipe_properti ?? 'properti') }}
                        </div>
                    </div>

                    <div class="p-5 text-sm">

                        <h3 class="font-semibold text-gray-800 mb-1 font-inria group-hover:text-indigo-600 transition">
                            {{ $item->nama_properti }}
                        </h3>

                        <p class="text-gray-500 text-xs mb-1 font-inria">
                            {{ $item->lokasi }}
                        </p>

                        <p class="text-gray-500 text-xs truncate font-inria">
                            {{ implode(' • ', array_map('trim', explode(',', $item->fasilitas))) }}
                        </p>

                        <div class="flex justify-between items-center mt-4">
                            <p class="font-bold text-indigo-600 font-inria">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                </a>

                @empty
                    <p class="text-gray-500 col-span-3 text-center font-inria">
                        Belum ada properti tersedia.
                    </p>
                @endforelse

            </div>
        </div>
    </section>

</div>

@endsection
