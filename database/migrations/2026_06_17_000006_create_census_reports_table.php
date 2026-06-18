<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('census_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activation_shelter_id')->constrained('activation_shelters')->cascadeOnDelete();

            $table->dateTime('reported_at');
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();

            $table->integer('clients')->default(0);
            $table->integer('caregivers')->default(0);
            $table->integer('staff')->default(0);
            $table->integer('pets')->default(0);
            $table->integer('service_animals')->default(0);

            $table->text('notes')->nullable();

            // Future WebEOC sync support
            $table->string('webeoc_record_id', 256)->nullable();
            $table->timestamp('webeoc_synced_at')->nullable();
            $table->string('sync_status', 50)->nullable();
            $table->text('sync_error')->nullable();

            $table->timestamps();

            $table->index(['activation_shelter_id', 'reported_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('census_reports');
    }
};
