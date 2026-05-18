<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ppa_project_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('strategic_plan_id')->constrained('strategic_plans');
            $table->string('code');
            $table->string('name');
            $table->string('type', 1)->comment('P = Projeto, A = Atividade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppa_project_activities');
    }
};
