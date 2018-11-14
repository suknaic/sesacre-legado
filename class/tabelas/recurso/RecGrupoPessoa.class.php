<?php

class RecGrupoPessoa{
    private $id_grupo_pessoa = null;
    private $nm_grupo_pessoa = null;
    private $st_ativo = null;

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

    /**
     * Get the value of Nm Grupo Pessoa
     *
     * @return mixed
     */
    public function getNmGrupoPessoa()
    {
        return $this->nm_grupo_pessoa;
    }

    /**
     * Set the value of Nm Grupo Pessoa
     *
     * @param mixed nm_grupo_pessoa
     *
     * @return self
     */
    public function setNmGrupoPessoa($nm_grupo_pessoa)
    {
        $this->nm_grupo_pessoa = $nm_grupo_pessoa;

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
