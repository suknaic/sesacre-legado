<?php

class ConLiquidacaoDoc {

    private $id_liquidacao_doc = null;
    private $id_liquidacao = null;
    private $id_documento_fiscal = null; 
    private $vl_liquidacao_doc = null;
    private $vl_liquidacao_doc_saldo = null;
    
    function getVlLiquidacaoDoc() {
        return $this->vl_liquidacao_doc;
    }

    function getVlLiquidacaoDocSaldo() {
        return $this->vl_liquidacao_doc_saldo;
    }

    function setVlLiquidacaoDoc($vl_liquidacao_doc) {
        $this->vl_liquidacao_doc = $vl_liquidacao_doc;
        return $this;
    }

    function setVlLiquidacaoDocSaldo($vl_liquidacao_doc_saldo) {
        $this->vl_liquidacao_doc_saldo = $vl_liquidacao_doc_saldo;
        return $this;
    }
    
    /**
     * Get the value of Id Liquidacao Doc
     *
     * @return mixed
     */
    public function getIdLiquidacaoDoc()
    {
        return $this->id_liquidacao_doc;
    }

    /**
     * Set the value of Id Liquidacao Doc
     *
     * @param mixed id_liquidacao_doc
     *
     * @return self
     */
    public function setIdLiquidacaoDoc($id_liquidacao_doc)
    {
        $this->id_liquidacao_doc = $id_liquidacao_doc;

        return $this;
    }

    /**
     * Get the value of Id Liquidacao
     *
     * @return mixed
     */
    public function getIdLiquidacao()
    {
        return $this->id_liquidacao;
    }

    /**
     * Set the value of Id Liquidacao
     *
     * @param mixed id_liquidacao
     *
     * @return self
     */
    public function setIdLiquidacao($id_liquidacao)
    {
        $this->id_liquidacao = $id_liquidacao;

        return $this;
    }

    /**
     * Get the value of Id Documento Fiscal
     *
     * @return mixed
     */
    public function getIdDocumentoFiscal()
    {
        return $this->id_documento_fiscal;
    }

    /**
     * Set the value of Id Documento Fiscal
     *
     * @param mixed id_documento_fiscal
     *
     * @return self
     */
    public function setIdDocumentoFiscal($id_documento_fiscal)
    {
        $this->id_documento_fiscal = $id_documento_fiscal;

        return $this;
    }

}
