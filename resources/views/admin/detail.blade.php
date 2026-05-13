@extends('layouts.admin')

@section('title', 'Detail Verifikasi')

@section('content')

<div class="max-w-6xl mx-auto mt-2 mb-16 px-4">

    <a href="{{ route('admin.verifikasi') }}"
       class="inline-flex items-center gap-2 mb-8 px-4 py-2
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

    {{-- GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14">

        {{-- LEFT --}}
        <div class="space-y-6">

            {{-- FOTO SLIDER --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 overflow-hidden">

                @if($properti->fotos->count() > 0)

                    <div class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth">

                        @foreach($properti->fotos as $foto)

                            <div class="flex-shrink-0 snap-center">

                                <img src="{{ asset('storage/' . $foto->path) }}"
                                     class="h-56 sm:h-64 w-[280px] sm:w-96
                                            object-cover rounded-xl shadow">

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="h-64 flex items-center justify-center text-gray-400 font-inria">
                        Tidak ada foto
                    </div>

                @endif

            </div>

            <div class="bg-white rounded-2xl shadow-sm p-4 text-center">

                <p class="text-sm text-gray-500 font-inria">
                    Diposting {{ $properti->created_at->diffForHumans() }}
                </p>

            </div>

            {{-- BUTTON AREA --}}
            <div class="space-y-4">

                <div class="flex flex-col sm:flex-row gap-4">

                    {{-- FORM TOLAK --}}
                    <form method="POST"
                          action="{{ route('admin.proses', [$properti->properti_id, 'tolak']) }}"
                          class="w-full sm:w-1/2">

                        @csrf

                        <button type="button"
                                onclick="toggleAlasan()"
                                class="w-full bg-red-600 hover:bg-red-700
                                       text-white py-3 rounded-xl
                                       text-sm font-semibold
                                       transition duration-300 shadow-sm
                                       cursor-pointer font-inria">

                            Tolak Properti

                        </button>

                        {{-- FIELD ALASAN --}}
                        <div id="fieldAlasan" class="hidden mt-4 space-y-3">

                            <textarea name="alasan_penolakan"
                                      rows="4"
                                      required
                                      placeholder="Masukkan alasan penolakan..."
                                      class="w-full border border-red-300 rounded-xl
                                             px-4 py-3 text-sm font-inria
                                             focus:outline-none
                                             focus:ring-2 focus:ring-red-500"></textarea>

                            <button type="submit"
                                    class="w-full bg-red-700 hover:bg-red-800
                                           text-white py-2 rounded-xl
                                           text-sm font-semibold
                                           transition duration-300
                                           cursor-pointer font-inria">

                                Konfirmasi Penolakan

                            </button>

                        </div>

                    </form>

                    {{-- FORM SETUJUI --}}
                    <form method="POST"
                          action="{{ route('admin.proses', [$properti->properti_id, 'setujui']) }}"
                          class="w-full sm:w-1/2">

                        @csrf

                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700
                                       text-white py-3 rounded-xl
                                       text-sm font-semibold
                                       transition duration-300 shadow-sm
                                       cursor-pointer font-inria">

                            Verifikasi Properti

                        </button>

                    </form>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            <div class="bg-white rounded-2xl shadow-sm p-5 sm:p-6">

                <h3 class="text-lg sm:text-xl font-semibold mb-6 font-inria break-words">
                    {{ $properti->nama_properti }}
                </h3>

                <div class="space-y-4 text-sm">

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">

                        <p class="font-semibold text-gray-700 mb-1 font-inria">
                            Lokasi
                        </p>

                        <p class="text-gray-600 break-words">
                            {{ $properti->lokasi }}
                        </p>

                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">

                        <h3 class="font-semibold text-gray-700 mb-4 font-inria">
                            Informasi Properti
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">

                            <div class="p-3 rounded-xl bg-gray-50">

                                <p class="text-gray-500 text-xs font-inria mb-1">
                                    Tipe
                                </p>

                                <p class="font-semibold text-gray-700 break-words">
                                    {{ ucfirst($properti->tipe_properti ?? '-') }}
                                </p>

                            </div>

                            <div class="p-3 rounded-xl bg-gray-50">

                                <p class="text-gray-500 text-xs font-inria mb-1">
                                    Luas
                                </p>

                                <p class="font-semibold text-gray-700">
                                    {{ $properti->luas_tanah ?? '-' }} m²
                                </p>

                            </div>

                            <div class="p-3 rounded-xl bg-gray-50">

                                <p class="text-gray-500 text-xs font-inria mb-1">
                                    Kamar
                                </p>

                                <p class="font-semibold text-gray-700">
                                    {{ $properti->jumlah_kamar ?? '-' }}
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-200 shadow-sm">

                        <p class="font-semibold text-gray-700 mb-3 font-inria">
                            Fasilitas
                        </p>

                        <ul class="list-disc list-inside text-gray-600
                                   grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">

                            @foreach(explode(',', $properti->fasilitas) as $item)

                                @if(trim($item) !== '')

                                    <li class="break-words">
                                        {{ trim($item) }}
                                    </li>

                                @endif

                            @endforeach

                        </ul>

                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">

                        <p class="font-semibold text-gray-700 mb-1 font-inria">
                            Harga
                        </p>

                        <p class="text-gray-800 font-semibold break-words">
                            Rp {{ number_format($properti->harga, 0, ',', '.') }}
                        </p>

                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-200 shadow-sm">

                        <p class="font-semibold text-gray-700 mb-2 font-inria">
                            Deskripsi
                        </p>

                        <p class="text-gray-600 leading-relaxed break-words">
                            {{ $properti->deskripsi }}
                        </p>

                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">

                        <p class="font-semibold text-gray-700 mb-1 font-inria">
                            Kontak WhatsApp
                        </p>

                        <p class="text-gray-600 break-all">
                            {{ $properti->kontak_whatsapp }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
function toggleAlasan() {

    const field = document.getElementById('fieldAlasan');

    field.classList.toggle('hidden');
}
</script>

@endsection
