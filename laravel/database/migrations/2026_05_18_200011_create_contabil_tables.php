<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('fin_empenho')) {
            Schema::create('fin_empenho', function (Blueprint $table) {
                $table->integer('id_empenho')->primary()->autoincrement();
                $table->integer('id_pedido')->nullable();
                $table->integer('id_pessoa')->nullable();
                $table->integer('id_tipo_empenho')->nullable();
                $table->string('nr_empenho')->nullable();
                $table->date('dt_empenho_sistema')->nullable();
                $table->date('dt_empenho_safira')->nullable();
                $table->decimal('vl_empenho', 15, 2)->nullable();
                $table->text('ds_empenho')->nullable();
                $table->smallInteger('sit_empenho')->nullable();
                $table->integer('id_empenho_status')->nullable();
                $table->integer('id_doc_tipo_lotacao')->nullable();
                $table->integer('id_lotacao')->nullable();
            });
        }

        if (! Schema::hasTable('con_liquidacao')) {
            Schema::create('con_liquidacao', function (Blueprint $table) {
                $table->integer('id_liquidacao')->primary()->autoincrement();
                $table->string('nr_liquidacao')->nullable();
                $table->integer('id_empenho')->nullable();
                $table->integer('id_liquidacao_situacao')->nullable();
                $table->integer('id_liquidacao_status')->nullable();
                $table->integer('id_lotacao')->nullable();
                $table->integer('id_doc_tipo_lotacao')->nullable();
                $table->date('dt_liquidacao')->nullable();
                $table->decimal('vl_liquidacao', 15, 2)->nullable();
                $table->decimal('vl_liquidacao_saldo', 15, 2)->nullable();
                $table->text('ds_liquidacao')->nullable();
                $table->smallInteger('st_ativo')->nullable();
            });
        }

        if (! Schema::hasTable('con_pagamento')) {
            Schema::create('con_pagamento', function (Blueprint $table) {
                $table->integer('id_pagamento')->primary()->autoincrement();
                $table->integer('id_pagamento_situacao')->nullable();
                $table->integer('id_pagamento_status')->nullable();
                $table->integer('id_liquidacao')->nullable();
                $table->integer('id_liquidacao_situacao')->nullable();
                $table->integer('id_lotacao')->nullable();
                $table->integer('id_doc_tipo_lotacao')->nullable();
                $table->string('nr_pagamento')->nullable();
                $table->date('dt_pagamento')->nullable();
                $table->decimal('vl_pagamento', 15, 2)->nullable();
                $table->decimal('vl_pagamento_saldo', 15, 2)->nullable();
                $table->text('ds_pagamento')->nullable();
                $table->smallInteger('st_ativo')->nullable();
                $table->string('docs_pagamento')->nullable();
            });
        }

        if (! Schema::hasTable('con_empenho_anulacao')) {
            Schema::create('con_empenho_anulacao', function (Blueprint $table) {
                $table->integer('id_empenho_anulacao')->primary()->autoincrement();
                $table->integer('id_pedido')->nullable();
                $table->string('nr_empenho_anulacao')->nullable();
                $table->date('dt_empenho_anulacao')->nullable();
                $table->timestamp('dh_empenho_anulacao')->nullable();
                $table->decimal('vl_empenho_anulacao', 15, 2)->nullable();
                $table->decimal('vl_empenho_antigo', 15, 2)->nullable();
                $table->integer('id_empenho_anulacao_situacao')->nullable();
                $table->integer('id_empenho_anulacao_status')->nullable();
                $table->integer('id_pessoa')->nullable();
                $table->integer('id_lotacao')->nullable();
                $table->integer('id_doc_tipo_lotacao')->nullable();
                $table->decimal('vl_empenho_saldo', 15, 2)->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('con_empenho_anulacao');
        Schema::dropIfExists('con_pagamento');
        Schema::dropIfExists('con_liquidacao');
        Schema::dropIfExists('fin_empenho');
    }
};
