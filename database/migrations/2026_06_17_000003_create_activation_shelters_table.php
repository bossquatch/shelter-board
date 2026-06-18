<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activation_shelters', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activation_id')->constrained('activations')->cascadeOnDelete();
            $table->foreignId('shelter_id')->constrained('shelters')->cascadeOnDelete();

            $table->string('status', 50)->default('Standby');

            $table->dateTime('opened_at')->nullable();
            $table->foreignId('opened_by')->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('closed_at')->nullable();
            $table->foreignId('closed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->integer('current_capacity')->default(0);
            $table->integer('current_occupancy')->default(0);

            $table->text('notes')->nullable();

            // Future WebEOC sync support
            $table->string('webeoc_record_id', 256)->nullable();
            $table->timestamp('webeoc_synced_at')->nullable();
            $table->string('sync_status', 50)->nullable();
            $table->text('sync_error')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['activation_id', 'shelter_id']);
            $table->index(['status', 'opened_at', 'closed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activation_shelters');
    }
};
