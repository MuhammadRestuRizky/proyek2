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
        Schema::create('kosts', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users (pemilik kost)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('nama_kost');
            $table->text('alamat');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);

            $table->enum('tipe', ['Putra','Putri','Campur']);
            $table->enum('kamar_mandi', ['Dalam','Luar']);

            $table->string('foto')->nullable();

            $table->enum('status', ['Tersedia','Penuh'])
                  ->default('Tersedia');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kosts');
    }
};
