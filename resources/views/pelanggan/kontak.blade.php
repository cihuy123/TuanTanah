@extends('layouts.pelanggan')

@section('title', 'Kontak')

@section('content')

<div class="bg-gray-50 py-1">

    <div class="max-w-7xl mx-auto px-6">

        <h2 class="text-3xl font-bold font-inria text-center text-gray-800 mb-14">
            Informasi Kontak Kami
        </h2>

        <div class="grid md:grid-cols-4 gap-6 mb-20">

            <div class="bg-gradient-to-br from-[#151541] to-indigo-700 text-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition duration-300">
                <h3 class="font-semibold mb-2 font-inria">Nomor Telepon</h3>
                <p class="text-sm text-gray-200 font-inria">+62 812-3456-7890</p>
            </div>

            <div class="bg-gradient-to-br from-[#151541] to-indigo-700 text-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition duration-300">
                <h3 class="font-semibold mb-2 font-inria">Email</h3>
                <p class="text-sm text-gray-200 font-inria">info@tuantanah.com</p>
            </div>

            <div class="bg-gradient-to-br from-[#151541] to-indigo-700 text-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition duration-300">
                <h3 class="font-semibold mb-2 font-inria">Alamat</h3>
                <p class="text-sm text-gray-200 font-inria">
                    Jl. Kaliurang KM 12 No. 34, Sleman, Yogyakarta 56789
                </p>
            </div>

            <div class="bg-gradient-to-br from-[#151541] to-indigo-700 text-white rounded-2xl p-6 text-center shadow-md hover:shadow-xl transition duration-300">
                <h3 class="font-semibold mb-2 font-inria">Jam Operasional</h3>
                <p class="text-sm text-gray-200 font-inria">Senin – Sabtu, 09.00 – 17.00 WIB</p>
            </div>

        </div>

        <div class="grid md:grid-cols-2 gap-16">

            {{-- FORM KONTAK --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">

                <h3 class="text-xl font-semibold font-inria mb-2 text-gray-800">
                    Ada Pertanyaan? Hubungi Kami
                </h3>

                <p class="text-sm text-gray-500 mb-8 font-inria">
                    Isi form di bawah ini dan kami akan merespon dalam waktu singkat.
                </p>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg text-sm mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('kontak.kirim') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        <input type="text" name="nama" value="{{ old('nama') }}"
                            placeholder="Nama Lengkap"
                            class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-full
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500">

                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="Email"
                            class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-full
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <input type="number" name="telepon" value="{{ old('telepon') }}"
                        placeholder="Nomor Telepon"
                        class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-full
                               focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    <input type="text" name="subjek" value="{{ old('subjek') }}"
                        placeholder="Subjek"
                        class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-full
                               focus:outline-none focus:ring-2 focus:ring-indigo-500">

                    <textarea rows="4" name="pesan"
                        placeholder="Tulis pesan anda disini..."
                        class="border border-gray-200 rounded-lg px-4 py-2 text-sm w-full
                               focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('pesan') }}</textarea>

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg
                                   text-sm font-medium shadow-md hover:shadow-lg transition w-full cursor-pointer font-inria">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            {{-- KONTAK CEPAT --}}
            <div class="flex flex-col justify-center">

                <h3 class="text-xl font-semibold font-inria mb-6 text-gray-800">
                    Kontak Cepat
                </h3>

                @php
                    $pesan = urlencode("Halo Admin TuanTanah, saya tertarik untuk memasang iklan atau menjadikan properti saya sebagai Properti Unggulan. Mohon informasi lebih lanjut.");
                @endphp

                <a href="https://wa.me/6281234567890?text={{ $pesan }}"
                   target="_blank"
                   class="flex items-center justify-center gap-3 bg-green-500 hover:bg-green-600
                          text-white py-4 rounded-2xl text-sm font-semibold
                          shadow-md hover:shadow-xl transition duration-300 font-inria">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 32 32"
                        class="w-5 h-5 fill-white">
                        <path d="M16 .396C7.164.396 0 7.56 0 16.396c0 2.89.756 5.714 2.188 8.2L.24 31.76l7.343-1.92A15.932 15.932 0 0016 32c8.836 0 16-7.164 16-16.004C32 7.56 24.836.396 16 .396zm0 29.25a13.17 13.17 0 01-6.704-1.842l-.48-.285-4.355 1.137 1.16-4.245-.313-.5A13.123 13.123 0 012.83 16.396C2.83 8.964 8.568 3.226 16 3.226c7.432 0 13.17 5.738 13.17 13.17 0 7.432-5.738 13.17-13.17 13.17zm7.207-9.905c-.395-.198-2.336-1.152-2.698-1.282-.362-.13-.626-.198-.89.198-.263.395-1.02 1.282-1.25 1.547-.23.263-.46.296-.856.098-.395-.198-1.668-.615-3.177-1.962-1.174-1.047-1.966-2.34-2.196-2.736-.23-.395-.024-.608.174-.805.178-.177.395-.46.593-.69.198-.23.263-.395.395-.658.13-.263.065-.493-.033-.69-.098-.198-.89-2.14-1.217-2.93-.32-.77-.645-.666-.89-.678-.23-.01-.493-.013-.756-.013-.263 0-.69.098-1.052.493-.362.395-1.38 1.347-1.38 3.285 0 1.938 1.412 3.81 1.608 4.075.198.263 2.78 4.245 6.737 5.954.942.406 1.677.648 2.25.83.945.3 1.805.258 2.485.157.758-.113 2.336-.955 2.667-1.878.33-.923.33-1.715.23-1.878-.098-.165-.362-.263-.758-.46z"/>
                    </svg>

                    Chat via WhatsApp
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
