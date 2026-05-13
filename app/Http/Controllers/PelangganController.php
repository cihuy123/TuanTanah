<?php

namespace App\Http\Controllers;

use App\Models\Properti;
use App\Models\Banner;
use Illuminate\Support\Carbon;

class PelangganController extends Controller
{
    public function beranda()
    {
        $banner = Banner::whereDate('tanggal_mulai', '<=', Carbon::today())
                        ->whereDate('tanggal_selesai', '>=', Carbon::today())
                        ->latest()
                        ->first();

        $properti = Properti::where('status', 'disetujui')
                            ->where('status_pembayaran', 'valid')
                            ->where('is_unggulan', 1)
                            ->latest()
                            ->take(6)
                            ->get();

        return view('pelanggan.beranda', compact('banner', 'properti'));
    }

    // HALAMAN SEMUA PROPERTI
    public function properti()
    {
        $query = Properti::with('fotos')
            ->where('status', 'disetujui')
            ->where('status_pembayaran', 'valid');

        //  FILTER LOKASI
        if (request('lokasi')) {
            $query->where('lokasi', 'like', '%' . request('lokasi') . '%');
        }

        if (request()->filled('tipe')) {
            $query->where('tipe_properti', request('tipe'));
        }

        if (request()->filled('min')) {
            $query->where('harga', '>=', (int) request('min'));
        }

        if (request()->filled('max')) {
            $query->where('harga', '<=', (int) request('max'));
        }

        //  DATA
        $properti = (clone $query)
            ->where('is_unggulan', 0)
            ->latest()
            ->get();

        $unggulan = (clone $query)
            ->where('is_unggulan', 1)
            ->latest()
            ->get();

        return view('pelanggan.properti', compact('unggulan', 'properti'));
    }

    // DETAIL PROPERTI
    public function detail($id)
    {
        $properti = Properti::with('fotos')
            ->where('properti_id', $id)
            ->where('status', 'disetujui')
            ->where('status_pembayaran', 'valid')
            ->firstOrFail();

        return view('pelanggan.detail', compact('properti'));
    }

    public function kontak()
    {
        return view('pelanggan.kontak');
    }
}
