<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->date('date_of_birth')->nullable();

            $table->string('address', 256)->nullable();
            $table->string('phone_primary', 50)->nullable();
            $table->string('phone_secondary', 50)->nullable();
            $table->string('email', 256)->nullable();

            $table->string('gender', 50)->nullable();
            $table->string('driver_license', 100)->nullable();
            $table->string('family_group_id', 100)->nullable();

            $table->boolean('has_special_needs')->default(false);

            // Future badge support
            $table->string('profile_photo_path', 512)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
            $table->index('date_of_birth');
            $table->index('phone_primary');
            $table->index('family_group_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
