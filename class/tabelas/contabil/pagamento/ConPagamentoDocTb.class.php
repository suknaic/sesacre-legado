<?php

class ConPagamentoDocTb {

    private $id_pagamento_doc = null;
    private $id_pagamento = null;
    private $id_documento_fiscal = null;
    private $vl_documento_fiscal = null;
    private $vl_pagamento_doc_saldo = null;

    public function getIdPagamentoDoc() {
        return $this->id_pagamento_doc;
    }

    public function setIdPagamentoDoc($id_pagamento_doc) {
        $this->id_pagamento_doc = $id_pagamento_doc;

        return $this;
    }

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    public function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;

        return $this;
    }

    public function getVlDocumentoFiscal() {
        return $this->vl_documento_fiscal;
    }

    public function setVlDocumentoFiscal($vl_documento_fiscal) {
        $this->vl_documento_fiscal = $vl_documento_fiscal;

        return $this;
    }

    public function getVlPagamentoDocSaldo() {
        return $this->vl_pagamento_doc_saldo;
    }

    public function setVlPagamentoDocSaldo($vl_pagamento_doc_saldo) {
        $this->vl_pagamento_doc_saldo = $vl_pagamento_doc_saldo;

        return $this;
    }

}
