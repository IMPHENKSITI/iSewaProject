<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitPenyewaanController extends Controller
{
    /**
     * Menampilkan daftar barang.
     */
    public function index()
    {
        // Ambil semua barang tanpa filter kategori
        $barangs = Barang::paginate(6);
        return view('admin.unit.penyewaan.index', compact('barangs'));
    }

    /**
     * Menampilkan form untuk membuat barang baru.
     */
    public function create()
    {
        return view('admin.unit.penyewaan.create');
    }

    /**
     * Menyimpan barang baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_sewa' => 'required|string', // ✅ Terima sebagai string (agar titik/koma diperbolehkan)
            'stok' => 'required|integer',
            'status' => 'required|in:tersedia,disewa,rusak',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'satuan' => 'required|string',
            'foto_utama' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //  Bersihkan semua karakter non-angka (titik, koma, spasi, dll), lalu ubah ke integer
        $hargaBersih = (int) preg_replace('/[^0-9]/', '', $request->harga_sewa);
        if ($hargaBersih <= 0) {
            return back()->withErrors(['harga_sewa' => 'Harga sewa harus angka valid dan lebih dari 0.'])->withInput();
        }

        $data = $request->except(['_token', '_method']);
        $data['harga_sewa'] = $hargaBersih;

        // Upload gambar
        if ($request->hasFile('foto_utama')) { 
            $data['foto'] = $request->file('foto_utama')->store('barang', 'public'); 
        }
        if ($request->hasFile('foto_2')) {
            $data['foto_2'] = $request->file('foto_2')->store('barang', 'public');
        }
        if ($request->hasFile('foto_3')) {
            $data['foto_3'] = $request->file('foto_3')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('admin.unit.penyewaan.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail barang.
     */
    public function show($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.unit.penyewaan.show', compact('barang'));
    }

    /**
     * Menampilkan form untuk mengedit barang.
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('admin.unit.penyewaan.edit', compact('barang'));
    }

    /**
     * Menghapus barang dari database.
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Hapus file gambar
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }
        if ($barang->foto_2) {
            Storage::disk('public')->delete($barang->foto_2);
        }
        if ($barang->foto_3) {
            Storage::disk('public')->delete($barang->foto_3);
        }

        $barang->delete();

        return redirect()->route('admin.unit.penyewaan.index')->with('success', 'Barang berhasil dihapus.');
    }
}