<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inria+Serif:wght@400;600;700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Tuan Tanah')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 flex flex-col">

<nav class="bg-[#151541] text-white shadow-lg sticky top-0 z-50 font-inria">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">

            <a href="{{ route('pemilik.beranda') }}" class="text-xl font-bold tracking-wide">
                Tuan Tanah
            </a>

            @php
                $menus = [
                    ['route' => 'pemilik.beranda', 'label' => 'Beranda'],
                    ['route' => 'pemilik.upload', 'label' => 'Upload'],
                    ['route' => 'pemilik.pembayaran', 'label' => 'Pembayaran'],
                    ['route' => 'pemilik.riwayat', 'label' => 'Riwayat'],
                ];
            @endphp

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-6 text-sm font-semibold">

                @foreach($menus as $menu)
                    @php $active = request()->routeIs($menu['route'].'*'); @endphp
                    <a href="{{ route($menu['route']) }}"
                       class="relative px-2 py-1 transition duration-300
                       {{ $active
                          ? 'text-white border-b-2 border-white'
                          : 'text-gray-300 hover:text-white' }}">
                        {{ $menu['label'] }}
                    </a>
                @endforeach

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-gray-300 hover:text-red-400 transition cursor-pointer">
                        Keluar
                    </button>
                </form>

            </div>

            {{-- Mobile Hamburger --}}
            <button id="menuBtn"
                    class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg
                           hover:bg-white/10 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>
    </div>

    {{-- Mobile Dropdown --}}
    <div id="mobileMenu"
         class="md:hidden hidden bg-[#1c1c5a] border-t border-white/10">

        <div class="flex flex-col px-6 py-4 space-y-3 text-sm font-semibold">

            @foreach($menus as $menu)
                @php $active = request()->routeIs($menu['route'].'*'); @endphp
                <a href="{{ route($menu['route']) }}"
                   class="py-2 transition
                   {{ $active
                        ? 'text-white'
                        : 'text-gray-300 hover:text-white' }}">
                    {{ $menu['label'] }}
                </a>
            @endforeach

            <div class="border-t border-white/10 my-2"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="text-left text-red-300 hover:text-red-400 transition cursor-pointer">
                    Keluar
                </button>
            </form>

        </div>
    </div>

</nav>


{{-- Main Content --}}
<main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    @yield('content')
</main>


<footer class="bg-[#151541] text-white mt-16 font-inria">
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="flex flex-col md:flex-row justify-between gap-10">

            <div class="max-w-md">
                <h2 class="text-2xl font-semibold">Tuantanah.com</h2>
                <p class="mt-4 text-gray-300 leading-relaxed text-sm">
                    Tuantanah.com adalah platform pemasaran properti terpercaya yang
                    membantu pelanggan menemukan properti terbaik dengan
                    proses yang cepat, aman, dan transparan di seluruh Indonesia.
                </p>
            </div>

            <div class="text-sm text-gray-300">
                <h3 class="text-lg font-semibold text-white mb-4">Hubungi Kami</h3>
                <p>Alamat: Jl. Kaliurang KM 12 No. 34, Sleman, Yogyakarta 56789</p>
                <p class="mt-2">Telepon: +62 812-3456-7890</p>
                <p class="mt-2">Email: info@tuantanah.com</p>
                <p class="mt-2">Jam Operasional: Senin – Sabtu, 09.00 – 17.00 WIB</p>
            </div>

        </div>

        <div class="border-t border-gray-600 my-8"></div>

        <div class="text-center text-sm text-gray-400 tracking-wide">
            <p>&copy; 2026 Tuantanah.com. Semua hak cipta dilindungi.</p>
        </div>

    </div>
</footer>


{{-- Toggle Script --}}
<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    menuBtn.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });
</script>

</body>
</html>
