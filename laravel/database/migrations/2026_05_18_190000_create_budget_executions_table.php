<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budget_executions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('budget_proposal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_action_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('not_started');
            $table->decimal('executed_amount', 15, 2)->default(0);
            $table->date('execution_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budget_executions');
    }
};
