<?php

class FinDocumentoFiscalAnotacao {
    private $id_documento_fiscal_anotacao = null;
    private $id_pessoa = null;
    private $id_documento_fiscal = null;
    private $dh_documento_fiscal_anotacao = null;
    private $ds_documento_fiscal_anotacao = null;
    
    function getIdDocumentoFiscalAnotacao() {
        return $this->id_documento_fiscal_anotacao;
    }

    function getIdPessoa() {
        return $this->id_pessoa;
    }

    function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    function getDhDocumentoFiscalAnotacao() {
        return $this->dh_documento_fiscal_anotacao;
    }

    function getDsDocumentoFiscalAnotacao() {
        return $this->ds_documento_fiscal_anotacao;
    }

    function setIdDocumentoFiscalAnotacao($id_documento_fiscal_anotacao) {
        $this->id_documento_fiscal_anotacao = $id_documento_fiscal_anotacao;
        return $this;
    }

    function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;
        return $this;
    }

    function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;
        return $this;
    }

    function setDhDocumentoFiscalAnotacao($dh_documento_fiscal_anotacao) {
        $this->dh_documento_fiscal_anotacao = $dh_documento_fiscal_anotacao;
        return $this;
    }

    function setDsDocumentoFiscalAnotacao($ds_documento_fiscal_anotacao) {
        $this->ds_documento_fiscal_anotacao = $ds_documento_fiscal_anotacao;
        return $this;
    }


}

