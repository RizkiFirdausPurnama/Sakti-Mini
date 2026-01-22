<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('prodi');
            $table->unsignedInteger('angkatan'); // 4 digit
            $table->string('status')->default('aktif'); // aktif, cuti, lulus, dropout
            $table->timestamps();
            $table->softDeletes(); // Wajib Soft Deletes

            // Optimasi Index untuk pencarian cepat
            $table->index('nama');
            $table->index('prodi');
            // NIM dan Email sudah otomatis ter-index karena unique
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};