<?php

namespace App\Http\Controllers;

use App\Http\Requests\Produk\StoreRequest;
use App\Http\Requests\Produk\UpdateRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Produk;
use App\Models\Jenis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(SearchRequest $request)
    {
        $this->authorize('viewAny', Produk::class);

        $keyword = $request->input('search');

        $products = Produk::with('jenis')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhereHas('jenis', function ($q) use ($keyword) {
                        $q->where('nama', 'like', '%' . $keyword . '%');
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('produk.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('create', Produk::class);

        $jenisList = Jenis::orderBy('nama')->get();

        return view('produk.create', compact('jenisList'));
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Produk::class);

        $dataReq = $request->validated();

        // Harga jual TIDAK diambil langsung dari input, tapi dihitung
        // ulang di server dari harga_beli + persen_laba supaya tidak
        // bisa dimanipulasi lewat form (mis. lewat devtools).
        $hargaJual = Produk::hitungHargaJual((int) $dataReq['harga_beli'], (int) $dataReq['persen_laba']);

        $data = [
            'user_id'       => Auth::id(),
            'nama'          => $dataReq['nama'],
            'jenis_id'      => $dataReq['jenis_id'],
            'harga_beli'    => $dataReq['harga_beli'],
            'persen_laba'   => $dataReq['persen_laba'],
            'harga_jual'    => $hargaJual,
            'persen_diskon' => $dataReq['persen_diskon'] ?? 0,
            'stok'          => $dataReq['stok'],
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Produk $produk)
    {
        $this->authorize('update', $produk);

        $jenisList = Jenis::orderBy('nama')->get();

        return view('produk.edit', compact('produk', 'jenisList'));
    }

    public function update(UpdateRequest $request, Produk $produk)
    {
        $this->authorize('update', $produk);

        $dataReq = $request->validated();

        // Sama seperti store(): harga_jual selalu dihitung ulang di server.
        $hargaJual = Produk::hitungHargaJual((int) $dataReq['harga_beli'], (int) $dataReq['persen_laba']);

        $data = [
            'user_id'       => Auth::id(),
            'nama'          => $dataReq['nama'],
            'jenis_id'      => $dataReq['jenis_id'],
            'harga_beli'    => $dataReq['harga_beli'],
            'persen_laba'   => $dataReq['persen_laba'],
            'harga_jual'    => $hargaJual,
            'persen_diskon' => $dataReq['persen_diskon'] ?? 0,
            'stok'          => $dataReq['stok'],
        ];

        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Produk $produk)
    {
        $this->authorize('delete', $produk);

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
