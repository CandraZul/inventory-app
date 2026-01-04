<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InventoryController;
use App\Models\Inventory;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PeminjamanApprovalController extends Controller
{
    public function index()
    {
        // 1. Ambil data ajuan dan GROUP BY per peminjaman
        $data = DB::table('peminjamans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('profiles_mahasiswa as m', 'm.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as ds', 'ds.user_id', '=', 'u.id')
            ->select(
                'p.id as peminjaman_id',
                'p.user_id as user_id',
                'u.name as peminjam',
                DB::raw("CASE WHEN m.nim IS NOT NULL THEN m.nim ELSE ds.nip END as identitas"),
                DB::raw("(SELECT JSON_ARRAYAGG(JSON_OBJECT('barang', i.nama_barang, 'jumlah', d.jumlah))
                          FROM peminjaman_details as d
                          JOIN inventories as i ON i.id = d.inventory_id
                          WHERE d.peminjaman_id = p.id) as detail_barang"),
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali'
            )
            ->where('p.status', 'pending')
            ->orderBy('p.tanggal_pinjam', 'asc')
            ->groupBy(
                'p.id',
                'p.user_id',
                'u.name',
                'm.nim',
                'ds.nip',
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali'
            )
            ->get();

        // 2. Tambahkan role ke tiap item (sekarang user_id sudah ada, jadi tidak kosong lagi)
        $data = $data->map(function ($item) {
            $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';
            return $item;
        });

        // 3. Manual Pagination
        $page = request()->get('page', 1);
        $perPage = 10;

        $paginator = new LengthAwarePaginator(
            $data->forPage($page, $perPage),
            $data->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query()
            ]
        );

        // 4. Kirim ke view
        return view('admin.approval.index', ['ajuan' => $paginator]);
    }


    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        foreach ($peminjaman->details as $detail) {
            $inventory = $detail->inventory;
            if (!$inventory || $detail->jumlah > $inventory->jumlah) {
                return back()->with('error', 'Stok ' . ($inventory->nama_barang ?? 'barang') . ' tidak mencukupi');
            }
        }

        $peminjaman->update(['status' => 'dipinjam']);

        // Kurangi stok
        foreach ($peminjaman->details as $detail) {
            $inventory = $detail->inventory;
            $inventory->decrement('jumlah', $detail->jumlah);
        }

        return back()->with('success', 'Pengajuan peminjaman berhasil di-ACC dan status berubah menjadi dipinjam');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Pengajuan peminjaman berhasil ditolak');
    }


    public function process(Request $request, $id)
    {
        $action = $request->action;

        if ($action === 'approve') {
            $request->validate([
                'signed_pdf' => 'required|mimes:pdf|max:2048'
            ]);

            $file = $request->file('signed_pdf');
            $path = $file->store('surat-balasan');

            DB::table('peminjamans')->where('id', $id)->update(['status' => 'dipinjam']);

            DB::table('surat_peminjamans')->updateOrInsert(
                ['peminjaman_id' => $id],
                ['signed_response_path' => $path]
            );

            return back()->with('success', 'Pengajuan di-ACC dan surat balasan berhasil diupload');
        }

        return back()->with('info', 'Aksi tidak valid');
    }




}

