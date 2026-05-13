@extends('layouts.admin')

@section('title', 'Beranda Admin')

@section('content')

{{-- STATISTIK --}}
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-10">

    <div class="bg-gradient-to-br from-indigo-800 to-indigo-900 text-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center font-semibold">
        <h3 class="text-[10px] sm:text-xs uppercase tracking-wider opacity-80 mb-1 sm:mb-2">
            Total Properti
        </h3>
        <p class="text-xl sm:text-3xl font-bold">
            {{ $totalProperti }}
        </p>
    </div>

    <div class="bg-gradient-to-br from-indigo-800 to-indigo-900 text-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center font-semibold">
        <h3 class="text-[10px] sm:text-xs uppercase tracking-wider opacity-80 mb-1 sm:mb-2">
            Properti Aktif
        </h3>
        <p class="text-xl sm:text-3xl font-bold">
            {{ $totalAktif }}
        </p>
    </div>

    <div class="bg-gradient-to-br from-indigo-800 to-indigo-900 text-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center font-semibold">
        <h3 class="text-[10px] sm:text-xs uppercase tracking-wider opacity-80 mb-1 sm:mb-2">
            Pemilik Properti
        </h3>
        <p class="text-xl sm:text-3xl font-bold">
            {{ $totalPemilik }}
        </p>
    </div>

    <div class="bg-gradient-to-br from-indigo-800 to-indigo-900 text-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center font-semibold">
        <h3 class="text-[10px] sm:text-xs uppercase tracking-wider opacity-80 mb-1 sm:mb-2">
            Menunggu Verifikasi
        </h3>
        <p class="text-xl sm:text-3xl font-bold">
            {{ $menunggu }}
        </p>
    </div>

    <div class="bg-gradient-to-br from-indigo-800 to-indigo-900 text-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition text-center font-semibold col-span-2 sm:col-span-1">
        <h3 class="text-[10px] sm:text-xs uppercase tracking-wider opacity-80 mb-1 sm:mb-2">
            Validasi Pembayaran
        </h3>
        <p class="text-xl sm:text-3xl font-bold">
            {{ $menungguPembayaran }}
        </p>
    </div>

</div>



{{-- TANDAI PROPERTI UNGGULAN --}}
<div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg border border-gray-100">

    <form method="POST" action="{{ route('admin.unggulan') }}">
        @csrf

        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-8">

            <h2 class="text-lg font-semibold text-gray-800 font-inria">
                Tandai Properti Unggulan
            </h2>

            <button
                class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700
                       text-white px-6 py-2.5 rounded-lg text-sm
                       font-medium shadow-md transition duration-200
                       cursor-pointer font-inria">
                Simpan
            </button>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($properti as $item)

            <div class="bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">

                <div class="overflow-hidden">
                    @php
                        $foto = $item->fotos->first();
                    @endphp
                    <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                        class="w-full h-44 object-cover hover:scale-105 transition duration-300">
                </div>

                <div class="p-4 text-sm">

                    <h3 class="font-semibold text-gray-800 mb-1 font-inria">
                        {{ $item->nama_properti }}
                    </h3>

                    <p class="text-gray-500 text-xs mb-1">
                        {{ $item->lokasi }}
                    </p>

                    <p class="text-gray-500 text-xs truncate">
                        {{ implode(' • ', array_map('trim', explode(',', $item->fasilitas))) }}
                    </p>

                    <p class="font-bold text-indigo-600 mb-3">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

                    <div class="flex items-center justify-between border-t pt-3">
                        <span class="text-xs text-gray-600 font-inria">
                            Tandai Unggulan
                        </span>

                        <input type="checkbox"
                               name="properti[]"
                               value="{{ $item->properti_id }}"
                               class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer"
                               {{ $item->is_unggulan ? 'checked' : '' }}>
                    </div>

                </div>
            </div>

            @empty
                <p class="text-gray-500 col-span-full text-center font-inria">
                    Tidak ada properti yang disetujui.
                </p>
            @endforelse

        </div>

    </form>

</div>

@endsection
