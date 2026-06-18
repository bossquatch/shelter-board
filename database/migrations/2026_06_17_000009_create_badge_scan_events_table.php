<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badge_scan_events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guest_badge_id')->constrained('guest_badges')->cascadeOnDelete();
            $table->foreignId('guest_stay_id')->nullable()->constrained('guest_stays')->nullOnDelete();
            $table->foreignId('act_shelter_id')->nullable()->constrained('activation_shelters')->nullOnDelete();

            $table->string('scan_type', 100);
            $table->dateTime('scanned_at');
            $table->foreignId('scanned_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('device_id', 256)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['act_shelter_id', 'scan_type', 'scanned_at']);
            $table->index(['guest_badge_id', 'scanned_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badge_scan_events');
    }
};
