<?php

class SesContratoRecadastramento{

    private $id_contrato_recadastramento = null;
    private $id_contrato = null;
    private $id_pessoa = null;
    private $dh_contrato_recadastramento = null;
    private $is_recadastramento = null;
    private $aa_recadastramento = null;
    private $is_ativo = null;

        
    /**
     * Get the value of Id Contrato Recadastramento
     *
     * @return mixed
     */
    public function getIdContratoRecadastramento()
    {
        return $this->id_contrato_recadastramento;
    }

    /**
     * Set the value of Id Contrato Recadastramento
     *
     * @param mixed id_contrato_recadastramento
     *
     * @return self
     */
    public function setIdContratoRecadastramento($id_contrato_recadastramento)
    {
        $this->id_contrato_recadastramento = $id_contrato_recadastramento;

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
     * Get the value of Id Pessoa
     *
     * @return mixed
     */
    public function getIdPessoa()
    {
        return $this->id_pessoa;
    }

    /**
     * Set the value of Id Pessoa
     *
     * @param mixed id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * Get the value of Dh Contrato Recadastramento
     *
     * @return mixed
     */
    public function getDhContratoRecadastramento()
    {
        return $this->dh_contrato_recadastramento;
    }

    /**
     * Set the value of Dh Contrato Recadastramento
     *
     * @param mixed dh_contrato_recadastramento
     *
     * @return self
     */
    public function setDhContratoRecadastramento($dh_contrato_recadastramento)
    {
        $this->dh_contrato_recadastramento = $dh_contrato_recadastramento;

        return $this;
    }

    /**
     * Get the value of Is Recadastramento
     *
     * @return mixed
     */
    public function getIsRecadastramento()
    {
        return $this->is_recadastramento;
    }

    /**
     * Set the value of Is Recadastramento
     *
     * @param mixed is_recadastramento
     *
     * @return self
     */
    public function setIsRecadastramento($is_recadastramento)
    {
        $this->is_recadastramento = $is_recadastramento;

        return $this;
    }

    /**
     * Get the value of Aa Recadastramento
     *
     * @return mixed
     */
    public function getAaRecadastramento()
    {
        return $this->aa_recadastramento;
    }

    /**
     * Set the value of Aa Recadastramento
     *
     * @param mixed aa_recadastramento
     *
     * @return self
     */
    public function setAaRecadastramento($aa_recadastramento)
    {
        $this->aa_recadastramento = $aa_recadastramento;

        return $this;
    }

    /**
     * Get the value of Is Ativo
     *
     * @return mixed
     */
    public function getIsAtivo()
    {
        return $this->is_ativo;
    }

    /**
     * Set the value of Is Ativo
     *
     * @param mixed is_ativo
     *
     * @return self
     */
    public function setIsAtivo($is_ativo)
    {
        $this->is_ativo = $is_ativo;

        return $this;
    }

}
