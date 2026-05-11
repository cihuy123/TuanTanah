@extends('layouts.pemilik')

@section('title', 'Ubah Data')

@section('content')

<div class="mb-20 max-w-5xl mx-auto px-4">

    <a href="{{ url()->previous() }}"
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

    <h2 class="text-2xl font-semibold text-center mb-8 text-gray-800 font-inria">
        Ubah Data Properti
    </h2>
    <div class="mb-6 p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm text-center font-inria">
        Jika Anda mengubah data properti, properti akan ditinjau ulang oleh admin sebelum ditampilkan kembali.
    </div>

    <form method="POST"
          action="{{ route('pemilik.update', $properti->properti_id) }}"
          enctype="multipart/form-data"
          id="formEdit">

        @csrf
        @method('PUT')

        {{-- ================= FOTO ================= --}}
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm mb-10 max-w-4xl mx-auto">

            <label class="block text-sm font-semibold text-gray-700 mb-3 text-center font-inria">
                Foto Properti
            </label>

            <div class="mb-5 p-3 rounded-xl bg-yellow-100 text-yellow-700 text-xs text-center font-inria">
                ⚠️ Upload foto baru akan menghapus semua foto lama
            </div>

            <div class="flex justify-center">

            <div id="previewContainer"
                class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth px-6 pb-4 max-w-3xl">

                @foreach($properti->fotos as $foto)
                    <div class="snap-center flex-shrink-0">
                        <img src="{{ asset('storage/' . $foto->path) }}"
                            class="h-56 w-96 object-cover rounded-2xl shadow-md">
                    </div>
                @endforeach

            </div>

        </div>

            {{-- INPUT --}}
            <input type="file"
                name="foto_properti[]"
                id="fotoInput"
                multiple
                class="hidden"
                accept="image/*">

            <button type="button"
                onclick="document.getElementById('fotoInput').click()"
                class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700
                    text-white py-3 rounded-xl text-sm font-semibold shadow cursor-pointer font-inria">
                Perbarui Foto
            </button>

        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl">
                <ul class="text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ================= FORM ================= --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Nama Properti</label>
                    <input type="text" name="nama_properti"
                        value="{{ old('nama_properti', $properti->nama_properti) }}"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Lokasi</label>
                    <input type="text" name="lokasi"
                        value="{{ old('lokasi', $properti->lokasi) }}"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Tipe Properti</label>
                    <select name="tipe_properti" id="tipe"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition cursor-pointer font-inria">
                        <option value="">Pilih tipe</option>
                        <option value="rumah" {{ old('tipe_properti', $properti->tipe_properti)=='rumah' ? 'selected' : '' }}>Rumah</option>
                        <option value="tanah" {{ old('tipe_properti', $properti->tipe_properti)=='tanah' ? 'selected' : '' }}>Tanah</option>
                        <option value="ruko" {{ old('tipe_properti', $properti->tipe_properti)=='ruko' ? 'selected' : '' }}>Ruko</option>
                        <option value="apartemen" {{ old('tipe_properti', $properti->tipe_properti)=='apartemen' ? 'selected' : '' }}>Apartemen</option>
                    </select>
                </div>

                {{-- KAMAR --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Jumlah Kamar</label>
                    <input type="text"
                        inputmode="numeric"
                        maxlength="2"
                        name="jumlah_kamar"
                        id="kamar"
                        value="{{ old('jumlah_kamar', $properti->jumlah_kamar) }}"
                        placeholder="Contoh: 3"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <p id="kamarInfo" class="text-xs text-gray-400 mt-1 hidden">
                        Tidak berlaku untuk tipe tanah
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Luas Tanah</label>
                    <input type="text"
                            inputmode="numeric"
                            maxlength="5"
                            name="luas_tanah"
                            value="{{ old('luas_tanah', $properti->luas_tanah) }}"
                            placeholder="Contoh: 120"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Harga</label>
                    <input type="text"
                            name="harga"
                            inputmode="numeric"
                            maxlength="12"
                            value="{{ old('harga', (int) $properti->harga) }}"
                            placeholder="Contoh: 750000000"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Fasilitas</label>
                    <input type="text" name="fasilitas"
                        value="{{ old('fasilitas', $properti->fasilitas) }}"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                </div>

                {{-- WHATSAPP --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">WhatsApp</label>
                    <input type="text" name="kontak_whatsapp" id="wa"
                        value="{{ old('kontak_whatsapp', $properti->kontak_whatsapp) }}"
                        class="w-full h-11 border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <p id="waError" class="text-red-500 text-xs mt-1 hidden">
                        Nomor harus 11 - 15 digit angka
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 font-inria">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" maxlength="3000"
                        class="w-full border border-gray-200 rounded-lg px-4 text-sm
                                focus:outline-none focus:ring-2 focus:ring-indigo-500 transition py-3">{{ old('deskripsi', $properti->deskripsi) }}</textarea>
                </div>

            </div>

            <button type="submit" id="btnSubmit"
                disabled
                class="mt-6 w-full bg-gray-300 cursor-not-allowed
                       text-white py-3 rounded-xl font-semibold transition font-inria ">
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formEdit');
    const btn = document.getElementById('btnSubmit');

    const tipe = document.getElementById('tipe');
    const kamar = document.getElementById('kamar');
    const kamarInfo = document.getElementById('kamarInfo');

    const wa = document.getElementById('wa');
    const waError = document.getElementById('waError');

    const input = document.getElementById('fotoInput');
    const preview = document.getElementById('previewContainer');


    // ================= GET DATA CLEAN =================
    function getFormData() {
        const data = {};

        form.querySelectorAll('input, textarea, select').forEach(el => {

            if (el.type === 'file') {
                data[el.name] = el.files.length;
            } else {
                data[el.name] = (el.value || '').trim();
            }

        });

        return JSON.stringify(data);
    }

    const initialData = getFormData();


    // ================= CHANGE DETECT =================
    function isChanged() {
        return getFormData() !== initialData;
    }


    // ================= UPDATE BUTTON =================
    function updateBtn() {
        if (isChanged()) {
            btn.disabled = false;

            btn.classList.remove('bg-gray-300','cursor-not-allowed');
            btn.classList.add('bg-indigo-600','hover:bg-indigo-700','cursor-pointer');

        } else {
            btn.disabled = true;

            btn.classList.add('bg-gray-300','cursor-not-allowed');
            btn.classList.remove('bg-indigo-600','hover:bg-indigo-700','cursor-pointer');
        }
    }

    form.addEventListener('input', updateBtn);
    form.addEventListener('change', updateBtn);


    // ================= SUBMIT =================
    form.addEventListener('submit', function (e) {

        if (!isChanged()) {
            e.preventDefault();
            return;
        }

        btn.innerText = "Menyimpan perubahan...";
        btn.disabled = true;

        btn.classList.add('bg-gray-400','cursor-not-allowed');
        btn.classList.remove('bg-indigo-600','hover:bg-indigo-700','cursor-pointer');
    });


    // ================= FOTO PREVIEW =================
    if (input && preview) {
        input.addEventListener('change', function () {

            const files = Array.from(this.files);
            if (files.length === 0) return;

            preview.innerHTML = '';

            files.forEach((file, index) => {

                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();

                reader.onload = function (e) {

                    const wrapper = document.createElement('div');
                    wrapper.className = "snap-center flex-shrink-0 relative";

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = "h-56 w-96 object-cover rounded-2xl shadow-md";

                    const badge = document.createElement('div');
                    badge.innerText = index + 1;
                    badge.className = "absolute top-2 left-2 bg-black/60 text-white text-xs px-2 py-1 rounded";

                    wrapper.appendChild(img);
                    wrapper.appendChild(badge);

                    preview.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
        });
    }


    // ================= TIPE TANAH =================
    function toggleKamar() {
        if (tipe.value === 'tanah') {
            kamar.value = '';
            kamar.disabled = true;

            kamar.classList.add('bg-gray-100','cursor-not-allowed');
            kamarInfo.classList.remove('hidden');
        } else {
            kamar.disabled = false;

            kamar.classList.remove('bg-gray-100','cursor-not-allowed');
            kamarInfo.classList.add('hidden');
        }
    }

    tipe.addEventListener('change', toggleKamar);
    toggleKamar();


    // ================= WA VALIDATION =================
    wa.addEventListener('input', function () {

        this.value = this.value.replace(/[^0-9]/g, '').slice(0,15);

        if (this.value.length > 0 && this.value.length < 11) {
            waError.classList.remove('hidden');
            this.classList.add('border-red-500');
        } else {
            waError.classList.add('hidden');
            this.classList.remove('border-red-500');
        }
    });

});
</script>
