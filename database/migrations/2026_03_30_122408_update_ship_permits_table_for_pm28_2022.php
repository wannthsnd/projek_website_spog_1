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
            // Tambah kolom yang hilang sesuai PM 28/2022

            // Identitas Pemohon
            if (!Schema::hasColumn('ship_permits', 'email')) {
                $table->string('email')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('ship_permits', 'name')) {
                $table->string('name')->nullable()->after('email');
            }

            // Data Kapal (Sesuai Format SPOG PM 28/2022)
            if (!Schema::hasColumn('ship_permits', 'flag')) {
                $table->string('flag', 100)->nullable()->after('ship_type'); // ✅ Bendera
            }
            if (!Schema::hasColumn('ship_permits', 'gross_tonnage')) {
                $table->integer('gross_tonnage')->nullable()->after('flag'); // ✅ Isi Kotor (GT)
            }
            if (!Schema::hasColumn('ship_permits', 'captain_name')) {
                $table->string('captain_name')->nullable()->after('gross_tonnage'); // ✅ Nakhoda
            }
            if (!Schema::hasColumn('ship_permits', 'owner_agent')) {
                $table->string('owner_agent')->nullable()->after('captain_name'); // ✅ Milik/Agent
            }

            // Rute & Keperluan
            if (!Schema::hasColumn('ship_permits', 'departure_location')) {
                $table->string('departure_location')->nullable()->after('owner_agent'); // ✅ Bergerak dari
            }
            if (!Schema::hasColumn('ship_permits', 'destination')) {
                $table->string('destination')->nullable()->after('departure_location'); // ✅ Ke (DLKr/DLKp)
            }
            if (!Schema::hasColumn('ship_permits', 'purpose')) {
                $table->text('purpose')->nullable()->after('destination'); // ✅ Keperluan
            }

            // Info Tambahan
            if (!Schema::hasColumn('ship_permits', 'movement_time')) {
                $table->string('movement_time', 255)->nullable()->after('passenger_count'); // ✅ Waktu Gerak
            }

            // Dokumen (5 dokumen wajib)
            if (!Schema::hasColumn('ship_permits', 'document_1')) {
                $table->string('document_1')->nullable()->after('application_date'); // Surat Permohonan
            }
            if (!Schema::hasColumn('ship_permits', 'document_2')) {
                $table->string('document_2')->nullable()->after('document_1'); // (tidak digunakan)
            }
            if (!Schema::hasColumn('ship_permits', 'document_3')) {
                $table->string('document_3')->nullable()->after('document_2'); // Data Awak Kapal
            }
            if (!Schema::hasColumn('ship_permits', 'document_4')) {
                $table->string('document_4')->nullable()->after('document_3'); // Dokumen Kapal Asli
            }
            if (!Schema::hasColumn('ship_permits', 'document_5')) {
                $table->string('document_5')->nullable()->after('document_4'); // Manifest Penumpang
            }
            if (!Schema::hasColumn('ship_permits', 'document_6')) {
                $table->string('document_6')->nullable()->after('document_5'); // Manifest Muatan
            }
            if (!Schema::hasColumn('ship_permits', 'document_7')) {
                $table->string('document_7')->nullable()->after('document_6'); // (tidak digunakan)
            }

            // UPT
            if (!Schema::hasColumn('ship_permits', 'upt_id')) {
                $table->foreignId('upt_id')->nullable()->constrained('upts')->onDelete('cascade')->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ship_permits', function (Blueprint $table) {
            // Drop kolom yang ditambahkan
            $table->dropColumn([
                'email',
                'name',
                'flag',
                'gross_tonnage',
                'captain_name',
                'owner_agent',
                'departure_location',
                'destination',
                'purpose',
                'movement_time',
                'document_1',
                'document_2',
                'document_3',
                'document_4',
                'document_5',
                'document_6',
                'document_7',
            ]);

            $table->dropForeign(['upt_id']);
            $table->dropColumn('upt_id');
        });
    }
};
