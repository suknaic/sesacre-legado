<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('strategic_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->integer('start_year')->nullable();
            $table->integer('end_year')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('plan_objectives', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('indicator', 255)->nullable();
            $table->text('goal')->nullable();
            $table->string('registration_type', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamps();
        });

        Schema::create('plan_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_objective_id')->nullable()->constrained('plan_objectives');
            $table->string('name', 255);
            $table->string('indicator', 255)->nullable();
            $table->text('goal')->nullable();
            $table->string('registration_type', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamps();
        });

        Schema::create('annual_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('strategic_plan_id')->nullable()->constrained('strategic_plans');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('name', 255);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('responsible_person_id')->nullable();
            $table->unsignedBigInteger('executor_person_id')->nullable();
            $table->text('observations')->nullable();
            $table->smallInteger('situation')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('budget_proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->nullable();
            $table->smallInteger('situation')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('measurement_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('plan_materials', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable();
            $table->string('name', 255);
            $table->string('description_code', 20)->nullable();
            $table->string('description_name', 255)->nullable();
            $table->string('group_code', 20)->nullable();
            $table->string('group_name', 255)->nullable();
            $table->string('subgroup_code', 20)->nullable();
            $table->string('subgroup_name', 255)->nullable();
            $table->string('material_type', 50)->nullable();
            $table->string('expense_element_code', 20)->nullable();
            $table->unsignedBigInteger('expense_type_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_materials');
        Schema::dropIfExists('measurement_units');
        Schema::dropIfExists('budget_proposals');
        Schema::dropIfExists('annual_plans');
        Schema::dropIfExists('plan_actions');
        Schema::dropIfExists('plan_objectives');
        Schema::dropIfExists('strategic_plans');
    }
};
