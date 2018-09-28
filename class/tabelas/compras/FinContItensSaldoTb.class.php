<?php

class FinContItensSaldotb{

    private $id_cont_itens_saldo = null;
    private $id_cont_itens_grupo = null;
    private $id_cont_itens = null;
    private $id_cont_itens_original = null;
    private $vl_cont_itens_saldo = null;
    private $dh_cont_itens_saldo = null;
    private $ds_cont_itens_saldo = null;
    private $st_ativo = null;
    
    /**
     * Get the value of Id Cont Itens Saldo
     *
     * @return mixed
     */
    public function getIdContItensSaldo()
    {
        return $this->id_cont_itens_saldo;
    }

    /**
     * Set the value of Id Cont Itens Saldo
     *
     * @param mixed id_cont_itens_saldo
     *
     * @return self
     */
    public function setIdContItensSaldo($id_cont_itens_saldo)
    {
        $this->id_cont_itens_saldo = $id_cont_itens_saldo;

        return $this;
    }

    /**
     * Get the value of Id Cont Itens Grupo
     *
     * @return mixed
     */
    public function getIdContItensGrupo()
    {
        return $this->id_cont_itens_grupo;
    }

    /**
     * Set the value of Id Cont Itens Grupo
     *
     * @param mixed id_cont_itens_grupo
     *
     * @return self
     */
    public function setIdContItensGrupo($id_cont_itens_grupo)
    {
        $this->id_cont_itens_grupo = $id_cont_itens_grupo;

        return $this;
    }

    /**
     * Get the value of Id Cont Itens
     *
     * @return mixed
     */
    public function getIdContItens()
    {
        return $this->id_cont_itens;
    }

    /**
     * Set the value of Id Cont Itens
     *
     * @param mixed id_cont_itens
     *
     * @return self
     */
    public function setIdContItens($id_cont_itens)
    {
        $this->id_cont_itens = $id_cont_itens;

        return $this;
    }

    /**
     * Get the value of Id Cont Itens Original
     *
     * @return mixed
     */
    public function getIdContItensOriginal()
    {
        return $this->id_cont_itens_original;
    }

    /**
     * Set the value of Id Cont Itens Original
     *
     * @param mixed id_cont_itens_original
     *
     * @return self
     */
    public function setIdContItensOriginal($id_cont_itens_original)
    {
        $this->id_cont_itens_original = $id_cont_itens_original;

        return $this;
    }

    /**
     * Get the value of Vl Cont Itens Saldo
     *
     * @return mixed
     */
    public function getVlContItensSaldo()
    {
        return $this->vl_cont_itens_saldo;
    }

    /**
     * Set the value of Vl Cont Itens Saldo
     *
     * @param mixed vl_cont_itens_saldo
     *
     * @return self
     */
    public function setVlContItensSaldo($vl_cont_itens_saldo)
    {
        $this->vl_cont_itens_saldo = $vl_cont_itens_saldo;

        return $this;
    }

    /**
     * Get the value of Dh Cont Itens Saldo
     *
     * @return mixed
     */
    public function getDhContItensSaldo()
    {
        return $this->dh_cont_itens_saldo;
    }

    /**
     * Set the value of Dh Cont Itens Saldo
     *
     * @param mixed dh_cont_itens_saldo
     *
     * @return self
     */
    public function setDhContItensSaldo($dh_cont_itens_saldo)
    {
        $this->dh_cont_itens_saldo = $dh_cont_itens_saldo;

        return $this;
    }

    /**
     * Get the value of Ds Cont Itens Saldo
     *
     * @return mixed
     */
    public function getDsContItensSaldo()
    {
        return $this->ds_cont_itens_saldo;
    }

    /**
     * Set the value of Ds Cont Itens Saldo
     *
     * @param mixed ds_cont_itens_saldo
     *
     * @return self
     */
    public function setDsContItensSaldo($ds_cont_itens_saldo)
    {
        $this->ds_cont_itens_saldo = $ds_cont_itens_saldo;

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
