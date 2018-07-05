<?php

class FinContratoAditivoTb{

    private $id_contrato_aditivo = null;
    private $id_contrato = null;
    private $id_contrato_motivo = null;
    private $id_contrato_finalidade = null;
    private $id_contrato_instrumento = null;
    private $id_contrato_base_calculo = null;
    private $id_contrato_unidade_calculo = null;
    private $id_contrato_aquisicao = null;
    private $ds_justificativa = null;
                                  

    /**
     * Get the value of Id Contrato Aditivo
     *
     * @return mixed
     */
    public function getIdContratoAditivo()
    {
        return $this->id_contrato_aditivo;
    }

    /**
     * Set the value of Id Contrato Aditivo
     *
     * @param mixed id_contrato_aditivo
     *
     * @return self
     */
    public function setIdContratoAditivo($id_contrato_aditivo)
    {
        $this->id_contrato_aditivo = $id_contrato_aditivo;

        return $this;
    }

    /**
     * Get the value of Id Contrato
     *
     * @return mixed
     */
    public function getIdContrato()
    {
        return $this->id_contrato;
    }

    /**
     * Set the value of Id Contrato
     *
     * @param mixed id_contrato
     *
     * @return self
     */
    public function setIdContrato($id_contrato)
    {
        $this->id_contrato = $id_contrato;

        return $this;
    }

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

    public function getDsJustificativa() {
        return $this->ds_justificativa;
    }

    public function setDsJustificativa($ds_justificativa) {
        $this->ds_justificativa = $ds_justificativa;
    }


    
}
