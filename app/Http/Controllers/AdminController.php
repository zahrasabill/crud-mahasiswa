<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() //INDEX ATAU HOME
    {
        $produks = Produk::all();
        return view('admin.index', compact('produks'));
    }

    public function showById($id) //MENAMPILKAN BERDASARKAN ID
    {
        $produk = Produk::findOrFail($id);
        return view('admin.show', compact('produk'));
    }

    public function delete($id) //MENGHAPUS BERDASARKAN ID
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('admin.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function edit($id) //TAMPILAN UNTUK EDIT BERDASARKAN ID
    {
        $produk = Produk::findOrFail($id);
        return view('admin.edit', compact('produk'));
    }

    public function update(Request $request, $id) //FUNCTION POST UNTUK UPDATE BERDASARKAN ID
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // Find the produk to be updated
        $produk = Produk::findOrFail($id);

        // Update the produk
        $produk->update([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
        ]);

        // Redirect back to the index page with a success message
        return redirect()->route('admin.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function store(Request $request) //FUNCTION POST UNTUK MENAMBAHKAN DATA
    {
        // Validate the request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        // Create the produk
        Produk::create([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok'),
        ]);

        // Redirect back to the index page with a success message
        return redirect()->route('admin.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function create() //TAMPILAN UNTUK MENAMBAHKAN DATA
    {
        return view('admin.create');
    }
}