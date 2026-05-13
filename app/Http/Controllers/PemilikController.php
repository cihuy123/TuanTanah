<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Properti;
use App\Models\PropertiFoto;
use Illuminate\Support\Facades\DB;

class PemilikController extends Controller
{
    public function beranda()
    {
        $userId = Auth::id();

        $total = Properti::where('user_id', $userId)

            ->where(function ($q) {

                //  SUDAH BAYAR MENUNGGU VALIDASI
                $q->where(function ($sub) {
                    $sub->where('status_pembayaran', 'pending')
                        ->whereNotNull('bukti_pembayaran');
                })

                //  SUDAH VALID & BUKAN DITOLAK
                ->orWhere(function ($sub) {
                    $sub->where('status_pembayaran', 'valid')
                        ->whereIn('status', ['menunggu', 'disetujui']);
                });

            })

            ->count();

        //  BELUM BAYAR + DITOLAK PEMBAYARAN
        $menungguPembayaran = Properti::where('user_id', $userId)
            ->where(function($q){
                $q->where(function ($sub) {
                    $sub->where('status_pembayaran', 'pending')
                        ->whereNull('bukti_pembayaran');
                })
                ->orWhere('status_pembayaran', 'ditolak');
            })
            ->count();

        //  SUDAH BAYAR (MENUNGGU VALIDASI)
        $sudahBayar = Properti::where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->count();

        //  MENUNGGU VERIFIKASI ADMIN
        $menunggu = Properti::where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->where('status', 'menunggu')
            ->count();

        $disetujui = Properti::where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->where('status', 'disetujui')
            ->count();

        //  DITOLAK (HANYA VERIFIKASI PROPERTI)
        $ditolak = Properti::where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->where('status', 'ditolak')
            ->count();

        //  LIST PROPERTI (YANG SUDAH SIAP TAMPIL)
        $properti = Properti::with('fotos')
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('pemilik.beranda', compact(
            'total',
            'sudahBayar',
            'menungguPembayaran',
            'menunggu',
            'disetujui',
            'ditolak',
            'properti'
        ));
    }

    public function edit($id)
    {
        $properti = Properti::with('fotos')
            ->where('properti_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pemilik.ubahdata', compact('properti'));
    }

    public function update(Request $request, $id)
    {
        $properti = Properti::where('properti_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        //  BERSIHKAN INPUT
        $namaProperti = trim($request->nama_properti);
        $lokasi = trim($request->lokasi);

        $fasilitas = collect(explode(',', $request->fasilitas))
            ->map(fn($item) => trim($item))
            ->filter()
            ->implode(', ');

        $request->merge([
            'nama_properti' => $namaProperti,
            'lokasi' => $lokasi,
            'fasilitas' => $fasilitas,
        ]);

        $request->validate([

            'nama_properti' => [
                'required',
                'string',
                'max:255',
                'regex:/.*\S.*/'
            ],

            'lokasi' => [
                'required',
                'string',
                'max:255',
                'regex:/.*\S.*/'
            ],

            'fasilitas' => [
                'required',
                'string',
                'max:255',
                'regex:/.*\S.*/'
            ],

            'harga' => 'required|numeric|min:0|max:999999999999',

            'deskripsi' => [
                'required',
                'string',
                'max:3000',
                'regex:/.*\S.*/'
            ],

            'kontak_whatsapp' => 'required|digits_between:10,15',

            'tipe_properti' => 'required|in:rumah,tanah,ruko,apartemen',

            'luas_tanah' => 'nullable|numeric|min:0',

            'jumlah_kamar' => 'nullable|integer|min:0',

            //  MULTI FOTO
            'foto_properti' => 'nullable|array|max:5',

            'foto_properti.*' => [
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120'
            ]

        ], [
            'nama_properti.required' => 'Nama properti wajib diisi.',
            'nama_properti.regex' => 'Nama properti tidak boleh hanya berisi spasi.',
            'nama_properti.max' => 'Nama properti maksimal 255 karakter.',

            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.regex' => 'Lokasi tidak boleh hanya berisi spasi.',
            'lokasi.max' => 'Lokasi maksimal 255 karakter.',

            'fasilitas.required' => 'Fasilitas wajib diisi.',
            'fasilitas.regex' => 'Fasilitas tidak boleh kosong.',
            'fasilitas.max' => 'Fasilitas maksimal 255 karakter.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'harga.max' => 'Harga maksimal 999 miliar.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.regex' => 'Deskripsi tidak boleh hanya berisi spasi.',
            'deskripsi.max' => 'Deskripsi maksimal 3000 karakter.',

            'kontak_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'kontak_whatsapp.digits_between' => 'Nomor WhatsApp harus 10–15 digit.',

            'tipe_properti.required' => 'Tipe properti wajib dipilih.',
            'tipe_properti.in' => 'Tipe properti tidak valid.',

            'luas_tanah.numeric' => 'Luas tanah harus berupa angka.',
            'luas_tanah.min' => 'Luas tanah tidak boleh kurang dari 0.',

            'jumlah_kamar.integer' => 'Jumlah kamar harus berupa angka bulat.',
            'jumlah_kamar.min' => 'Jumlah kamar tidak boleh kurang dari 0.',

            'foto_properti.array' => 'Format upload foto tidak valid.',
            'foto_properti.max' => 'Maksimal upload 5 foto.',

            'foto_properti.*.image' => 'File harus berupa gambar.',
            'foto_properti.*.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto_properti.*.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $jumlahKamar = $request->jumlah_kamar;

        if ($request->tipe_properti === 'tanah') {
            $jumlahKamar = null;
        }

        DB::beginTransaction();

        try {

            //  UPDATE DATA
            $properti->update([
                'nama_properti' => $request->nama_properti,
                'lokasi' => $request->lokasi,
                'fasilitas' => $request->fasilitas,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'kontak_whatsapp' => $request->kontak_whatsapp,
                'tipe_properti' => $request->tipe_properti,
                'luas_tanah' => $request->luas_tanah,
                'jumlah_kamar' => $jumlahKamar,

                //  WAJIB VERIFIKASI ULANG
                'status' => 'menunggu',
            ]);

            //  UPDATE FOTO
            if ($request->hasFile('foto_properti')) {

                // hapus semua foto lama
                foreach ($properti->fotos as $foto) {

                    Storage::disk('public')->delete($foto->path);

                    $foto->delete();
                }

                // simpan foto baru
                foreach ($request->file('foto_properti') as $file) {

                    $path = $file->store('properti', 'public');

                    PropertiFoto::create([
                        'properti_id' => $properti->properti_id,
                        'path' => $path
                    ]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui properti, silakan coba lagi.');
        }

        return redirect()
            ->route('pemilik.beranda')
            ->with('success', 'Properti berhasil diperbarui dan menunggu verifikasi ulang.');
    }

    // FORM UPLOAD
    public function upload()
    {
        return view('pemilik.upload');
    }


    public function store(Request $request)
    {
        $userId = Auth::id();

        //  BERSIHKAN INPUT
        $namaProperti = trim($request->nama_properti);
        $lokasi = trim($request->lokasi);

        $fasilitas = collect(explode(',', $request->fasilitas))
            ->map(fn($item) => trim($item))
            ->filter()
            ->implode(', ');

        $request->merge([
            'nama_properti' => $namaProperti,
            'lokasi' => $lokasi,
            'fasilitas' => $fasilitas,
        ]);

        //  HITUNG PROPERTI VALID
        $jumlahProperti = Properti::where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->count();

        $request->validate([

            'nama_properti' => [
                'required',
                'string',
                'max:255',
                'regex:/.*\S.*/'
            ],

            'fasilitas' => [
                'required',
                'string',
                'max:255',
                'regex:/.*\S.*/'
            ],

            'foto_properti' => 'required|array|min:1|max:5',

            'foto_properti.*' => [
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120'
            ],

            'lokasi' => [
                'required',
                'string',
                'max:255',
                'regex:/.*\S.*/'
            ],

            'harga' => 'required|numeric|min:0|max:999999999999',

            'kontak_whatsapp' => 'required|digits_between:10,15',

            'tipe_properti' => 'required|in:rumah,tanah,ruko,apartemen',

            'luas_tanah' => 'nullable|numeric|min:0',

            'jumlah_kamar' => 'nullable|integer|min:0',

            'deskripsi' => [
                'required',
                'string',
                'max:3000',
                'regex:/.*\S.*/'
            ],

        ], [
            'nama_properti.required' => 'Nama properti wajib diisi.',
            'nama_properti.regex' => 'Nama properti tidak boleh hanya berisi spasi.',
            'nama_properti.max' => 'Nama properti maksimal 255 karakter.',

            'fasilitas.required' => 'Fasilitas wajib diisi.',
            'fasilitas.regex' => 'Fasilitas tidak boleh kosong.',
            'fasilitas.max' => 'Fasilitas maksimal 255 karakter.',

            'foto_properti.required' => 'Minimal satu foto properti harus diupload.',
            'foto_properti.array' => 'Format upload foto tidak valid.',
            'foto_properti.min' => 'Minimal upload 1 foto.',
            'foto_properti.max' => 'Maksimal upload 5 foto.',

            'foto_properti.*.image' => 'File harus berupa gambar.',
            'foto_properti.*.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'foto_properti.*.max' => 'Ukuran gambar maksimal 5MB.',

            'lokasi.required' => 'Lokasi wajib diisi.',
            'lokasi.regex' => 'Lokasi tidak boleh hanya berisi spasi.',
            'lokasi.max' => 'Lokasi maksimal 255 karakter.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'harga.max' => 'Harga maksimal 999 miliar.',

            'kontak_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'kontak_whatsapp.digits_between' => 'Nomor WhatsApp harus 10–15 digit.',

            'tipe_properti.required' => 'Tipe properti wajib dipilih.',
            'tipe_properti.in' => 'Tipe properti tidak valid.',

            'luas_tanah.numeric' => 'Luas tanah harus berupa angka.',
            'luas_tanah.min' => 'Luas tanah tidak boleh kurang dari 0.',

            'jumlah_kamar.integer' => 'Jumlah kamar harus berupa angka bulat.',
            'jumlah_kamar.min' => 'Jumlah kamar tidak boleh kurang dari 0.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.regex' => 'Deskripsi tidak boleh hanya berisi spasi.',
            'deskripsi.max' => 'Deskripsi maksimal 3000 karakter.',

        ]);

        $jumlahKamar = $request->jumlah_kamar;

        if ($request->tipe_properti === 'tanah') {
            $jumlahKamar = null;
        }

        // FREEMIUM LOGIC
        $statusPembayaran = $jumlahProperti >= 1 ? 'pending' : 'valid';

        DB::beginTransaction();

        try {

            //  BUAT PROPERTI
            $properti = Properti::create([
                'user_id' => $userId,
                'nama_properti' => $request->nama_properti,
                'fasilitas' => $request->fasilitas,
                'lokasi' => $request->lokasi,
                'harga' => $request->harga,
                'kontak_whatsapp' => $request->kontak_whatsapp,
                'deskripsi' => $request->deskripsi,
                'status' => 'menunggu',
                'status_pembayaran' => $statusPembayaran,
                'is_unggulan' => 0,
                'tipe_properti' => $request->tipe_properti,
                'luas_tanah' => $request->luas_tanah,
                'jumlah_kamar' => $jumlahKamar,
            ]);

            //  SIMPAN FOTO
            if ($request->hasFile('foto_properti')) {

                foreach ($request->file('foto_properti') as $file) {

                    $path = $file->store('properti', 'public');

                    \App\Models\PropertiFoto::create([
                        'properti_id' => $properti->properti_id,
                        'path' => $path
                    ]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Upload properti gagal, silakan coba lagi.');
        }

        //  REDIRECT
        if ($statusPembayaran === 'pending') {

            return redirect()
                ->route('pemilik.detail', $properti->properti_id)
                ->with('info', 'Silakan lakukan pembayaran untuk melanjutkan.');
        }

        return redirect()
            ->route('pemilik.beranda')
            ->with('success', 'Properti pertama berhasil diupload secara gratis.');
    }

    public function riwayat()
    {
        $userId = Auth::id();

        //  MENUNGGU VERIFIKASI
        $menunggu = Properti::with('fotos')
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->where('status', 'menunggu')
            ->latest()
            ->get();

        //  DITOLAK OLEH ADMIN
        $ditolak = Properti::with('fotos')
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'valid')
            ->where('status', 'ditolak')
            ->latest()
            ->get();

        return view('pemilik.riwayat', compact('menunggu', 'ditolak'));
    }

    // INDEX PEMBAYARAN
    public function pembayaran()
    {
        $properti = Properti::with('fotos')
            ->where('user_id', Auth::id())
            ->where(function ($query) {

                // BELUM BAYAR
                $query->where(function ($q) {
                    $q->where('status_pembayaran', 'pending')
                    ->whereNull('bukti_pembayaran');
                })

                //  DITOLAK (BIAR BISA UPLOAD ULANG)
                ->orWhere('status_pembayaran', 'ditolak');

            })
            ->latest()
            ->get();

        return view('pemilik.pembayaran', compact('properti'));
    }


    // DETAIL PEMBAYARAN
    public function pembayaranDetail($id)
    {
        $properti = Properti::with('fotos')
            ->where('properti_id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status_pembayaran', ['pending', 'ditolak'])
            ->firstOrFail();

        return view('pemilik.detail', compact('properti'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $properti = Properti::where('properti_id', $id)
            ->where('user_id', Auth::id())
            ->whereIn('status_pembayaran', ['pending','ditolak'])
            ->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format harus JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max' => 'Ukuran maksimal 2MB.'
        ]);

        if ($properti->bukti_pembayaran) {
            Storage::disk('public')->delete($properti->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')
            ->store('bukti', 'public');

        $properti->update([
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'pending'
        ]);

        return redirect()->route('pemilik.beranda')
            ->with('success', 'Bukti pembayaran berhasil dikirim.');
    }
}
