<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            // Kita taruh kolom seat_id persis setelah booking_id biar rapi.
            // Kita kasih nullable() sementara, supaya kalau ada data lama di DB nggak error.
            $table->foreignId('seat_id')
                ->nullable()
                ->after('booking_id')
                ->constrained('seats')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('passengers', function (Blueprint $table) {
            // Wajib drop foreign key dulu sebelum drop kolomnya
            $table->dropForeign(['seat_id']);
            $table->dropColumn('seat_id');
        });
    }
};
