<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pas_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annual_plan_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->smallInteger('validation_status')->default(1);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pas_validations');
    }
};
