<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom gender
        if (!Schema::hasColumn('kosts', 'gender')) {

    Schema::table('kosts', function (Blueprint $table) {

        $table->enum('gender', [
            'putra',
            'putri',
            'campur'
        ])->nullable()->after('tipe');

    });

}
        // Pindahkan data lama dari tipe -> gender
        DB::table('kosts')
            ->where('tipe', 'Putra')
            ->update([
                'gender' => 'putra',
                'tipe' => 'kost'
            ]);

        DB::table('kosts')
            ->where('tipe', 'Putri')
            ->update([
                'gender' => 'putri',
                'tipe' => 'kost'
            ]);

        DB::table('kosts')
            ->where('tipe', 'Campur')
            ->update([
                'gender' => 'campur',
                'tipe' => 'kost'
            ]);
    }

    public function down(): void
    {
        // Kembalikan data jika rollback
        DB::table('kosts')
            ->where('gender', 'putra')
            ->update([
                'tipe' => 'Putra'
            ]);

        DB::table('kosts')
            ->where('gender', 'putri')
            ->update([
                'tipe' => 'Putri'
            ]);

        DB::table('kosts')
            ->where('gender', 'campur')
            ->update([
                'tipe' => 'Campur'
            ]);

        Schema::table('kosts', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};