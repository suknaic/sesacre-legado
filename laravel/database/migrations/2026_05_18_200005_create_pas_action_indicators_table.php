<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pas_action_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annual_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_action_id')->constrained()->cascadeOnDelete();
            $table->foreignId('health_indicator_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pas_action_indicators');
    }
};
