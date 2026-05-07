<?php

class PlaCentralPessoa{

    private $id_central_pessoa = null;
    private $id_pessoa = null;
    private $id_lotacao = null;
                    

    /**
     * Get the value of Id Central Pessoa
     *
     * @return mixed
     */
    public function getIdCentralPessoa()
    {
        return $this->id_central_pessoa;
    }

    /**
     * Set the value of Id Central Pessoa
     *
     * @param mixed id_central_pessoa
     *
     * @return self
     */
    public function setIdCentralPessoa($id_central_pessoa)
    {
        $this->id_central_pessoa = $id_central_pessoa;

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
     * Get the value of Id Lotacao
     *
     * @return mixed
     */
    public function getIdLotacao()
    {
        return $this->id_lotacao;
    }

    /**
     * Set the value of Id Lotacao
     *
     * @param mixed id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao)
    {
        $this->id_lotacao = $id_lotacao;

        return $this;
    }

}
