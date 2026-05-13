@extends('layouts.admin')

@section('title', 'Upload Banner')

@section('content')

<div class="max-w-4xl mx-auto mb-20 px-4">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sm:p-10">

        <h2 class="text-center text-2xl font-semibold text-gray-800 mb-8 sm:mb-10 font-inria">
            Lengkapi form ini untuk mengupload Banner
        </h2>

        <form method="POST"
              action="{{ route('admin.banner.store') }}"
              enctype="multipart/form-data"
              class="space-y-8">

            @csrf

            {{-- GRID RESPONSIVE --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-start">

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2 font-inria">
                        Foto Banner
                    </label>

                    <div class="relative">
                        <input type="file"
                               name="gambar_banner"
                               id="gambar_banner"
                               accept=".jpg,.jpeg,.png,.webp"
                               class="hidden"
                               onchange="document.getElementById('namaFile').innerText = this.files[0]?.name || 'Belum ada file dipilih'">

                        <label for="gambar_banner"
                               class="flex items-center border border-gray-200 rounded-lg bg-gray-50 px-3 py-3 cursor-pointer hover:bg-gray-100 transition">

                            <svg class="w-4 h-4 text-gray-400 mr-2"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M7 3h6l5 5v13a1 1 0 01-1 1H7a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M13 3v5h5"/>
                            </svg>

                            <span id="namaFile"
                                  class="text-xs text-gray-500 truncate">
                                Belum ada file dipilih
                            </span>
                        </label>
                    </div>

                    <div class="mt-3 text-[12px] text-gray-500 leading-relaxed">
                        <p>Format: JPG, PNG, atau JPEG</p>
                        <p>Ukuran maksimal: 5MB</p>
                        <p>Ukuran ideal: 1920 × 360 px (rasio 16:3)</p>
                    </div>

                    <div class="min-h-[20px]">
                        @error('gambar_banner')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                {{-- TANGGAL MULAI --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2 font-inria">
                        Dimulai
                    </label>

                    <input type="date"
                           name="tanggal_mulai"
                           value="{{ old('tanggal_mulai') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-3 bg-gray-50 text-xs
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  focus:border-indigo-500 transition cursor-pointer">

                    <div class="min-h-[20px]">
                        @error('tanggal_mulai')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>


                {{-- TANGGAL SELESAI --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2 font-inria">
                        Berakhir
                    </label>

                    <input type="date"
                           name="tanggal_selesai"
                           value="{{ old('tanggal_selesai') }}"
                           class="w-full border border-gray-200 rounded-lg px-3 py-3 bg-gray-50 text-xs
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  focus:border-indigo-500 transition cursor-pointer">

                    <div class="min-h-[20px]">
                        @error('tanggal_selesai')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="pt-6">
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg
                               text-sm font-semibold shadow-md hover:shadow-lg transition duration-200 cursor-pointer font-inria">
                    Upload Banner
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
