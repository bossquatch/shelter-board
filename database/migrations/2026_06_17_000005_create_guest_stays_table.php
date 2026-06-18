<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_stays', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activation_shelter_id')->constrained('activation_shelters')->cascadeOnDelete();
            $table->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();

            $table->string('status', 50)->default('Registered');

            $table->dateTime('checked_in_at')->nullable();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('checked_out_at')->nullable();
            $table->foreignId('checked_out_by')->nullable()->constrained('users')->nullOnDelete();

            $table->integer('pet_count')->default(0);
            $table->text('pet_description')->nullable();

            // Lightweight future badge support
            $table->dateTime('badge_issued_at')->nullable();
            $table->string('badge_number', 100)->nullable();

            $table->text('notes')->nullable();

            // Future WebEOC sync support
            $table->string('webeoc_record_id', 256)->nullable();
            $table->timestamp('webeoc_synced_at')->nullable();
            $table->string('sync_status', 50)->nullable();
            $table->text('sync_error')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['activation_shelter_id', 'status']);
            $table->index(['guest_id', 'status']);
            $table->index(['checked_in_at', 'checked_out_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_stays');
    }
};
