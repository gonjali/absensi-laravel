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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable(); // Nama tetap string
            $table->string('hari')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_kedatangan')->nullable();
            $table->boolean('kehadiran')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Tambahkan foreign key dengan cascading
            $table->foreign('nama')
                ->references('nama')
                ->on('metadata')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['nama']); // Hapus foreign key
        });

        Schema::dropIfExists('absensis');
    }
};
