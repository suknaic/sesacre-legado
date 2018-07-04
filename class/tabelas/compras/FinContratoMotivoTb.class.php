<?php

class FinContratoMotivoTb{

    private $id_contrato_motivo = null;
    private $nm_contrato_motivo = null;
    private $st_ativo = null;
    

    /**
     * Get the value of Id Contrato Motivo
     *
     * @return mixed
     */
    public function getIdContratoMotivo()
    {
        return $this->id_contrato_motivo;
    }

    /**
     * Set the value of Id Contrato Motivo
     *
     * @param mixed id_contrato_motivo
     *
     * @return self
     */
    public function setIdContratoMotivo($id_contrato_motivo)
    {
        $this->id_contrato_motivo = $id_contrato_motivo;

        return $this;
    }

    /**
     * Get the value of Nm Contrato Motivo
     *
     * @return mixed
     */
    public function getNmContratoMotivo()
    {
        return $this->nm_contrato_motivo;
    }

    /**
     * Set the value of Nm Contrato Motivo
     *
     * @param mixed nm_contrato_motivo
     *
     * @return self
     */
    public function setNmContratoMotivo($nm_contrato_motivo)
    {
        $this->nm_contrato_motivo = $nm_contrato_motivo;

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
