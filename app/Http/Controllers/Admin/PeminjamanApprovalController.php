<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class PeminjamanApprovalController extends Controller
{
    public function index()
    {
        $ajuan = DB::table('peminjamans')
            ->join('users', 'users.id', '=', 'peminjamans.user_id')
            ->join('peminjaman_details', 'peminjaman_details.peminjaman_id', '=', 'peminjamans.id')
            ->join('inventories', 'inventories.id', '=', 'peminjaman_details.inventory_id')
            ->leftJoin('surat_peminjamans', 'surat_peminjamans.peminjaman_id', '=', 'peminjamans.id')
            ->select(
                'peminjamans.id as peminjaman_id',
                'users.id as user_id',
                'users.name as peminjam',
                'users.email',
                'inventories.nama_barang as nama_barang',
                'peminjaman_details.jumlah',
                'peminjamans.status',
                'peminjamans.tanggal_pinjam as tanggal_pinjam',
                'surat_peminjamans.surat_path',
                'surat_peminjamans.status as surat_status'
            )
            ->get()
            ->map(function ($item) {
                $item->role = User::find($item->user_id)->getRoleNames()->first();
                $item->surat_url = $item->surat_path ? Storage::url($item->surat_path) : null;
                return $item;
            });

        return view('admin.approval.index', ['ajuan' => $ajuan]);
    }

    public function approve($id)
    {
        DB::table('peminjamans')->where('id', $id)->update(['status' => 'dipinjam']);
        return back()->with('success', 'Pengajuan peminjaman berhasil di-ACC');
    }

    public function reject($id)
    {
        DB::table('peminjamans')->where('id', $id)->update(['status' => 'kembali']);
        return back()->with('info', 'Pengajuan peminjaman ditolak');
    }
}
