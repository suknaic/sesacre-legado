<?php

class RecPessoaGrupoRecurso{
    
    private $id_pessoa_grupo_recurso = null;
    private $id_pessoa = null;
    private $id_grupo_recurso = null;

    /**
     * Get the value of Id Pessoa Grupo Recurso
     *
     * @return mixed
     */
    public function getIdPessoaGrupoRecurso()
    {
        return $this->id_pessoa_grupo_recurso;
    }

    /**
     * Set the value of Id Pessoa Grupo Recurso
     *
     * @param mixed id_pessoa_grupo_recurso
     *
     * @return self
     */
    public function setIdPessoaGrupoRecurso($id_pessoa_grupo_recurso)
    {
        $this->id_pessoa_grupo_recurso = $id_pessoa_grupo_recurso;

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
