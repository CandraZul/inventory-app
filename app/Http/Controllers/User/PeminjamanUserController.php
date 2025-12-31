<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanUserController extends Controller
{
    /**
     * Dashboard user borrowing
     */
    public function dashboard()
    {
        return view('borrowing.dashboard');
    }

    /**
     * Halaman pilih barang untuk dipinjam
     */
    public function index(Request $request)
    {
        $query = Inventory::query();

        if ($request->search) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $inventories = $query->get();

        return view('borrowing.pinjam', compact('inventories'));
    }

    /**
     * Simpan data peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $inventory = Inventory::findOrFail($request->inventory_id);

        if ($request->jumlah > $inventory->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        // 1️⃣ simpan HEADER peminjaman
        $peminjaman = Peminjaman::create([
            'user_id' => $user->id,
            'nim' => $user->nim ?? null,
            'nip' => $user->nip ?? null,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam',
        ]);

        // 2️⃣ simpan DETAIL peminjaman
        PeminjamanDetail::create([
            'peminjaman_id' => $peminjaman->id,
            'inventory_id' => $inventory->id,
            'jumlah' => $request->jumlah,
        ]);

        // 3️⃣ kurangi stok
        $inventory->decrement('jumlah', $request->jumlah);

        return back()->with('success', 'Barang berhasil dipinjam');
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();

        // ambil semua peminjaman user ini, optional filter status
    $query = Peminjaman::with('details.inventory')
        ->where('user_id', $user->id);

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $riwayat = $query->orderBy('tanggal_pinjam', 'desc')->get();

    return view('borrowing.riwayat', compact('riwayat'));
}

}
