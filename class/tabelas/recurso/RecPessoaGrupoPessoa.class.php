<?php

class RecPessoaGrupoPessoa{
    
    private $id_pessoa_grupo_pessoa = null;
    private $id_pessoa = null;
    private $id_grupo_pessoa = null;

    
    /**
     * Get the value of Id Pessoa Grupo Pessoa
     *
     * @return mixed
     */
    public function getIdPessoaGrupoPessoa()
    {
        return $this->id_pessoa_grupo_pessoa;
    }

    /**
     * Set the value of Id Pessoa Grupo Pessoa
     *
     * @param mixed id_pessoa_grupo_pessoa
     *
     * @return self
     */
    public function setIdPessoaGrupoPessoa($id_pessoa_grupo_pessoa)
    {
        $this->id_pessoa_grupo_pessoa = $id_pessoa_grupo_pessoa;

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
     * Get the value of Id Grupo Pessoa
     *
     * @return mixed
     */
    public function getIdGrupoPessoa()
    {
        return $this->id_grupo_pessoa;
    }

    /**
     * Set the value of Id Grupo Pessoa
     *
     * @param mixed id_grupo_pessoa
     *
     * @return self
     */
    public function setIdGrupoPessoa($id_grupo_pessoa)
    {
        $this->id_grupo_pessoa = $id_grupo_pessoa;

        return $this;
    }

}
