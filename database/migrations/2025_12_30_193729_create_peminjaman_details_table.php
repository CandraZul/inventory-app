<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('peminjaman_id');
            $table->unsignedBigInteger('inventory_id');

            $table->integer('jumlah');

            $table->timestamps();

            $table->foreign('peminjaman_id')
                  ->references('id')->on('peminjamans')
                  ->onDelete('cascade');

            $table->foreign('inventory_id')
                  ->references('id')->on('inventories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman_details');
    }
};
