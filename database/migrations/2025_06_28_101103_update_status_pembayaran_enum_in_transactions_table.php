<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, modify the enum to include new values
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status_pembayaran ENUM('menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar', 'diproses', 'selesai', 'ditolak') DEFAULT 'menunggu_pembayaran'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status_pembayaran ENUM('menunggu_pembayaran', 'menunggu_verifikasi', 'dibayar', 'ditolak') DEFAULT 'menunggu_pembayaran'");
    }
};
