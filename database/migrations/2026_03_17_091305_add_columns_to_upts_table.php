<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('upts', function (Blueprint $table) {
            // Contact fields
            if (!Schema::hasColumn('upts', 'alamat')) {
                $table->text('alamat')->nullable()->after('region');
            }
            if (!Schema::hasColumn('upts', 'kota')) {
                $table->string('kota')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('upts', 'kode_pos')) {
                $table->string('kode_pos')->nullable()->after('kota');
            }
            if (!Schema::hasColumn('upts', 'telepon')) {
                $table->string('telepon')->nullable()->after('kode_pos');
            }
            if (!Schema::hasColumn('upts', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
            if (!Schema::hasColumn('upts', 'tgm')) {
                $table->string('tgm')->nullable()->after('website');
            }
            if (!Schema::hasColumn('upts', 'tlx')) {
                $table->string('tlx')->nullable()->after('tgm');
            }
            if (!Schema::hasColumn('upts', 'fax')) {
                $table->string('fax')->nullable()->after('tlx');
            }

            // Kepala Kantor fields
            if (!Schema::hasColumn('upts', 'kepala_kantor')) {
                $table->string('kepala_kantor')->nullable()->after('fax');
            }
            if (!Schema::hasColumn('upts', 'nip_kepala')) {
                $table->string('nip_kepala')->nullable()->after('kepala_kantor');
            }
        });
    }

    public function down(): void
    {
        Schema::table('upts', function (Blueprint $table) {
            $table->dropColumn([
                'alamat', 'kota', 'kode_pos', 'telepon', 'website',
                'tgm', 'tlx', 'fax', 'kepala_kantor', 'nip_kepala'
            ]);
        });
    }
};
