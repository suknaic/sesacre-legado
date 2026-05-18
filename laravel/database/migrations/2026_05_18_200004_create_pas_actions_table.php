<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pas_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annual_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_action_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ppa_project_activity_id')->nullable()->constrained()->nullOnDelete();
            $table->text('partnership_desc')->nullable();
            $table->text('programming_goal')->nullable();
            $table->text('programming_indicator')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pas_actions');
    }
};
