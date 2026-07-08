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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->constrained('tokos')->onDelete('cascade');
            $table->integer('bulan')->comment('Bulan pendapatan (1-12)');
            $table->integer('tahun')->comment('Tahun pendapatan');
            $table->decimal('jumlah_pendapatan', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
