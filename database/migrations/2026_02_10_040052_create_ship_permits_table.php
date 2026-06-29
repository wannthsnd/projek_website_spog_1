<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ship_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('upt_id')->nullable()->constrained()->onDelete('set null');

            // Ship Info
            $table->string('ship_type');
            $table->string('ship_name');
            $table->string('ship_size')->nullable();
            $table->integer('ship_capacity')->nullable();

            // Owner Info
            $table->string('owner_name');
            $table->text('owner_address');
            $table->string('owner_phone');

            // Permit Info
            $table->text('purpose');
            $table->date('application_date'); // ✅ Pastikan ini date
            $table->date('departure_date')->nullable(); // ✅ Pastikan ini date
            $table->string('departure_location')->nullable();
            $table->string('destination')->nullable();
            $table->integer('crew_count')->default(0);
            $table->integer('passenger_count')->default(0);

            // Status
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_notes')->nullable();

            // Approval Info
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();

            // Documents
            $table->json('documents')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ship_permits');
    }
};
