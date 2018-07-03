<?php

class FinContratoAquisicaoTb{

    private $id_contrato_aquisicao = null;
    private $nm_contrato_aquisicao = null;
    private $st_ativo = null;

    
    /**
     * Get the value of Id Contrato Aquisicao
     *
     * @return mixed
     */
    public function getIdContratoAquisicao()
    {
        return $this->id_contrato_aquisicao;
    }

    /**
     * Set the value of Id Contrato Aquisicao
     *
     * @param mixed id_contrato_aquisicao
     *
     * @return self
     */
    public function setIdContratoAquisicao($id_contrato_aquisicao)
    {
        $this->id_contrato_aquisicao = $id_contrato_aquisicao;

        return $this;
    }

    /**
     * Get the value of Nm Contrato Aquisicao
     *
     * @return mixed
     */
    public function getNmContratoAquisicao()
    {
        return $this->nm_contrato_aquisicao;
    }

    /**
     * Set the value of Nm Contrato Aquisicao
     *
     * @param mixed nm_contrato_aquisicao
     *
     * @return self
     */
    public function setNmContratoAquisicao($nm_contrato_aquisicao)
    {
        $this->nm_contrato_aquisicao = $nm_contrato_aquisicao;

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
