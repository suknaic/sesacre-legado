<?php

class RecGrupoPessoaGrupoRecurso{
    
    private $id_grupo_pessoa_grupo_recurso = null;
    private $id_grupo_pessoa = null;
    private $id_grupo_recurso = null;
    
    /**
     * Get the value of Id Grupo Pessoa Grupo Recurso
     *
     * @return mixed
     */
    public function getIdGrupoPessoaGrupoRecurso()
    {
        return $this->id_grupo_pessoa_grupo_recurso;
    }

    /**
     * Set the value of Id Grupo Pessoa Grupo Recurso
     *
     * @param mixed id_grupo_pessoa_grupo_recurso
     *
     * @return self
     */
    public function setIdGrupoPessoaGrupoRecurso($id_grupo_pessoa_grupo_recurso)
    {
        $this->id_grupo_pessoa_grupo_recurso = $id_grupo_pessoa_grupo_recurso;

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

    /**
     * Get the value of Id Grupo Recurso
     *
     * @return mixed
     */
    public function getIdGrupoRecurso()
    {
        return $this->id_grupo_recurso;
    }

    /**
     * Set the value of Id Grupo Recurso
     *
     * @param mixed id_grupo_recurso
     *
     * @return self
     */
    public function setIdGrupoRecurso($id_grupo_recurso)
    {
        $this->id_grupo_recurso = $id_grupo_recurso;

        return $this;
    }   

}
