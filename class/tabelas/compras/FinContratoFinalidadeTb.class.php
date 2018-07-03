<?php

class FinContratoFinalidadeTb{

    private $id_contrato_finalidade = null;
    private $nm_contrato_finalidade = null;
    private $st_ativo = null;
    

    /**
     * Get the value of Id Contrato Finalidade
     *
     * @return mixed
     */
    public function getIdContratoFinalidade()
    {
        return $this->id_contrato_finalidade;
    }

    /**
     * Set the value of Id Contrato Finalidade
     *
     * @param mixed id_contrato_finalidade
     *
     * @return self
     */
    public function setIdContratoFinalidade($id_contrato_finalidade)
    {
        $this->id_contrato_finalidade = $id_contrato_finalidade;

        return $this;
    }

    /**
     * Get the value of Nm Contrato Finalidade
     *
     * @return mixed
     */
    public function getNmContratoFinalidade()
    {
        return $this->nm_contrato_finalidade;
    }

    /**
     * Set the value of Nm Contrato Finalidade
     *
     * @param mixed nm_contrato_finalidade
     *
     * @return self
     */
    public function setNmContratoFinalidade($nm_contrato_finalidade)
    {
        $this->nm_contrato_finalidade = $nm_contrato_finalidade;

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
