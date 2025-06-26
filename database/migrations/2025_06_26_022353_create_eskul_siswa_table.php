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
        Schema::create('eskul_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eskul_id');
            $table->unsignedBigInteger('siswa_id'); // user siswa
            $table->timestamps();

            $table->foreign('eskul_id')->references('id')->on('eskuls')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eskul_siswa');
    }
};
