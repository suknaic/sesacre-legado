<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_situations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type', 1)->comment('F=Ferias, L=Licencas, C=Concessoes, A=Afastamentos, I=Inativos');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('recruitment_history', function (Blueprint $table) {
            $table->foreignId('contract_situation_id')->nullable()->constrained('contract_situations')->onDelete('set null');
            $table->text('observation')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('recruitment_history', function (Blueprint $table) {
            $table->dropForeign(['contract_situation_id']);
            $table->dropColumn(['contract_situation_id', 'observation']);
        });

        Schema::dropIfExists('contract_situations');
    }
};
