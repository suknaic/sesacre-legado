<?php

class PlaPasValidacao{

    private $id_pas_validacao = null;
    private $id_pas = null;
    private $id_pessoa = null;
    private $dh_pas_validacao = null;
    private $ds_pas_validacao = null;
    private $st_pas_validacao = null;

    
    /**
     * Get the value of Id Pas Validacao
     *
     * @return mixed
     */
    public function getIdPasValidacao()
    {
        return $this->id_pas_validacao;
    }

    /**
     * Set the value of Id Pas Validacao
     *
     * @param mixed id_pas_validacao
     *
     * @return self
     */
    public function setIdPasValidacao($id_pas_validacao)
    {
        $this->id_pas_validacao = $id_pas_validacao;

        return $this;
    }

    /**
     * Get the value of Id Pas
     *
     * @return mixed
     */
    public function getIdPas()
    {
        return $this->id_pas;
    }

    /**
     * Set the value of Id Pas
     *
     * @param mixed id_pas
     *
     * @return self
     */
    public function setIdPas($id_pas)
    {
        $this->id_pas = $id_pas;

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
     * Get the value of Ds Pas Validacao
     *
     * @return mixed
     */
    public function getDsPasValidacao()
    {
        return $this->ds_pas_validacao;
    }

    /**
     * Set the value of Ds Pas Validacao
     *
     * @param mixed ds_pas_validacao
     *
     * @return self
     */
    public function setDsPasValidacao($ds_pas_validacao)
    {
        $this->ds_pas_validacao = $ds_pas_validacao;

        return $this;
    }

    /**
     * Get the value of Dh Pas Validacao
     *
     * @return mixed
     */
    public function getDhPasValidacao()
    {
        return $this->dh_pas_validacao;
    }

    /**
     * Set the value of Dh Pas Validacao
     *
     * @param mixed dh_pas_validacao
     *
     * @return self
     */
    public function setDhPasValidacao($dh_pas_validacao)
    {
        $this->dh_pas_validacao = $dh_pas_validacao;

        return $this;
    }

    /**
     * Get the value of St Pas Validacao
     *
     * @return mixed
     */
    public function getStPasValidacao()
    {
        return $this->st_pas_validacao;
    }

    /**
     * Set the value of St Pas Validacao
     *
     * @param mixed st_pas_validacao
     *
     * @return self
     */
    public function setStPasValidacao($st_pas_validacao)
    {
        $this->st_pas_validacao = $st_pas_validacao;

        return $this;
    }

}
