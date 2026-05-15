<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 14)->nullable()->unique()->after('email');
            $table->string('phone', 20)->nullable()->after('password');
            $table->string('mobile', 20)->nullable()->after('phone');
            $table->text('address')->nullable()->after('mobile');
            $table->string('neighborhood', 255)->nullable()->after('address');
            $table->string('complement', 255)->nullable()->after('neighborhood');
            $table->string('zip_code', 20)->nullable()->after('complement');
            $table->string('street_number', 10)->nullable()->after('zip_code');
            $table->foreignId('city_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('birth_city_id')->nullable()->constrained('cities')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'cpf', 'phone', 'mobile', 'address', 'neighborhood',
                'complement', 'zip_code', 'street_number', 'city_id',
                'birth_city_id', 'notes', 'last_login_at', 'is_active',
            ]);
            $table->dropSoftDeletes();
        });
    }
};
