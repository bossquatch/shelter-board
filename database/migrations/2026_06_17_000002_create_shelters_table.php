<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shelters', function (Blueprint $table) {
            $table->id();

            $table->string('name', 256);
            $table->string('address', 256)->nullable();
            $table->string('municipality', 256)->nullable();
            $table->string('county', 256)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('postal_code', 20)->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->integer('capacity')->default(0);
            $table->integer('special_needs_capacity')->default(0);
            $table->integer('pet_capacity')->default(0);

            $table->boolean('ada_compliant')->default(false);
            $table->boolean('pet_friendly')->default(false);
            $table->boolean('backup_generator')->default(false);

            $table->string('status', 50)->default('Available');
            $table->boolean('is_active')->default(true);
            $table->text('comments')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'status']);
            $table->index(['county', 'municipality']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shelters');
    }
};
