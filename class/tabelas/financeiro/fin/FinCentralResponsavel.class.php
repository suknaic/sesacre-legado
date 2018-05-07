<?php

class FinCentralResponsavel{

    private $id_central_responsavel = null;
    private $id_lotacao = null;
    private $id_pessoa = null;
                

    /**
     * Get the value of Id Central Responsavel
     *
     * @return mixed
     */
    public function getIdCentralResponsavel()
    {
        return $this->id_central_responsavel;
    }

    /**
     * Set the value of Id Central Responsavel
     *
     * @param mixed id_central_responsavel
     *
     * @return self
     */
    public function setIdCentralResponsavel($id_central_responsavel)
    {
        $this->id_central_responsavel = $id_central_responsavel;

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

}
