<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('cnpj', 18)->nullable();
            $table->string('cnae', 20)->nullable();
            $table->string('state_registration', 20)->nullable();
            $table->string('municipal_registration', 20)->nullable();
            $table->date('founding_date')->nullable();
            $table->string('trade_name', 255)->nullable();
            $table->string('safira_number', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_entities');
    }
};
