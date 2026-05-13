<?php

namespace App\Http\Controllers;

use App\Models\Properti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;

class AdminController extends Controller
{
    public function beranda()
    {
        $totalProperti = Properti::where(function ($q) {

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

        })->count();

        $totalPemilik = User::where('role', 'pemilik')->count();

        $menunggu = Properti::where('status_pembayaran', 'valid')
            ->where('status', 'menunggu')
            ->count();

        $totalAktif = Properti::where('status_pembayaran', 'valid')
            ->where('status', 'disetujui')
            ->count();

        //  MENUNGGU VALIDASI PEMBAYARAN
        $menungguPembayaran = Properti::where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->count();

        //  LIST PROPERTI (YANG SUDAH SIAP TAMPIL)
        $properti = Properti::with('fotos')
            ->where('status_pembayaran', 'valid')
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('admin.beranda', compact(
            'totalProperti',
            'totalPemilik',
            'totalAktif',
            'menunggu',
            'menungguPembayaran',
            'properti'
        ));
    }

    public function unggulan(Request $request)
    {
        Properti::where('status', 'disetujui')
            ->where('status_pembayaran', 'valid')
            ->update(['is_unggulan' => 0]);

        if ($request->properti) {
            Properti::whereIn('properti_id', $request->properti)
                ->where('status', 'disetujui')
                ->where('status_pembayaran', 'valid')
                ->update(['is_unggulan' => 1]);
        }

        return back()->with('success', 'Properti unggulan berhasil diperbarui.');
    }

    // LIST VERIFIKASI PROPERTI
    public function verifikasi()
    {
        $properti = Properti::with('fotos')
            ->where('status', 'menunggu')
            ->where('status_pembayaran', 'valid')
            ->latest()
            ->get();

        return view('admin.verifikasi', compact('properti'));
    }

    // DETAIL PROPERTI
    public function detail($id)
    {
        $properti = Properti::with('fotos')
            ->where('properti_id', $id)
            ->where('status_pembayaran', 'valid')
            ->firstOrFail();

        return view('admin.detail', compact('properti'));
    }

    public function verifikasiProses(Request $request, $id, $aksi)
    {
        $properti = Properti::where('properti_id', $id)
            ->where('status', 'menunggu')
            ->where('status_pembayaran', 'valid')
            ->firstOrFail();

        if ($aksi === 'setujui') {
            $properti->update([
                'status' => 'disetujui',
                'alasan_penolakan' => null
            ]);
        }

        if ($aksi === 'tolak') {

            $request->validate([
                'alasan_penolakan' => 'required|string'
            ], [
                'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
                'alasan_penolakan.string' => 'Alasan penolakan harus berupa teks.'
            ]);

            $properti->update([
                'status' => 'ditolak',
                'is_unggulan' => 0,
                'alasan_penolakan' => $request->alasan_penolakan
            ]);
        }

        return redirect()->route('admin.verifikasi')
            ->with('success', 'Status properti berhasil diperbarui.');
    }

    public function uploadBannerForm()
    {
        return view('admin.upload');
    }

    // STORE BANNER
    public function uploadBanner(Request $request)
    {
        $request->validate([
            'gambar_banner' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'gambar_banner.required' => 'Gambar banner wajib diisi.',
            'gambar_banner.image' => 'File harus berupa gambar.',
            'gambar_banner.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar_banner.max' => 'Ukuran gambar maksimal 5MB.',

            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',

            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ]);


        $path = $request->file('gambar_banner')
            ->store('banner', 'public');

        Banner::create([
            'gambar_banner' => $path,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('admin.beranda')
            ->with('success', 'Banner berhasil diupload.');
    }

    // LIST PEMBAYARAN (SUDAH UPLOAD BUKTI)
    public function pembayaran()
    {
        $properti = Properti::with('fotos')
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->latest()
            ->get();

        return view('admin.pembayaran', compact('properti'));
    }

    public function detailPembayaran($id)
    {
        $properti = Properti::with('fotos')
            ->where('properti_id', $id)
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->firstOrFail();

        return view('admin.detailpembayaran', compact('properti'));
    }

    public function validasiPembayaran($id)
    {
        $properti = Properti::where('properti_id', $id)
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->firstOrFail();

        $properti->update([
            'status_pembayaran' => 'valid',
            'status' => 'menunggu'
        ]);

        return redirect()->route('admin.pembayaran')
            ->with('success', 'Pembayaran berhasil divalidasi.');
    }

    public function tolakPembayaran(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string'
        ], [
            'alasan.required' => 'Alasan wajib diisi.',
            'alasan.string' => 'Alasan harus berupa teks.'
        ]);

        $properti = Properti::where('properti_id', $id)
            ->where('status_pembayaran', 'pending')
            ->whereNotNull('bukti_pembayaran')
            ->firstOrFail();

        $properti->update([
            'status_pembayaran' => 'ditolak',
            'alasan_penolakan_pembayaran' => $request->alasan
        ]);

        return redirect()->route('admin.pembayaran')
            ->with('success', 'Pembayaran ditolak.');
    }
}
