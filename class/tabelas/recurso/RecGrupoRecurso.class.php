<?php

class RecGrupoRecurso{
    private $id_grupo_recurso = null;
    private $nm_grupo_recurso = null;
    private $st_ativo = null;



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

    /**
     * Get the value of Nm Grupo Recurso
     *
     * @return mixed
     */
    public function getNmGrupoRecurso()
    {
        return $this->nm_grupo_recurso;
    }

    /**
     * Set the value of Nm Grupo Recurso
     *
     * @param mixed nm_grupo_recurso
     *
     * @return self
     */
    public function setNmGrupoRecurso($nm_grupo_recurso)
    {
        $this->nm_grupo_recurso = $nm_grupo_recurso;

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
