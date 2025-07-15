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
        Schema::create('piket', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama Piket');
            $table->dateTime('tanggal_waktu_piket')->comment('Tanggal dan waktu Piket');
            $table->boolean('piket')->default(false)->comment('Status Piket');
            $table->text('catatan')->nullable()->comment('Catatan');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat'])->comment('Hari Piket');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piket');
    }
};
