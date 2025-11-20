<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gas;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GasController extends Controller
{
    public function index()
    {
        $gases = Gas::orderBy('created_at', 'desc')->paginate(6);
        $purchaseHistory = Purchase::with(['gas', 'resident'])->orderBy('created_at', 'desc')->paginate(6);

        return view('admin.unit.penjualan_gas.index', compact('gases', 'purchaseHistory'));
    }

    public function create()
    {
        return view('admin.unit.penjualan_gas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_gas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_satuan' => 'required|string|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipesan,rusak',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'foto_2' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'foto_3' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Bersihkan harga dari karakter non-angka
        $hargaBersih = (int) preg_replace('/[^0-9]/', '', $request->harga_satuan);
        if ($hargaBersih <= 0) {
            return back()->withErrors(['harga_satuan' => 'Harga satuan harus angka valid dan lebih dari 0.'])->withInput();
        }

        $gas = new Gas();
        $gas->jenis_gas = $validated['jenis_gas'];
        $gas->deskripsi = $validated['deskripsi'];
        $gas->harga_satuan = $hargaBersih;
        $gas->stok = $validated['stok'];
        $gas->status = $validated['status'];
        $gas->kategori = $validated['kategori'];
        $gas->lokasi = $validated['lokasi'];
        $gas->satuan = $validated['satuan'];

        if ($request->hasFile('foto')) {
            $gas->foto = $request->file('foto')->store('gas', 'public');
        }
        if ($request->hasFile('foto_2')) {
            $gas->foto_2 = $request->file('foto_2')->store('gas', 'public');
        }
        if ($request->hasFile('foto_3')) {
            $gas->foto_3 = $request->file('foto_3')->store('gas', 'public');
        }

        $gas->save();

        return redirect()->route('admin.unit.penjualan_gas.index')->with('success', 'Gas berhasil ditambahkan.');
    }

    public function show(Gas $gas)
    {
        $purchaseHistories = $gas->purchases()->with('resident')->orderBy('created_at', 'desc')->get();

        return view('admin.unit.penjualan_gas.show', compact('gas', 'purchaseHistories'));
    }

    public function edit(Gas $gas)
    {
        return view('admin.unit.penjualan_gas.edit', compact('gas'));
    }

    public function update(Request $request, Gas $gas)
    {
        $validated = $request->validate([
            'jenis_gas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_satuan' => 'required|string|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,dipesan,rusak',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'foto_2' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'foto_3' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Bersihkan harga dari karakter non-angka
        $hargaBersih = (int) preg_replace('/[^0-9]/', '', $request->harga_satuan);
        if ($hargaBersih <= 0) {
            return back()->withErrors(['harga_satuan' => 'Harga satuan harus angka valid dan lebih dari 0.'])->withInput();
        }

        $gas->jenis_gas = $validated['jenis_gas'];
        $gas->deskripsi = $validated['deskripsi'];
        $gas->harga_satuan = $hargaBersih;
        $gas->stok = $validated['stok'];
        $gas->status = $validated['status'];
        $gas->kategori = $validated['kategori'];
        $gas->lokasi = $validated['lokasi'];
        $gas->satuan = $validated['satuan'];

        if ($request->hasFile('foto')) {
            if ($gas->foto) Storage::disk('public')->delete($gas->foto);
            $gas->foto = $request->file('foto')->store('gas', 'public');
        }
        if ($request->hasFile('foto_2')) {
            if ($gas->foto_2) Storage::disk('public')->delete($gas->foto_2);
            $gas->foto_2 = $request->file('foto_2')->store('gas', 'public');
        }
        if ($request->hasFile('foto_3')) {
            if ($gas->foto_3) Storage::disk('public')->delete($gas->foto_3);
            $gas->foto_3 = $request->file('foto_3')->store('gas', 'public');
        }

        $gas->save();

        return redirect()->route('admin.unit.penjualan_gas.index')->with('success', 'Gas berhasil diubah.');
    }

    public function destroy(Gas $gas)
    {
        if ($gas->foto) Storage::disk('public')->delete($gas->foto);
        if ($gas->foto_2) Storage::disk('public')->delete($gas->foto_2);
        if ($gas->foto_3) Storage::disk('public')->delete($gas->foto_3);

        $gas->delete();

        return redirect()->route('admin.unit.penjualan_gas.index')->with('success', 'Gas berhasil dihapus.');
    }
}