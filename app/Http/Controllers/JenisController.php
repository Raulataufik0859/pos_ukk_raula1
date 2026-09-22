<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    /**
     * Menampilkan daftar jenis produk.
     */
    public function index()
    {
        $jenisList = Jenis::withCount('produks')->with('user')->latest()->paginate(10);
        return view('jenis.index', compact('jenisList'));
    }

    /**
     * Menampilkan form tambah jenis produk.
     */
    public function create()
    {
        return view('jenis.create');
    }

    /**
     * Menyimpan jenis produk baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis,nama',
        ]);

        Jenis::create([
            'nama' => $request->nama,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('jenis.index')
            ->with('success', 'Jenis produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jenis produk.
     */
    public function edit(Jenis $jenis)
    {
        return view('jenis.edit', compact('jenis'));
    }

    /**
     * Memperbarui jenis produk.
     */
    public function update(Request $request, Jenis $jenis)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:jenis,nama,' . $jenis->id,
        ]);

        $jenis->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('jenis.index')
            ->with('success', 'Jenis produk berhasil diperbarui.');
    }

    /**
     * Menghapus jenis produk.
     */
    public function destroy(Jenis $jenis)
    {
        $jenis->delete();

        return redirect()->route('jenis.index')
            ->with('success', 'Jenis produk berhasil dihapus.');
    }
}
