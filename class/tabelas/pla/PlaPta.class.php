<?php

class PlaPta{

    private $id_pta = null;
    private $id_pas = null;
    private $nm_pta = null;
    private $dt_inicio = null;
    private $dt_fim = null;    
    private $st_ativo = null;


    /**
     * Get the value of Id Pta
     *
     * @return mixed
     */
    public function getIdPta()
    {
        return $this->id_pta;
    }

    /**
     * Set the value of Id Pta
     *
     * @param mixed id_pta
     *
     * @return self
     */
    public function setIdPta($id_pta)
    {
        $this->id_pta = $id_pta;

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
     * Get the value of Nm Pta
     *
     * @return mixed
     */
    public function getNmPta()
    {
        return $this->nm_pta;
    }

    /**
     * Set the value of Nm Pta
     *
     * @param mixed nm_pta
     *
     * @return self
     */
    public function setNmPta($nm_pta)
    {
        $this->nm_pta = $nm_pta;

        return $this;
    }

    /**
     * Get the value of Dt Inicio
     *
     * @return mixed
     */
    public function getDtInicio()
    {
        return $this->dt_inicio;
    }

    /**
     * Set the value of Dt Inicio
     *
     * @param mixed dt_inicio
     *
     * @return self
     */
    public function setDtInicio($dt_inicio)
    {
        $this->dt_inicio = $dt_inicio;

        return $this;
    }

    /**
     * Get the value of Dt Fim
     *
     * @return mixed
     */
    public function getDtFim()
    {
        return $this->dt_fim;
    }

    /**
     * Set the value of Dt Fim
     *
     * @param mixed dt_fim
     *
     * @return self
     */
    public function setDtFim($dt_fim)
    {
        $this->dt_fim = $dt_fim;

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
