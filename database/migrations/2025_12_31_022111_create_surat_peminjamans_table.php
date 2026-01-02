<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id')->nullable(); // Bisa null (untuk booking tanpa peminjaman)
            $table->unsignedBigInteger('user_id');
            
            // Data surat
            $table->string('nama_pemohon');
            $table->string('no_hp');
            $table->text('keperluan');
            $table->string('surat_path'); // Path file PDF
            
            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            
            // Tanggal untuk surat
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            
            // Barang yang ingin dipinjam (bisa JSON atau relasi terpisah)
            $table->json('barang_dipinjam')->nullable();
            $table->string('signed_response_path')->nullable();

            $table->timestamps();
            
            // Foreign keys
            $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_peminjamans');
    }
};