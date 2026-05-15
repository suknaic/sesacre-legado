<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->date('purchase_date')->nullable();
            $table->text('brand')->nullable();
            $table->text('model')->nullable();
            $table->string('patrimony_number', 20)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->integer('warranty_months')->nullable();
            $table->string('serial_number', 255)->nullable();
            $table->string('state', 50)->nullable();
            $table->unsignedBigInteger('unit_measure_id')->nullable();
            $table->integer('ram_memory')->nullable();
            $table->text('processor')->nullable();
            $table->integer('hd_size')->nullable();
            $table->integer('power_supply')->nullable();
            $table->boolean('has_wireless')->default(false);
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_secondary_category_id')->nullable()->constrained('ticket_secondary_categories');
            $table->unsignedBigInteger('requester_person_id')->nullable();
            $table->unsignedBigInteger('service_person_id')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->text('description')->nullable();
            $table->string('requester_phone', 255)->nullable();
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->string('rating', 255)->nullable();
            $table->timestamp('rating_at')->nullable();
            $table->text('rating_comment')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->foreignId('ticket_status_id')->nullable()->constrained('ticket_statuses');
            $table->timestamp('scheduled_at')->nullable();
            $table->foreignId('ticket_priority_id')->nullable()->constrained('ticket_priorities');
            $table->timestamp('cancelled_at')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('ticket_secondary_category_id')->nullable()->constrained('ticket_secondary_categories');
            $table->time('hours_worked')->nullable();
            $table->text('service_description')->nullable();
            $table->decimal('service_value', 15, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('total_value', 15, 2)->nullable();
            $table->decimal('expense', 15, 2)->nullable();
            $table->text('expense_description')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_service_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_service_id')->constrained('ticket_services');
            $table->foreignId('material_id')->constrained('materials');
            $table->integer('quantity')->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->unsignedBigInteger('person_id')->nullable();
            $table->text('note');
            $table->timestamp('note_date')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->text('link')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('ticket_service_persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->unsignedBigInteger('person_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_service_persons');
        Schema::dropIfExists('ticket_attachments');
        Schema::dropIfExists('ticket_notes');
        Schema::dropIfExists('ticket_service_material');
        Schema::dropIfExists('ticket_services');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('materials');
    }
};
