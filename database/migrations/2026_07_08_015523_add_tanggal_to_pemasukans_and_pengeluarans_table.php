<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->date('tanggal')->after('toko_id')->nullable();
        });
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->date('tanggal')->after('nama_pengeluaran')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->dropColumn('tanggal');
        });
    }
};
