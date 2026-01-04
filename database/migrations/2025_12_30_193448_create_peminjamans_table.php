<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->enum('status', ['pending', 'dipinjam', 'kembali', 'ditolak'])
                  ->default('pending');

            $table->timestamp('tanggal_pinjam')->useCurrent();
            $table->timestamp('tanggal_kembali')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};