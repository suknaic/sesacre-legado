<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('legal_entity_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->smallInteger('situation')->default(1);
            $table->timestamps();
        });

        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('number', 255)->nullable();
            $table->unsignedBigInteger('request_type_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('ordinance_id')->nullable();
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->unsignedBigInteger('budget_source_id')->nullable();
            $table->unsignedBigInteger('work_program_id')->nullable();
            $table->unsignedBigInteger('expense_element_id')->nullable();
            $table->unsignedBigInteger('expense_type_id')->nullable();
            $table->unsignedBigInteger('spending_type_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('request_date')->nullable();
            $table->smallInteger('situation')->default(1);
            $table->unsignedBigInteger('purchase_request_situation_id')->nullable();
            $table->timestamps();
        });

        Schema::create('procurements', function (Blueprint $table) {
            $table->id();
            $table->string('ada_code', 20)->nullable();
            $table->string('auction_code', 20)->nullable();
            $table->decimal('estimated_total', 15, 2)->default(0);
            $table->decimal('adjudicated_total', 15, 2)->default(0);
            $table->date('process_date')->nullable();
            $table->foreignId('procurement_object_id')->nullable()->constrained('procurement_objects');
            $table->foreignId('procurement_modality_id')->nullable()->constrained('procurement_modalities');
            $table->foreignId('procurement_situation_id')->nullable()->constrained('procurement_situations');
            $table->integer('year')->nullable();
            $table->string('technical_manager', 255)->nullable();
            $table->unsignedBigInteger('spending_type_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurements');
        Schema::dropIfExists('purchase_requests');
        Schema::dropIfExists('suppliers');
    }
};
