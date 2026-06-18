<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_badges', function (Blueprint $table) {
            $table->id();

            $table->foreignId('guest_id')->constrained('guests')->cascadeOnDelete();
            $table->foreignId('guest_stay_id')->nullable()->constrained('guest_stays')->nullOnDelete();

            $table->uuid('badge_uuid')->unique();
            $table->string('badge_number', 100)->nullable();
            $table->text('qr_payload')->nullable();

            $table->dateTime('issued_at')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();

            $table->dateTime('printed_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('revoked_at')->nullable();

            $table->timestamps();

            $table->index(['guest_id', 'guest_stay_id']);
            $table->index(['issued_at', 'revoked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_badges');
    }
};
