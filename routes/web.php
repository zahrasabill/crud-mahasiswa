<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\AdminExportController;
use App\Models\Admin;

Route::get('/admin/menu', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/{id}', [AdminController::class, 'showById'])->name('admin.show');
Route::delete('/admin/produk/{id}', [AdminController::class, 'delete'])->name('admin.delete');
Route::get('/admin/produk/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/produk/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::get('/admin/produk/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin/produk', [AdminController::class, 'store'])->name('admin.store');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/home', [ProdukController::class, 'home'])->name('produk.home');


Route::get('/admin/produk/export/pdf', [AdminExportController::class, 'exportPdf'])->name('admin.export.pdf');
Route::get('/admin/produk/export/excel', [AdminExportController::class, 'exportExcel'])->name('admin.export.excel');


