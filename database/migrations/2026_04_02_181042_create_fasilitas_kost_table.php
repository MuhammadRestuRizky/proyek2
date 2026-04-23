<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fasilitas_kost', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kost_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fasilitas_id')->constrained()->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fasilitas_kost');
    }
};
