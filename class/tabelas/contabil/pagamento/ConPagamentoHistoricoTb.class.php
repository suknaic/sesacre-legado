<?php

class ConPagamentoHistoricoTb {

    private $id_pagamento_historico = null;
    private $id_pagamento = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    private $id_doc_tipo_lotacao = null;
    private $id_pagamento_situacao = null;
    private $id_pagamento_status = null;
    private $dh_pagamento_historico = null;
    private $ds_pagamento_historico = null;

    public function getIdPagamentoHistorico() {
        return $this->id_pagamento_historico;
    }

    public function setIdPagamentoHistorico($id_pagamento_historico) {
        $this->id_pagamento_historico = $id_pagamento_historico;

        return $this;
    }

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;

        return $this;
    }

    public function getIdDocTipoLotacao() {
        return $this->id_doc_tipo_lotacao;
    }

    public function setIdDocTipoLotacao($id_doc_tipo_lotacao) {
        $this->id_doc_tipo_lotacao = $id_doc_tipo_lotacao;

        return $this;
    }

    public function getIdPagamentoSituacao() {
        return $this->id_pagamento_situacao;
    }

    public function setIdPagamentoSituacao($id_pagamento_situacao) {
        $this->id_pagamento_situacao = $id_pagamento_situacao;

        return $this;
    }

    public function getIdPagamentoStatus() {
        return $this->id_pagamento_status;
    }

    public function setIdPagamentoStatus($id_pagamento_status) {
        $this->id_pagamento_status = $id_pagamento_status;

        return $this;
    }

    public function getDhPagamentoHistorico() {
        return $this->dh_pagamento_historico;
    }

    public function setDhPagamentoHistorico($dh_pagamento_historico) {
        $this->dh_pagamento_historico = $dh_pagamento_historico;

        return $this;
    }

    public function getDsPagamentoHistorico() {
        return $this->ds_pagamento_historico;
    }

    public function setDsPagamentoHistorico($ds_pagamento_historico) {
        $this->ds_pagamento_historico = $ds_pagamento_historico;

        return $this;
    }

}
