<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 255);
            $table->unsignedBigInteger('record_id')->nullable();
            $table->enum('action', ['C', 'U', 'D']);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('old_values')->nullable();
            $table->text('new_values')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('table_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
