<?php

class FinEntregaDocumentoTb {

    private $id_entrega_documento = null;
    private $id_documento_fiscal = null;
    private $id_entrega_confirmacao = null;
    private $vl_entrega_documento = null;
    private $vl_entrega_saldo = null;
    /**
     * @return mixed
     */
    public function getIdEntregaDocumento() {
        return $this->id_entrega_documento;
    }

    /**
     * @param mixed $id_entrega_documento
     *
     * @return self
     */
    public function setIdEntregaDocumento($id_entrega_documento) {
        $this->id_entrega_documento = $id_entrega_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    /**
     * @param mixed $id_documento_fiscal
     *
     * @return self
     */
    public function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdEntregaConfirmacao() {
        return $this->id_entrega_confirmacao;
    }

    /**
     * @param mixed $id_entrega_confirmacao
     *
     * @return self
     */
    public function setIdEntregaConfirmacao($id_entrega_confirmacao) {
        $this->id_entrega_confirmacao = $id_entrega_confirmacao;

        return $this;
    }
    
     /**
     * @return mixed
     */
    public function getVlEntregaDocumento() {
        return $this->vl_entrega_documento;
    }

    /**
     * @param mixed $vl_entrega_documento
     *
     * @return self
     */
    public function setVlEntregaDocumento($vl_entrega_documento) {
        $this->vl_entrega_documento = $vl_entrega_documento;

        return $this;
    }
    
    function getVlEntregaSaldo() {
        return $this->vl_entrega_saldo;
    }

    function setVlEntregaSaldo($vl_entrega_saldo) {
        $this->vl_entrega_saldo = $vl_entrega_saldo;
        return $this;
    }



}
