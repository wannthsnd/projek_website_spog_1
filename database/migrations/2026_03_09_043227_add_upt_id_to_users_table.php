<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('upt_id')->nullable()->after('role')->constrained('upts')->onDelete('set null');
            $table->index('upt_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['upt_id']);
            $table->dropIndex(['upt_id']);
            $table->dropColumn('upt_id');
        });
    }
};
