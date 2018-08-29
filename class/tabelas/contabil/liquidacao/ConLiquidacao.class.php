<?php

class ConLiquidacao {

    private $id_liquidacao = null;
    private $nr_liquidacao = null;
    private $id_empenho = null;
    private $id_liquidacao_situacao = null;
    private $id_lotacao = null;
    private $dt_liquidacao = null;
    private $vl_liquidacao = null;
    private $ds_liquidacao = null;
    private $st_ativo = null;

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
     * Get the value of Nr Liquidacao
     *
     * @return mixed
     */
    public function getNrLiquidacao()
    {
        return $this->nr_liquidacao;
    }

    /**
     * Set the value of Nr Liquidacao
     *
     * @param mixed nr_liquidacao
     *
     * @return self
     */
    public function setNrLiquidacao($nr_liquidacao)
    {
        $this->nr_liquidacao = $nr_liquidacao;

        return $this;
    }

    /**
     * Get the value of Id Empenho
     *
     * @return mixed
     */
    public function getIdEmpenho()
    {
        return $this->id_empenho;
    }

    /**
     * Set the value of Id Empenho
     *
     * @param mixed id_empenho
     *
     * @return self
     */
    public function setIdEmpenho($id_empenho)
    {
        $this->id_empenho = $id_empenho;

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
     * Get the value of Dt Liquidacao
     *
     * @return mixed
     */
    public function getDtLiquidacao()
    {
        return $this->dt_liquidacao;
    }

    /**
     * Set the value of Dt Liquidacao
     *
     * @param mixed dt_liquidacao
     *
     * @return self
     */
    public function setDtLiquidacao($dt_liquidacao)
    {
        $this->dt_liquidacao = $dt_liquidacao;

        return $this;
    }

    /**
     * Get the value of Vl Liquidacao
     *
     * @return mixed
     */
    public function getVlLiquidacao()
    {
        return $this->vl_liquidacao;
    }

    /**
     * Set the value of Vl Liquidacao
     *
     * @param mixed vl_liquidacao
     *
     * @return self
     */
    public function setVlLiquidacao($vl_liquidacao)
    {
        $this->vl_liquidacao = $vl_liquidacao;

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
    
    public function getStAtivo() {
        return $this->st_ativo;
    }

    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;
        return $this;
    }



}
