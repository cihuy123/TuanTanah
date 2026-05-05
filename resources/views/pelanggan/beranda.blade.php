@extends('layouts.pelanggan')

@section('title', 'Beranda')

@section('content')

<section class="relative h-[360px] overflow-hidden">

    @if($banner && $banner->gambar_banner)

        {{-- BANNER DARI ADMIN --}}
        <div class="relative w-full h-full">
            <img
                src="{{ asset('storage/' . $banner->gambar_banner) }}"
                class="w-full h-full object-cover scale-105"
                alt="Banner">

            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
        </div>

    @else

        {{-- HERO DEFAULT --}}
        <div class="relative w-full h-full bg-gradient-to-br from-[#0f172a] via-indigo-800 to-[#1e1b4b] flex items-center justify-center text-center px-6 overflow-hidden">

            <div class="absolute w-72 h-72 bg-indigo-500/30 rounded-full blur-3xl -top-16 -left-16 animate-pulse"></div>
            <div class="absolute w-72 h-72 bg-blue-400/20 rounded-full blur-3xl -bottom-16 -right-16 animate-pulse"></div>

            <div class="relative z-10 max-w-2xl text-white">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-4">
                    Temukan Properti Impian Anda
                </h1>

                <p class="text-gray-300 text-base md:text-lg leading-relaxed font-inria">
                    Platform terpercaya untuk menemukan rumah, tanah, dan properti terbaik
                    dengan proses aman dan transparan.
                </p>
            </div>

        </div>

    @endif

</section>


{{-- SECTION FREEMIUM --}}
<section class="relative py-15 bg-gradient-to-br from-indigo-50 via-white to-blue-50 overflow-hidden">

    {{-- decorative blur --}}
    <div class="absolute -top-32 -left-32 w-[450px] h-[450px] bg-indigo-400/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-32 -right-32 w-[450px] h-[450px] bg-blue-400/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 gap-20 items-center">

            {{-- LEFT SIDE --}}
            <div>

                <span class="inline-block text-xs font-semibold tracking-widest text-indigo-700 bg-indigo-300 px-4 py-2 rounded-full mb-6">
                    PROGRAM MITRA
                </span>

                <h2 class="text-4xl font-bold tracking-tight text-gray-900 mb-6 leading-tight font-inria">
                    Ingin Menjual Properti Anda?
                </h2>

                <p class="text-gray-700 mb-10 leading-relaxed text-lg font-inria">
                    Bergabung sebagai mitra dan jangkau lebih banyak calon pembeli.
                    Sistem kami transparan, aman, dan dirancang untuk membantu
                    properti Anda lebih cepat terjual.
                </p>

                <div class="space-y-8">

                    {{-- Feature 1 --}}
                    <div class="group flex items-start gap-5">

                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl
                                    bg-gradient-to-br from-emerald-400 to-emerald-600
                                    text-white shadow-lg
                                    group-hover:scale-110 transition duration-300">

                            {{-- Sparkle / Success Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                        </div>

                        <div>
                            <p class="font-bold text-gray-900 text-lg font-inria">
                                Upload Pertama Tanpa Biaya
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed font-inria">
                                Mulai memasarkan properti Anda tanpa komitmen di awal.
                            </p>
                        </div>

                    </div>


                    {{-- Feature 2 --}}
                    <div class="group flex items-start gap-5">

                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl
                                    bg-gradient-to-br from-indigo-500 to-indigo-700
                                    text-white shadow-lg
                                    group-hover:scale-110 transition duration-300">

                            {{-- Shield Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z" />
                            </svg>

                        </div>

                        <div>
                            <p class="font-bold text-gray-900 text-lg font-inria">
                                Sistem Aman & Terverifikasi
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed font-inria">
                                Proses transparan yang meningkatkan kepercayaan calon pembeli.
                            </p>
                        </div>

                    </div>


                    {{-- Feature 3 --}}
                    <div class="group flex items-start gap-5">

                        <div class="w-12 h-12 flex items-center justify-center rounded-2xl
                                    bg-gradient-to-br from-blue-500 to-blue-700
                                    text-white shadow-lg
                                    group-hover:scale-110 transition duration-300">

                            {{-- Star / Featured Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.036 6.26a1 1 0 00.95.69h6.588c.969 0 1.371 1.24.588 1.81l-5.33 3.872a1 1 0 00-.364 1.118l2.036 6.26c.3.921-.755 1.688-1.538 1.118l-5.33-3.872a1 1 0 00-1.176 0l-5.33 3.872c-.783.57-1.838-.197-1.538-1.118l2.036-6.26a1 1 0 00-.364-1.118L.927 11.687c-.783-.57-.38-1.81.588-1.81h6.588a1 1 0 00.95-.69l2.036-6.26z" />
                            </svg>

                        </div>

                        <div>
                            <p class="font-bold text-gray-900 text-lg font-inria">
                                Visibilitas Maksimal
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed font-inria">
                                Tampilkan properti sebagai unggulan dan jangkau lebih banyak calon pembeli.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="mt-12">
                    <a href="{{ route('daftar') }}"
                       class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-800 to-blue-700
                              text-white px-8 py-4 rounded-2xl
                              text-sm font-semibold shadow-xl
                              hover:shadow-2xl hover:-translate-y-1
                              active:scale-95 transition duration-300 font-inria">
                        Mulai Sekarang →
                    </a>
                </div>

            </div>

            {{-- RIGHT SIDE CARD --}}
            <div class="relative">

                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-800 to-blue-800 rounded-3xl blur-2xl opacity-30"></div>

                <div class="relative bg-gradient-to-br from-indigo-800 to-blue-800 text-white rounded-3xl p-14 shadow-2xl">

                    <div class="text-center">

                        <p class="text-xs uppercase tracking-widest text-indigo-200 mb-4 font-inria">
                            Freemium Access
                        </p>

                        <h3 class="text-6xl font-bold mb-6 font-inria">
                            1x Gratis
                        </h3>

                        <p class="text-indigo-100 text-base leading-relaxed mb-8 font-inria">
                            Mulai tanpa risiko. Rasakan kemudahan sistem kami
                            sebelum berkomitmen lebih lanjut.
                        </p>

                        <div class="h-px bg-white/30 mb-8"></div>

                        <p class="text-sm text-indigo-200">
                            Transparan • Aman • Terpercaya
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>



{{-- CTA IKLAN --}}
<section class="py-15 bg-gray-100">
    <div class="max-w-7xl mx-auto px-6">

        <div class="relative bg-gradient-to-r from-[#203461] to-indigo-800
                    rounded-3xl px-12 py-14 text-white shadow-2xl overflow-hidden">

            <div class="absolute -top-16 -right-16 w-80 h-80 bg-indigo-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">

                <div class="max-w-xl">
                    <h2 class="text-3xl font-bold tracking-tight mb-4 font-inria">
                        Ingin Properti Anda Lebih Dilirik?
                    </h2>

                    <p class="text-gray-300 text-sm md:text-base leading-relaxed font-inria">
                        Pasang banner promosi atau jadikan properti Anda sebagai
                        <span class="font-semibold text-white">Properti Unggulan</span>
                        agar tampil di halaman utama dan menjangkau lebih banyak calon pembeli.
                    </p>
                </div>

                @php
                    $pesan = urlencode("Halo Admin TuanTanah, saya ingin memasang banner atau menjadikan properti saya sebagai Properti Unggulan. Mohon informasi lebih lanjut.");
                @endphp

                <a href="https://wa.me/6281234567890?text={{ $pesan }}"
                   target="_blank"
                   class="inline-flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600
                          px-7 py-3 rounded-2xl text-white font-semibold text-sm
                          shadow-lg hover:shadow-2xl transition duration-300 whitespace-nowrap font-inria">
                    Hubungi Sekarang
                </a>

            </div>
        </div>

    </div>
</section>



{{-- PROPERTI UNGGULAN --}}
<section class="bg-white py-15">
    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center mb-14">
            <h2 class="text-3xl font-bold font-inria text-gray-900">
                Daftar Properti Unggulan
            </h2>

            <a href="{{ route('pelanggan.properti') }}"
               class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition font-inria">
                Lihat Semua →
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-10">

            @forelse($properti as $item)
            <a href="{{ route('pelanggan.detail', $item->properti_id) }}"
                class="group block bg-white rounded-3xl overflow-hidden border border-gray-100
                        shadow-sm hover:shadow-2xl transition duration-300 hover:-translate-y-2">

                {{-- BADGE UNGGULAN --}}
                <div class="relative overflow-hidden">
                    @php
                        $foto = $item->fotos->first();
                    @endphp

                    <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
                        class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-700 text-xs px-3 py-1 rounded-full shadow font-bold font-inria">
                            {{ ucfirst($item->tipe_properti ?? 'properti') }}
                        </div>
                    <div class="absolute top-3 left-3 bg-gradient-to-r from-yellow-600 to-orange-400 text-white text-xs px-3 py-1 rounded-full shadow font-semibold">
                        ⭐ Properti Unggulan
                    </div>
                </div>

                <div class="p-7 text-sm">

                    <h3 class="font-semibold text-lg text-gray-900 mb-1 font-inria group-hover:text-indigo-600 transition">
                        {{ $item->nama_properti }}
                    </h3>

                    <p class="text-gray-500 text-xs mb-1">
                        {{ $item->lokasi }}
                    </p>

                    <p class="text-gray-500 text-xs truncate">
                        {{ implode(' • ', array_map('trim', explode(',', $item->fasilitas))) }}
                    </p>

                    <p class="font-bold text-indigo-600 text-lg mt-5">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

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

@endsection
