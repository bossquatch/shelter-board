<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operational_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activation_shelter_id')->constrained('activation_shelters')->cascadeOnDelete();

            $table->string('category', 100)->default('General');
            $table->text('entry');
            $table->dateTime('logged_at');
            $table->foreignId('logged_by')->nullable()->constrained('users')->nullOnDelete();

            // Future WebEOC sync support
            $table->string('webeoc_record_id', 256)->nullable();
            $table->timestamp('webeoc_synced_at')->nullable();
            $table->string('sync_status', 50)->nullable();
            $table->text('sync_error')->nullable();

            $table->timestamps();

            $table->index(['activation_shelter_id', 'logged_at']);
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operational_logs');
    }
};
