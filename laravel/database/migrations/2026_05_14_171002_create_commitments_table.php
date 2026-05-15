<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commitments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->unsignedBigInteger('person_id')->nullable();
            $table->foreignId('commitment_type_id')->nullable()->constrained('commitment_types');
            $table->string('number', 255)->nullable();
            $table->date('system_date')->nullable();
            $table->date('external_date')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('description')->nullable();
            $table->smallInteger('situation')->default(1);
            $table->foreignId('commitment_status_id')->nullable()->constrained('commitment_statuses');
            $table->unsignedBigInteger('document_routing_type_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamps();
        });

        Schema::create('commitment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commitment_id')->constrained('commitments');
            $table->unsignedBigInteger('person_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('document_routing_type_id')->nullable();
            $table->foreignId('commitment_situation_id')->nullable()->constrained('commitment_situations');
            $table->foreignId('commitment_status_id')->nullable()->constrained('commitment_statuses');
            $table->timestamp('history_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('commitment_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commitment_id')->constrained('commitments');
            $table->unsignedBigInteger('person_id')->nullable();
            $table->text('note');
            $table->timestamp('note_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commitment_notes');
        Schema::dropIfExists('commitment_history');
        Schema::dropIfExists('commitments');
    }
};
