<?php

class RecRecurso{
    private $id_recurso = null;
    private $id_sistema = null;
    private $nm_recurso = null;
    private $lk_recurso = null;
    private $ds_recurso = null;
    private $st_ativo = null;        

    /**
     * Get the value of Id Recurso
     *
     * @return mixed
     */
    public function getIdRecurso()
    {
        return $this->id_recurso;
    }

    /**
     * Set the value of Id Recurso
     *
     * @param mixed id_recurso
     *
     * @return self
     */
    public function setIdRecurso($id_recurso)
    {
        $this->id_recurso = $id_recurso;

        return $this;
    }

    /**
     * Get the value of Id Sistema
     *
     * @return mixed
     */
    public function getIdSistema()
    {
        return $this->id_sistema;
    }

    /**
     * Set the value of Id Sistema
     *
     * @param mixed id_sistema
     *
     * @return self
     */
    public function setIdSistema($id_sistema)
    {
        $this->id_sistema = $id_sistema;

        return $this;
    }

    /**
     * Get the value of Nm Recurso
     *
     * @return mixed
     */
    public function getNmRecurso()
    {
        return $this->nm_recurso;
    }

    /**
     * Set the value of Nm Recurso
     *
     * @param mixed nm_recurso
     *
     * @return self
     */
    public function setNmRecurso($nm_recurso)
    {
        $this->nm_recurso = $nm_recurso;

        return $this;
    }

    /**
     * Get the value of Lk Recurso
     *
     * @return mixed
     */
    public function getLkRecurso()
    {
        return $this->lk_recurso;
    }

    /**
     * Set the value of Lk Recurso
     *
     * @param mixed lk_recurso
     *
     * @return self
     */
    public function setLkRecurso($lk_recurso)
    {
        $this->lk_recurso = $lk_recurso;

        return $this;
    }

    /**
     * Get the value of Ds Recurso
     *
     * @return mixed
     */
    public function getDsRecurso()
    {
        return $this->ds_recurso;
    }

    /**
     * Set the value of Ds Recurso
     *
     * @param mixed ds_recurso
     *
     * @return self
     */
    public function setDsRecurso($ds_recurso)
    {
        $this->ds_recurso = $ds_recurso;

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
