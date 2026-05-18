<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->string('bukti_pembayaran')->nullable();

            $table->string('status_pembayaran')
                  ->default('belum_bayar');

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn([
                'bukti_pembayaran',
                'status_pembayaran'
            ]);

        });
    }
};