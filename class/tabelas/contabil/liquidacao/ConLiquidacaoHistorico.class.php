<?php

class ConLiquidacaoHistorico {

    private $id_liquidacao_historico = null;
    private $id_liquidacao = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
    private $id_liquidacao_situacao = null;
    private $id_liquidacao_status = null;
    private $dh_liquidacao_historico = null;
    private $ds_liquidacao = null;
    
    private $id_doc_tipo_lotacao = null;
    
    function getIdLiquidacaoStatus() {
        return $this->id_liquidacao_status;
    }

    function setIdLiquidacaoStatus($id_liquidacao_status) {
        $this->id_liquidacao_status = $id_liquidacao_status;
        return $this;
    }
    
    function getIdLiquidacao() {
        return $this->id_liquidacao;
    }

    function setIdLiquidacao($id_liquidacao) {
        $this->id_liquidacao = $id_liquidacao;
        return $this;
    }

        
    function getIdDocTipoLotacao() {
        return $this->id_doc_tipo_lotacao;
    }

    function setIdDocTipoLotacao($id_doc_tipo_lotacao) {
        $this->id_doc_tipo_lotacao = $id_doc_tipo_lotacao;
        return $this;
    }
    
    /**
     * Get the value of Id Liquidacao Historico
     *
     * @return mixed
     */
    public function getIdLiquidacaoHistorico()
    {
        return $this->id_liquidacao_historico;
    }

    /**
     * Set the value of Id Liquidacao Historico
     *
     * @param mixed id_liquidacao_historico
     *
     * @return self
     */
    public function setIdLiquidacaoHistorico($id_liquidacao_historico)
    {
        $this->id_liquidacao_historico = $id_liquidacao_historico;

        return $this;
    }

    /**
     * Get the value of Id Pessoa
     *
     * @return mixed
     */
    public function getIdPessoa()
    {
        return $this->id_pessoa;
    }

    /**
     * Set the value of Id Pessoa
     *
     * @param mixed id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * Get the value of Id Lotacao
     *
     * @return mixed
     */
    public function getIdLotacao()
    {
        return $this->id_lotacao;
    }

    /**
     * Set the value of Id Lotacao
     *
     * @param mixed id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao)
    {
        $this->id_lotacao = $id_lotacao;

        return $this;
    }

    /**
     * Get the value of Id Liquidacao Situacao
     *
     * @return mixed
     */
    public function getIdLiquidacaoSituacao()
    {
        return $this->id_liquidacao_situacao;
    }

    /**
     * Set the value of Id Liquidacao Situacao
     *
     * @param mixed id_liquidacao_situacao
     *
     * @return self
     */
    public function setIdLiquidacaoSituacao($id_liquidacao_situacao)
    {
        $this->id_liquidacao_situacao = $id_liquidacao_situacao;

        return $this;
    }

    /**
     * Get the value of Dh Liquidacao Historico
     *
     * @return mixed
     */
    public function getDhLiquidacaoHistorico()
    {
        return $this->dh_liquidacao_historico;
    }

    /**
     * Set the value of Dh Liquidacao Historico
     *
     * @param mixed dh_liquidacao_historico
     *
     * @return self
     */
    public function setDhLiquidacaoHistorico($dh_liquidacao_historico)
    {
        $this->dh_liquidacao_historico = $dh_liquidacao_historico;

        return $this;
    }

    /**
     * Get the value of Ds Liquidacao
     *
     * @return mixed
     */
    public function getDsLiquidacao()
    {
        return $this->ds_liquidacao;
    }

    /**
     * Set the value of Ds Liquidacao
     *
     * @param mixed ds_liquidacao
     *
     * @return self
     */
    public function setDsLiquidacao($ds_liquidacao)
    {
        $this->ds_liquidacao = $ds_liquidacao;

        return $this;
    }

}
