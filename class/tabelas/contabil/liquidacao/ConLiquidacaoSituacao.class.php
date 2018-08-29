<?php

class ConLiquidacaoSituacao {

    private $id_liquidacao_situacao = null;
    private $nm_liquidacao_situacao = null;
    private $st_ativo = null;

    
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
     * Get the value of Nm Liquidacao Situacao
     *
     * @return mixed
     */
    public function getNmLiquidacaoSituacao()
    {
        return $this->nm_liquidacao_situacao;
    }

    /**
     * Set the value of Nm Liquidacao Situacao
     *
     * @param mixed nm_liquidacao_situacao
     *
     * @return self
     */
    public function setNmLiquidacaoSituacao($nm_liquidacao_situacao)
    {
        $this->nm_liquidacao_situacao = $nm_liquidacao_situacao;

        return $this;
    }

    /**
     * Get the value of St Ativo
     *
     * @return mixed
     */
    public function getStAtivo()
    {
        return $this->st_ativo;
    }

    /**
     * Set the value of St Ativo
     *
     * @param mixed st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo)
    {
        $this->st_ativo = $st_ativo;

        return $this;
    }

}
