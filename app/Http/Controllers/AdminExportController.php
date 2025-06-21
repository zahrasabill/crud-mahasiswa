<?php

namespace App\Http\Controllers;

use App\Exports\ProdukExport;
use App\Models\Produk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class AdminExportController extends Controller
{
    public function exportPdf()
    {
        $produks = Produk::all();
        $pdf = Pdf::loadView('admin.export_pdf', compact('produks'));
        return $pdf->download('daftar-produk.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new ProdukExport, 'daftar-produk.xlsx');
    }
}
