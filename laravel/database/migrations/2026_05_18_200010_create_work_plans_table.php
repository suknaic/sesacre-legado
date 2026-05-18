<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annual_plan_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('work_plan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_plan_id')->constrained()->cascadeOnDelete();
            $table->string('material_description');
            $table->decimal('quantity', 15, 2);
            $table->decimal('unit_value', 15, 2);
            $table->decimal('total_value', 15, 2);
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_plan_items');
        Schema::dropIfExists('work_plans');
    }
};
