<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PeminjamanApprovalController extends Controller
{
    public function index()
    {
        $ajuan = DB::table('peminjamans as p')
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->join('peminjaman_details as d', 'd.peminjaman_id', '=', 'p.id')
            ->join('inventories as i', 'i.id', '=', 'd.inventory_id')
            ->leftJoin('profiles_mahasiswa as m', 'm.user_id', '=', 'u.id')
            ->leftJoin('profiles_dosen as ds', 'ds.user_id', '=', 'u.id')
            ->select(
                'p.id as peminjaman_id',
                'u.id as user_id',
                'u.name as peminjam',
                DB::raw("CASE WHEN m.nim IS NOT NULL THEN m.nim ELSE ds.nip END as identitas"),
                'i.nama_barang',
                'd.jumlah',
                'p.status',
                'p.tanggal_pinjam',
                'p.tanggal_kembali'
            )
            ->orderBy('p.tanggal_pinjam', 'asc')
            ->where('p.status', 'pending')
            ->paginate(10)
            ->through(function ($item) {
                $item->role = User::find($item->user_id)?->getRoleNames()->first() ?? '-';
                return $item;
            });

        return view('admin.approval.index', ['ajuan' => $ajuan]);
    }




    public function approve($id)
    {
        DB::table('peminjamans')
            ->where('id', $id)
            ->update(['status' => 'dipinjam']);

        return back()->with('success', 'Pengajuan peminjaman berhasil di-ACC dan status berubah menjadi dipinjam');
    }

    public function reject($id)
    {
        DB::table('peminjamans')
            ->where('id', $id)
            ->update(['status' => 'ditolak']);

        return back()->with('info', 'Pengajuan peminjaman ditolak');
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

