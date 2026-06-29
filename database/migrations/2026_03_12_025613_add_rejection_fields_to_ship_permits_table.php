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
        Schema::table('ship_permits', function (Blueprint $table) {
            // Tambah kolom rejection_notes (text untuk catatan panjang)
            if (!Schema::hasColumn('ship_permits', 'rejection_notes')) {
                $table->text('rejection_notes')->nullable()->after('status');
            }

            // Tambah kolom rejected_by (siapa yang reject)
            if (!Schema::hasColumn('ship_permits', 'rejected_by')) {
                $table->string('rejected_by')->nullable()->after('rejection_notes');
            }

            // Tambah kolom rejected_at (kapan di-reject)
            if (!Schema::hasColumn('ship_permits', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }

            // Tambah kolom approved_by (siapa yang approve)
            // Catatan: approved_at harus sudah ada dari migration sebelumnya
            if (!Schema::hasColumn('ship_permits', 'approved_by')) {
                // Cek apakah approved_at ada
                if (Schema::hasColumn('ship_permits', 'approved_at')) {
                    $table->string('approved_by')->nullable()->after('approved_at');
                } else {
                    // Jika approved_at belum ada, tambahkan di akhir
                    $table->string('approved_by')->nullable();
                }
            }

            // Tambah kolom approved_at jika belum ada
            if (!Schema::hasColumn('ship_permits', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ship_permits', function (Blueprint $table) {
            $table->dropColumn(['rejection_notes', 'rejected_by', 'rejected_at', 'approved_by', 'approved_at']);
        });
    }
};
