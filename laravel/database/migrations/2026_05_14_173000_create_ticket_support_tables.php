<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_category_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_category_id')->constrained('ticket_categories');
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_primary_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_category_type_id')->constrained('ticket_category_types');
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_secondary_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_primary_category_id')->constrained('ticket_primary_categories');
            $table->string('name', 255);
            $table->decimal('value', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ticket_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_conditions');
        Schema::dropIfExists('ticket_statuses');
        Schema::dropIfExists('ticket_priorities');
        Schema::dropIfExists('ticket_secondary_categories');
        Schema::dropIfExists('ticket_primary_categories');
        Schema::dropIfExists('ticket_category_types');
        Schema::dropIfExists('ticket_categories');
    }
};
