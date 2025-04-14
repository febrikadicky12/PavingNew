<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Perintah ini akan dijalankan saat kamu menjalankan php artisan migrate
     */
    public function up(): void
    {
        // Mengubah tabel 'total_produksi'
        Schema::table('total_produksi', function (Blueprint $table) {
            // Menambahkan kolom created_at dan updated_at secara otomatis
            // Kolom ini akan bertipe TIMESTAMP dan bisa NULL (default Laravel)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Perintah ini akan dijalankan jika kamu melakukan rollback (php artisan migrate:rollback)
     */
    public function down(): void
    {
        // Mengubah tabel 'total_produksi'
        Schema::table('total_produksi', function (Blueprint $table) {
            // Menghapus kolom created_at dan updated_at
            $table->dropTimestamps();
        });
    }
};
