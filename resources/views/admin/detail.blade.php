@extends('layouts.admin')

@section('title', 'Detail Verifikasi')

@section('content')

<div class="max-w-6xl mx-auto mt-2 mb-16">

    {{-- Back Button --}}
    <a href="{{ route('admin.verifikasi') }}"
       class="inline-flex items-center gap-2 mb-8 px-4 py-2
              bg-white border border-gray-200 rounded-full shadow-sm
              text-sm font-medium text-gray-700
              hover:bg-indigo-600 hover:text-white hover:shadow-md
              transition duration-300">

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

    <div class="grid md:grid-cols-2 gap-14">

        {{-- ================= LEFT ================= --}}
        <div class="space-y-6">

            {{-- FOTO SLIDER --}}
            <div class="bg-white rounded-2xl shadow-sm p-4">

                @if($properti->fotos->count() > 0)
                    <div class="flex gap-4 overflow-x-auto pb-2 snap-x snap-mandatory">

                        @foreach($properti->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto->path) }}"
                                 class="h-64 w-96 object-cover rounded-xl shadow flex-shrink-0 snap-center">
                        @endforeach

                    </div>
                @else
                    <div class="h-64 flex items-center justify-center text-gray-400">
                        Tidak ada foto
                    </div>
                @endif

            </div>

            <div class="bg-white rounded-2xl shadow-sm p-1 text-center">
                <p class="text-sm text-gray-500 mb-3 font-inria">
                    Diposting {{ $properti->created_at->diffForHumans() }}
                </p>
            </div>

            {{-- ================= BUTTON AREA ================= --}}
            <div class="space-y-4">

                <div class="flex gap-4">

                    {{-- FORM TOLAK --}}
                    <form method="POST"
                        action="{{ route('admin.proses', [$properti->properti_id, 'tolak']) }}"
                        class="w-1/2">
                        @csrf

                        <button type="button"
                                onclick="toggleAlasan()"
                                class="w-full bg-red-600 hover:bg-red-700
                                    text-white py-3 rounded-xl
                                    text-sm font-semibold
                                    transition duration-300 shadow-sm cursor-pointer font-inria">
                            Tolak Properti
                        </button>

                        {{-- FIELD ALASAN --}}
                        <div id="fieldAlasan" class="hidden mt-4 space-y-3">

                            <textarea name="alasan_penolakan"
                                    rows="4"
                                    required
                                    placeholder="Masukkan alasan penolakan..."
                                    class="w-full border border-red-300 rounded-xl px-4 py-3 text-sm
                                            focus:outline-none focus:ring-2 focus:ring-red-500 font-inria"></textarea>

                            <button type="submit"
                                    class="w-full bg-red-700 hover:bg-red-800
                                        text-white py-2 rounded-xl
                                        text-sm font-semibold transition cursor-pointer font-inria">
                                Konfirmasi Penolakan
                            </button>

                        </div>
                    </form>


                    {{-- FORM SETUJUI --}}
                    <form method="POST"
                        action="{{ route('admin.proses', [$properti->properti_id, 'setujui']) }}"
                        class="w-1/2">
                        @csrf

                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700
                                    text-white py-3 rounded-xl
                                    text-sm font-semibold
                                    transition duration-300 shadow-sm cursor-pointer font-inria">
                            Verifikasi Properti
                        </button>
                    </form>

                </div>

            </div>

        </div>



        {{-- ================= RIGHT ================= --}}
        <div class="space-y-6">

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-lg font-semibold mb-6 font-inria">
                    {{ $properti->nama_properti }}
                </h3>

                <div class="space-y-4 text-sm">

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-semibold text-gray-700 mb-1 font-inria">Lokasi</p>
                        <p class="text-gray-600">{{ $properti->lokasi }}</p>
                    </div>

                    {{-- INFO --}}
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <h3 class="font-semibold text-gray-700 mb-4 font-inria">
                            Informasi Properti
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">

                            <div class="p-1 rounded-xl bg-gray-50">
                                <p class="text-gray-700 text-xs font-inria">Tipe</p>
                                <p class="font-semibold text-gray-600">
                                    {{ ucfirst($properti->tipe_properti ?? '-') }}
                                </p>
                            </div>

                            <div class="p-1 rounded-xl bg-gray-50">
                                <p class="text-gray-700 text-xs font-inria">Luas</p>
                                <p class="font-semibold text-gray-600">
                                    {{ $properti->luas_tanah ?? '-' }} m²
                                </p>
                            </div>

                            <div class="p-1 rounded-xl bg-gray-50">
                                <p class="text-gray-700 text-xs font-inria">Kamar</p>
                                <p class="font-semibold text-gray-600">
                                    {{ $properti->jumlah_kamar ?? '-' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-semibold text-gray-700 mb-1 font-inria">Fasilitas</p>

                        <ul class="list-disc list-inside text-gray-600 grid grid-cols-2 sm:grid-cols-3 gap-y-1 gap-x-4">
                            @foreach(explode(',', $properti->fasilitas) as $item)
                                @if(trim($item) !== '')
                                    <li>{{ trim($item) }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-semibold text-gray-700 mb-1 font-inria">Harga</p>
                        <p class="text-gray-800 font-semibold">
                            Rp {{ number_format($properti->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="bg-white p-4 sm:p-5 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-semibold text-gray-700 mb-1 font-inria">Deskripsi</p>
                        <p class="text-gray-600  leading-tight break-words">{{ $properti->deskripsi }}</p>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-semibold text-gray-700 mb-1 font-inria">Kontak WhatsApp</p>
                        <p class="text-gray-600">{{ $properti->kontak_whatsapp }}</p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- Script Toggle --}}
<script>
function toggleAlasan() {
    const field = document.getElementById('fieldAlasan');
    field.classList.toggle('hidden');
}
</script>

@endsection
