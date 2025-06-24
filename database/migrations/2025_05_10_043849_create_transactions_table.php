<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plakat_id')->constrained('plakats')->onDelete('cascade');
            $table->string('nama_pembeli');
            $table->string('email');
            $table->string('no_telepon');
            $table->text('alamat');
            $table->string('design_file')->nullable();
            $table->text('catatan_design')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['transfer_bank', 'e_wallet']);
            $table->string('bank')->nullable();
            $table->string('ewallet')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar', 'ditolak'])->default('menunggu_pembayaran');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};