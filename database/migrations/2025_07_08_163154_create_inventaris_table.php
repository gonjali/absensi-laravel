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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment('Nama Inventaris');
            $table->string('merek')->comment('Merek Inventaris');
            $table->string('tipe')->comment('Tipe Inventaris');
            $table->string('processor')->comment('Processor Inventaris');
            $table->string('ram')->comment('RAM Inventaris');
            $table->string('storage')->comment('Storage Inventaris');
            $table->integer('tahun_perolehan')->comment('Tahun Perolehan Inventaris');
            $table->string('kondisi')->comment('Kondisi Inventaris');
            $table->string('status')->comment('Status Inventaris');
            $table->string('digunakan_oleh')->comment('Digunakan Oleh');
            $table->string('lokasi')->comment('Lokasi Inventaris');
            $table->text('keterangan')->comment('Keterangan Inventaris');
            $table->string('foto')->comment('Foto Inventaris');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    

     public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
