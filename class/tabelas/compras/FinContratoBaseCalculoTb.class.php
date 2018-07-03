<?php

class FinContratoBaseCalculoTb{

    private $id_contrato_base_calculo = null;
    private $nm_contrato_base_caculo = null;
    private $st_ativo = null;

    
    /**
     * Get the value of Id Contrato Base Calculo
     *
     * @return mixed
     */
    public function getIdContratoBaseCalculo()
    {
        return $this->id_contrato_base_calculo;
    }

    /**
     * Set the value of Id Contrato Base Calculo
     *
     * @param mixed id_contrato_base_calculo
     *
     * @return self
     */
    public function setIdContratoBaseCalculo($id_contrato_base_calculo)
    {
        $this->id_contrato_base_calculo = $id_contrato_base_calculo;

        return $this;
    }

    /**
     * Get the value of Nm Contrato Base Caculo
     *
     * @return mixed
     */
    public function getNmContratoBaseCaculo()
    {
        return $this->nm_contrato_base_caculo;
    }

    /**
     * Set the value of Nm Contrato Base Caculo
     *
     * @param mixed nm_contrato_base_caculo
     *
     * @return self
     */
    public function setNmContratoBaseCaculo($nm_contrato_base_caculo)
    {
        $this->nm_contrato_base_caculo = $nm_contrato_base_caculo;

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
