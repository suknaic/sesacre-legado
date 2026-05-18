<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('per_diem_requests', function (Blueprint $table) {
            $table->foreignId('transport_type_id')->nullable()->constrained('transport_types');
            $table->foreignId('decree_type_id')->nullable()->constrained('decree_types');
            $table->foreignId('travel_class_id')->nullable()->constrained('travel_classes');
        });
    }

    public function down(): void
    {
        Schema::table('per_diem_requests', function (Blueprint $table) {
            $table->dropForeign(['transport_type_id']);
            $table->dropForeign(['decree_type_id']);
            $table->dropForeign(['travel_class_id']);
            $table->dropColumn(['transport_type_id', 'decree_type_id', 'travel_class_id']);
        });
    }
};
