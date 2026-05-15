<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->string('rg', 20)->nullable();
            $table->string('issuing_agency', 50)->nullable();
            $table->foreignId('issuing_state_id')->nullable()->constrained('states')->nullOnDelete();
            $table->foreignId('marital_status_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('education_formation_id')->nullable()->constrained('education_formations')->nullOnDelete();
            $table->text('skills')->nullable();
            $table->string('father_name', 255)->nullable();
            $table->string('mother_name', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('cns_number', 20)->nullable();
            $table->text('photo_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_info');
    }
};
