<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    // TAMPILKAN HALAMAN UTAMA PRODUK DENGAN PAGINASI, FILTER NAMA, STATISTIK STOK
    public function home(Request $request)
    {
        $produks = Produk::orderBy('id', 'desc');

        // Search by nama produk
        if ($request->has('search')) {
            $produks->where('nama', 'like', '%' . $request->input('search') . '%');
        }

        $produks = $produks->paginate(10);

        // Total produk
        $totalProduk = Produk::count();

        // Statistik rekap stok berdasarkan rentang stok (misal stok banyak vs stok sedikit)
        $stokStatistics = [
            'stok_rendah' => Produk::where('stok', '<', 10)->count(),
            'stok_menengah' => Produk::whereBetween('stok', [10, 50])->count(),
            'stok_tinggi' => Produk::where('stok', '>', 50)->count(),
        ];

        return view('produk.home', [
            'produks' => $produks,
            'totalProduk' => $totalProduk,
            'stokStatistics' => $stokStatistics,
        ]);
    }

    public function index(Request $request)
    {
        $produks = Produk::orderBy('id', 'desc');

        // Search by nama produk
        if ($request->has('search')) {
            $produks->where('nama', 'like', '%' . $request->input('search') . '%');
        }

        $produks = $produks->paginate(10);

        // Total produk
        $totalProduk = Produk::count();

        // Statistik rekap stok berdasarkan rentang stok (misal stok banyak vs stok sedikit)
        $stokStatistics = [
            'stok_rendah' => Produk::where('stok', '<', 10)->count(),
            'stok_menengah' => Produk::whereBetween('stok', [10, 50])->count(),
            'stok_tinggi' => Produk::where('stok', '>', 50)->count(),
        ];

        return view('produk.index', [
            'produks' => $produks,
            'totalProduk' => $totalProduk,
            'stokStatistics' => $stokStatistics,
        ]);
    }
}
