@extends('layouts.pemilik')

@section('title', 'Detail Pembayaran')

@section('content')

<div class="max-w-xl mx-auto mb-20 px-4">

    <a href="{{ route('pemilik.pembayaran') }}"
       class="inline-flex items-center gap-2 mb-8 px-5 py-2.5
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

    <h2 class="text-2xl font-semibold text-center font-inria mb-4 text-gray-800">
        Detail Pembayaran
    </h2>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">

        {{-- STATUS --}}
        <div class="mb-4">

            @if($properti->status_pembayaran == 'pending' && is_null($properti->bukti_pembayaran))
                <span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full font-semibold font-inria">
                    Belum Dibayar
                </span>

            @elseif($properti->status_pembayaran == 'ditolak')
                <span class="bg-red-100 text-red-600 text-xs px-3 py-1 rounded-full font-semibold font-inria">
                    Ditolak
                </span>
            @endif

        </div>

        {{-- PROPERTI --}}
    <div class="flex items-center gap-4 mb-4">
        @php
            $foto = $properti->fotos->first();
        @endphp

        <img src="{{ $foto ? asset('storage/' . $foto->path) : asset('images/no-image.png') }}"
            class="w-16 h-16 rounded-lg object-cover">

        <div>
            <p class="text-gray-500 text-xs font-inria">Properti</p>
            <p class="font-semibold text-gray-800 font-inria">
                {{ $properti->nama_properti }}
            </p>
        </div>
    </div>

        <hr class="my-4 border-gray-200">

        {{-- INFORMASI PEMBAYARAN --}}
        <div class="space-y-4 text-sm">

            <div>
                <p class="text-gray-500 font-inria font-bold">Biaya Upload</p>
                <p class="text-2xl font-bold text-indigo-600 font-inria">
                    Rp 10.000
                </p>
                <p class="text-xs text-gray-400">
                    Biaya untuk mempublikasikan properti
                </p>
            </div>

            <div>
                <p class="text-gray-500 font-inria font-bold">Transfer ke</p>
                <p class="font-medium text-gray-800">
                    BCA 123456789 <br>
                    a.n TuanTanah
                </p>
            </div>

        </div>

        <hr class="my-4 border-gray-200">
        @if($properti->status_pembayaran == 'ditolak')
            <div class="bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded mb-4">
                <p class="font-semibold mb-1">Alasan Penolakan:</p>
                <p>{{ $properti->alasan_penolakan_pembayaran }}</p>
            </div>
        @endif
        {{-- FORM UPLOAD --}}
        <form method="POST"
              action="{{ route('pemilik.upload.bukti', $properti->properti_id) }}"
              enctype="multipart/form-data"
              id="formBukti"
              class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2 font-inria">
                    Upload Bukti Transfer
                </label>

                <input type="file"
                       name="bukti_pembayaran"
                       id="buktiInput"
                       accept=".jpg,.jpeg,.png,.pdf"
                       class="hidden"
                       onchange="document.getElementById('namaBukti').innerText = this.files[0]?.name || 'Belum ada file dipilih'">

                <label for="buktiInput"
                       class="flex items-center h-[44px] border rounded-lg px-4
                              cursor-pointer transition
                              {{ $errors->has('bukti_pembayaran')
                                  ? 'border-red-400 bg-red-50'
                                  : 'border-gray-200 bg-gray-50 hover:bg-gray-100' }}">

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

                    <span id="namaBukti"
                          class="text-sm text-gray-500 truncate">
                        Belum ada file dipilih
                    </span>

                </label>

                {{-- INFO --}}
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">
                    Format: JPG, JPEG, PNG, PDF <br>
                    Maksimal: 2MB <br>
                    Pastikan bukti terlihat jelas.
                </p>

                {{-- ERROR --}}
                <div class="min-h-[18px] mt-1">
                    @error('bukti_pembayaran')
                        <p class="text-red-500 text-xs">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <button type="submit" id="btnBukti"
                class="w-full
                {{ $properti->status_pembayaran == 'ditolak' ? 'bg-red-500 hover:bg-red-600' : 'bg-indigo-600 hover:bg-indigo-700' }}
                text-white py-3 rounded-xl text-sm font-semibold
                shadow-md hover:shadow-lg transition duration-300 cursor-pointer font-inria">

                {{ $properti->status_pembayaran == 'ditolak' ? 'Upload Ulang Bukti' : 'Kirim Bukti' }}

            </button>

        </form>

    </div>

</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formBukti');
    const btn = document.getElementById('btnBukti');

    console.log(form, btn); 

    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerText = 'Mengirim...';
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        });
    }
});
</script>
