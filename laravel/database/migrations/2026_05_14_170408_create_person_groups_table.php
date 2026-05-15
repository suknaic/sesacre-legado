<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('person_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('person_group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['person_group_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('person_group_user');
        Schema::dropIfExists('person_groups');
    }
};
