<?php

class FinContratoInstrumentoTb{

    private $id_contrato_instrumento = null;
    private $nm_contrato_instrumento = null;
    private $st_ativo = null;
    

    /**
     * Get the value of Id Contrato Instrumento
     *
     * @return mixed
     */
    public function getIdContratoInstrumento()
    {
        return $this->id_contrato_instrumento;
    }

    /**
     * Set the value of Id Contrato Instrumento
     *
     * @param mixed id_contrato_instrumento
     *
     * @return self
     */
    public function setIdContratoInstrumento($id_contrato_instrumento)
    {
        $this->id_contrato_instrumento = $id_contrato_instrumento;

        return $this;
    }

    /**
     * Get the value of Nm Contrato Instrumento
     *
     * @return mixed
     */
    public function getNmContratoInstrumento()
    {
        return $this->nm_contrato_instrumento;
    }

    /**
     * Set the value of Nm Contrato Instrumento
     *
     * @param mixed nm_contrato_instrumento
     *
     * @return self
     */
    public function setNmContratoInstrumento($nm_contrato_instrumento)
    {
        $this->nm_contrato_instrumento = $nm_contrato_instrumento;

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
