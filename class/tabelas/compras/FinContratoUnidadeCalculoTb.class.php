<?php

class FinContratoUnidadeCalculoTb{

    private $id_contrato_unidade_calculo = null;
    private $nm_contrato_unidade_calculo = null;
    private $st_ativo = null;
    

    /**
     * Get the value of Id Contrato Unidade Calculo
     *
     * @return mixed
     */
    public function getIdContratoUnidadeCalculo()
    {
        return $this->id_contrato_unidade_calculo;
    }

    /**
     * Set the value of Id Contrato Unidade Calculo
     *
     * @param mixed id_contrato_unidade_calculo
     *
     * @return self
     */
    public function setIdContratoUnidadeCalculo($id_contrato_unidade_calculo)
    {
        $this->id_contrato_unidade_calculo = $id_contrato_unidade_calculo;

        return $this;
    }

    /**
     * Get the value of Nm Contrato Unidade Calculo
     *
     * @return mixed
     */
    public function getNmContratoUnidadeCalculo()
    {
        return $this->nm_contrato_unidade_calculo;
    }

    /**
     * Set the value of Nm Contrato Unidade Calculo
     *
     * @param mixed nm_contrato_unidade_calculo
     *
     * @return self
     */
    public function setNmContratoUnidadeCalculo($nm_contrato_unidade_calculo)
    {
        $this->nm_contrato_unidade_calculo = $nm_contrato_unidade_calculo;

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
