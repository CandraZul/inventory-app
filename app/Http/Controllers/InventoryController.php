<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //
    public function index()
    {
        $items = Inventory::all();
        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        Inventory::create($request->all());
        return redirect()->route('inventory.index');
    }
    public function edit($id)
    {
        $item = Inventory::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $item->update([
            'nama_barang' => $request->nama_barang,
            'merk' => $request->merk,
            'jumlah' => $request->jumlah,
            'kondisi' => $request->kondisi,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Data berhasil dihapus');
    }

}
