<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamentoDoc.class.php";
class ConPagamentoDoc {

    private $id_pagamento_doc = null;
    private $id_pagamento = null;
    private $id_documento_fiscal = null;
    private $vl_documento_fiscal = null;
    private $vl_pagamento_doc_saldo = null;
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

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

    public function salvaDocPagamento(PDO $pdo) {
        try {

            if (!empty($this->id_documento_fiscal) && !empty($this->id_pagamento) && !empty($this->vl_documento_fiscal) && !empty($this->vl_pagamento_doc_saldo)) {
                
                $daoConPagamentoDoc = new DaoConPagamentoDoc();
                $daoConPagamentoDoc->setIdPagamento($this->id_pagamento);
                $daoConPagamentoDoc->setIdDocumentoFiscal($this->id_documento_fiscal);
                $daoConPagamentoDoc->setVlDocumentoFiscal(Metodos::ConverteValorIng($this->vl_documento_fiscal));
                $daoConPagamentoDoc->setVlPagamentoDocSaldo($this->vl_pagamento_doc_saldo);
                $daoConPagamentoDoc->salvaDocPagamento($pdo);
                if($daoConPagamentoDoc->Sucesso()){
                    $this->sucesso = true;
                   
                }else{
                    $this->sucesso = false;
                    $this->msgRetorno = $daoConPagamentoDoc->getMsgRetorno();
                }
                
            } else {
                $this->sucesso = false;
                $this->msgRetorno = STR_PREENCHER_CAMPOS;
            }
        } catch (Exception $ex) { 
            
        }
    }

}
