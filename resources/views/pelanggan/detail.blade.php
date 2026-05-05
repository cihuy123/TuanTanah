@extends('layouts.pelanggan')

@section('title', $properti->nama_properti)

@section('content')

<div class="max-w-7xl mx-auto px-4 mt-6 mb-24">

    <a href="{{ url()->previous() }}"
        class="inline-flex items-center gap-2 mb-8 px-5 py-2.5
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


    {{-- HERO SLIDER --}}
    <div class="relative rounded-3xl overflow-hidden shadow-xl mb-8">

        <div id="slider" class="flex transition-transform duration-500">

            @if($properti->fotos && $properti->fotos->count() > 0)
                @foreach($properti->fotos as $foto)
                    <img src="{{ asset('storage/' . $foto->path) }}"
                         class="w-full h-[260px] sm:h-[400px] object-cover flex-shrink-0">
                @endforeach
            @else
                <div class="w-full h-[260px] sm:h-[400px] bg-gray-200 flex items-center justify-center">
                    Tidak ada foto
                </div>
            @endif

        </div>

        {{-- OVERLAY --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

        {{-- NAV --}}
        <button onclick="prevSlide()"
            class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white px-3 py-1 rounded-full shadow cursor-pointer">
            ‹
        </button>

        <button onclick="nextSlide()"
            class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/70 hover:bg-white px-3 py-1 rounded-full shadow cursor-pointer">
            ›
        </button>

        {{-- DOT --}}
        <div id="dots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2"></div>

        {{-- TEXT --}}
        <div class="absolute bottom-0 left-0 p-6 text-white">

            <h1 class="text-2xl sm:text-3xl font-bold font-inria">
                {{ $properti->nama_properti }}
            </h1>

            <p class="flex items-center gap-2 text-sm opacity-90 mt-1">

                {{-- ICON LOCATION --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>

                {{ $properti->lokasi }}
            </p>

        </div>

        {{-- PRICE --}}
        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-5 py-2 rounded-full shadow-lg">
            <p class="text-indigo-600 font-bold text-lg">
                Rp {{ number_format($properti->harga, 0, ',', '.') }}
            </p>
        </div>

    </div>


    {{-- GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- LEFT --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- INFO --}}
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-4 font-inria">
                    Informasi Properti
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">

                    <div class="p-1 rounded-xl bg-gray-50">
                        <p class="text-gray-400 text-xs font-inria">Tipe</p>
                        <p class="font-semibold text-gray-600">
                            {{ ucfirst($properti->tipe_properti ?? '-') }}
                        </p>
                    </div>

                    <div class="p-1 rounded-xl bg-gray-50">
                        <p class="text-gray-400 text-xs font-inria">Luas</p>
                        <p class="font-semibold text-gray-600">
                            {{ $properti->luas_tanah ?? '-' }} m²
                        </p>
                    </div>

                    <div class="p-1 rounded-xl bg-gray-50">
                        <p class="text-gray-400 text-xs font-inria">Kamar</p>
                        <p class="font-semibold text-gray-400">
                            {{ $properti->jumlah_kamar ?? '-' }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- FASILITAS --}}
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-4 font-inria">Fasilitas</h3>

                <div class="flex flex-wrap gap-3">
                    @foreach(explode(',', $properti->fasilitas) as $item)
                        @if(trim($item) !== '')
                            <span class="px-4 py-2 text-xs font-medium
                                         bg-indigo-50 text-indigo-600
                                         rounded-full shadow-sm">
                                {{ trim($item) }}
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- DESKRIPSI --}}
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-3 font-inria">Deskripsi</h3>
                <p class="text-gray-600  leading-tight break-words">{{ $properti->deskripsi }}</p>
            </div>

            {{-- MAP --}}
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm">
                <h3 class="font-semibold text-gray-800 mb-3 font-inria">Lokasi</h3>

                <iframe
                    src="https://www.google.com/maps?q={{ urlencode($properti->lokasi) }}&output=embed"
                    class="w-full h-64 rounded-xl border"
                    loading="lazy">
                </iframe>
            </div>

        </div>


        {{-- RIGHT --}}
        <div class="space-y-6">

            <div class="bg-white rounded-xl p-4 shadow-xl border border-gray-200 sticky top-6">

                <p class="text-sm text-gray-500 mb-3 font-inria">
                    Diposting {{ $properti->created_at->diffForHumans() }}
                </p>

                {{-- WA BUTTON --}}
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $properti->kontak_whatsapp) }}"
                   target="_blank"
                   class="w-full flex items-center justify-center gap-3
                          bg-green-600 hover:bg-green-700
                          text-white py-3 rounded-xl
                          font-semibold shadow-md hover:shadow-lg
                          transition active:scale-95 font-inria">

                    {{-- Icon WhatsApp --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        class="w-5 h-5 fill-white">
                        <path d="M16 .396C7.164.396 0 7.56 0 16.396c0 2.89.756 5.714 2.188 8.2L.24 31.76l7.343-1.92A15.932 15.932 0 0016 32c8.836 0 16-7.164 16-16.004C32 7.56 24.836.396 16 .396zm0 29.25a13.17 13.17 0 01-6.704-1.842l-.48-.285-4.355 1.137 1.16-4.245-.313-.5A13.123 13.123 0 012.83 16.396C2.83 8.964 8.568 3.226 16 3.226c7.432 0 13.17 5.738 13.17 13.17 0 7.432-5.738 13.17-13.17 13.17zm7.207-9.905c-.395-.198-2.336-1.152-2.698-1.282-.362-.13-.626-.198-.89.198-.263.395-1.02 1.282-1.25 1.547-.23.263-.46.296-.856.098-.395-.198-1.668-.615-3.177-1.962-1.174-1.047-1.966-2.34-2.196-2.736-.23-.395-.024-.608.174-.805.178-.177.395-.46.593-.69.198-.23.263-.395.395-.658.13-.263.065-.493-.033-.69-.098-.198-.89-2.14-1.217-2.93-.32-.77-.645-.666-.89-.678-.23-.01-.493-.013-.756-.013-.263 0-.69.098-1.052.493-.362.395-1.38 1.347-1.38 3.285 0 1.938 1.412 3.81 1.608 4.075.198.263 2.78 4.245 6.737 5.954.942.406 1.677.648 2.25.83.945.3 1.805.258 2.485.157.758-.113 2.336-.955 2.667-1.878.33-.923.33-1.715.23-1.878-.098-.165-.362-.263-.758-.46z"/>
                    </svg>

                    Hubungi via WhatsApp
                </a>

            </div>

        </div>

    </div>

</div>

@endsection


{{-- SLIDER SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    let index = 0;
    const slider = document.getElementById('slider');
    const dotsContainer = document.getElementById('dots');

    if (!slider) return;

    const total = slider.children.length;

    function updateDots() {
        dotsContainer.innerHTML = '';
        for (let i = 0; i < total; i++) {
            const dot = document.createElement('div');
            dot.className = 'w-2.5 h-2.5 rounded-full cursor-pointer ' +
                (i === index ? 'bg-white' : 'bg-white/50');
            dot.onclick = () => showSlide(i);
            dotsContainer.appendChild(dot);
        }
    }

    function showSlide(i) {
        index = (i + total) % total;
        slider.style.transform = `translateX(-${index * 100}%)`;
        updateDots();
    }

    window.nextSlide = () => showSlide(index + 1);
    window.prevSlide = () => showSlide(index - 1);

    updateDots();
});
</script>
