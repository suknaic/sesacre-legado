<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('travel_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('transport_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('decree_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('travel_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::create('per_diem_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_type_id')->nullable()->constrained('travel_types');
            $table->unsignedBigInteger('applicant_person_id')->nullable();
            $table->unsignedBigInteger('applicant_role_id')->nullable();
            $table->unsignedBigInteger('applicant_department_id')->nullable();
            $table->unsignedBigInteger('proposed_person_id')->nullable();
            $table->unsignedBigInteger('proposed_role_id')->nullable();
            $table->unsignedBigInteger('proposed_department_id')->nullable();
            $table->text('service_description')->nullable();
            $table->text('locations')->nullable();
            $table->text('notes')->nullable();
            $table->date('creation_date')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->unsignedBigInteger('requester_person_id')->nullable();
            $table->unsignedBigInteger('requester_department_id')->nullable();
            $table->unsignedBigInteger('requester_center_id')->nullable();
            $table->boolean('has_return')->default(true);
            $table->unsignedBigInteger('purchase_request_id')->nullable();
            $table->unsignedBigInteger('parent_per_diem_id')->nullable();
            $table->unsignedBigInteger('report_id')->nullable();
            $table->smallInteger('stage')->default(1);
            $table->boolean('is_active')->default(true);
            $table->string('protocol_number', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('per_diem_destinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('per_diem_request_id')->constrained('per_diem_requests');
            $table->unsignedBigInteger('origin_city_id')->nullable();
            $table->unsignedBigInteger('destination_city_id')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
            $table->unsignedBigInteger('transport_id')->nullable();
            $table->unsignedBigInteger('decree_id')->nullable();
            $table->unsignedBigInteger('travel_class_id')->nullable();
            $table->boolean('has_overnight_stay')->default(true);
            $table->integer('quantity')->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('per_diem_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('per_diem_request_id')->constrained('per_diem_requests');
            $table->unsignedBigInteger('person_id')->nullable();
            $table->timestamp('history_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('decree_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decree_type_id')->nullable()->constrained('decree_types');
            $table->unsignedBigInteger('travel_class_id')->nullable();
            $table->decimal('value', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('per_diem_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('per_diem_request_id')->nullable()->constrained('per_diem_requests');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decree_values');
        Schema::dropIfExists('per_diem_history');
        Schema::dropIfExists('per_diem_destinations');
        Schema::dropIfExists('per_diem_reports');
        Schema::dropIfExists('per_diem_requests');
        Schema::dropIfExists('travel_types');
        Schema::dropIfExists('decree_types');
        Schema::dropIfExists('transport_types');
        Schema::dropIfExists('travel_classes');
    }
};
