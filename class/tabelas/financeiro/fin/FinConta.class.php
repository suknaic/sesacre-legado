<?php

class FinConta{

    private $id_conta = null;
    private $id_conta_financeira = null;
    private $id_fonte_tipo = null;
    private $id_fonte = null;
    private $id_portaria_ds = null;
    private $id_convenio = null;

        
    /**
     * Get the value of Id Conta
     *
     * @return mixed
     */
    public function getIdConta()
    {
        return $this->id_conta;
    }

    /**
     * Set the value of Id Conta
     *
     * @param mixed id_conta
     *
     * @return self
     */
    public function setIdConta($id_conta)
    {
        $this->id_conta = $id_conta;

        return $this;
    }

    /**
     * Get the value of Id Conta Financeira
     *
     * @return mixed
     */
    public function getIdContaFinanceira()
    {
        return $this->id_conta_financeira;
    }

    /**
     * Set the value of Id Conta Financeira
     *
     * @param mixed id_conta_financeira
     *
     * @return self
     */
    public function setIdContaFinanceira($id_conta_financeira)
    {
        $this->id_conta_financeira = $id_conta_financeira;

        return $this;
    }

    /**
     * Get the value of Id Fonte Tipo
     *
     * @return mixed
     */
    public function getIdFonteTipo()
    {
        return $this->id_fonte_tipo;
    }

    /**
     * Set the value of Id Fonte Tipo
     *
     * @param mixed id_fonte_tipo
     *
     * @return self
     */
    public function setIdFonteTipo($id_fonte_tipo)
    {
        $this->id_fonte_tipo = $id_fonte_tipo;

        return $this;
    }

    /**
     * Get the value of Id Fonte
     *
     * @return mixed
     */
    public function getIdFonte()
    {
        return $this->id_fonte;
    }

    /**
     * Set the value of Id Fonte
     *
     * @param mixed id_fonte
     *
     * @return self
     */
    public function setIdFonte($id_fonte)
    {
        $this->id_fonte = $id_fonte;

        return $this;
    }

    /**
     * Get the value of Id Portaria Ds
     *
     * @return mixed
     */
    public function getIdPortariaDs()
    {
        return $this->id_portaria_ds;
    }

    /**
     * Set the value of Id Portaria Ds
     *
     * @param mixed id_portaria_ds
     *
     * @return self
     */
    public function setIdPortariaDs($id_portaria_ds)
    {
        $this->id_portaria_ds = $id_portaria_ds;

        return $this;
    }

    /**
     * Get the value of Id Convenio
     *
     * @return mixed
     */
    public function getIdConvenio()
    {
        return $this->id_convenio;
    }

    /**
     * Set the value of Id Convenio
     *
     * @param mixed id_convenio
     *
     * @return self
     */
    public function setIdConvenio($id_convenio)
    {
        $this->id_convenio = $id_convenio;

        return $this;
    }

}
