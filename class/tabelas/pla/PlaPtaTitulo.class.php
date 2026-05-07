<?php

class PlaPtaTitulo{

    private $id_pta_titulo = null;
    private $id_pta = null;
    private $nm_pta_titulo = null;
    private $id_programa_trabalho = null;
    private $id_ppa_proj_ati = null;
    private $ds_objeto = null;
    private $ds_justificativa = null;
    private $st_ativo = null;


    /**
     * Get the value of Id Pta Titulo
     *
     * @return mixed
     */
    public function getIdPtaTitulo()
    {
        return $this->id_pta_titulo;
    }

    /**
     * Set the value of Id Pta Titulo
     *
     * @param mixed id_pta_titulo
     *
     * @return self
     */
    public function setIdPtaTitulo($id_pta_titulo)
    {
        $this->id_pta_titulo = $id_pta_titulo;

        return $this;
    }

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
     * Get the value of Nm Pta Titulo
     *
     * @return mixed
     */
    public function getNmPtaTitulo()
    {
        return $this->nm_pta_titulo;
    }

    /**
     * Set the value of Nm Pta Titulo
     *
     * @param mixed nm_pta_titulo
     *
     * @return self
     */
    public function setNmPtaTitulo($nm_pta_titulo)
    {
        $this->nm_pta_titulo = $nm_pta_titulo;

        return $this;
    }

    /**
     * Get the value of Id Programa Trabalho
     *
     * @return mixed
     */
    public function getIdProgramaTrabalho()
    {
        return $this->id_programa_trabalho;
    }

    /**
     * Set the value of Id Programa Trabalho
     *
     * @param mixed id_programa_trabalho
     *
     * @return self
     */
    public function setIdProgramaTrabalho($id_programa_trabalho)
    {
        $this->id_programa_trabalho = $id_programa_trabalho;

        return $this;
    }

    /**
     * Get the value of Id Ppa Proj Ati
     *
     * @return mixed
     */
    public function getIdPpaProjAti()
    {
        return $this->id_ppa_proj_ati;
    }

    /**
     * Set the value of Id Ppa Proj Ati
     *
     * @param mixed id_ppa_proj_ati
     *
     * @return self
     */
    public function setIdPpaProjAti($id_ppa_proj_ati)
    {
        $this->id_ppa_proj_ati = $id_ppa_proj_ati;

        return $this;
    }

    /**
     * Get the value of Ds Objeto
     *
     * @return mixed
     */
    public function getDsObjeto()
    {
        return $this->ds_objeto;
    }

    /**
     * Set the value of Ds Objeto
     *
     * @param mixed ds_objeto
     *
     * @return self
     */
    public function setDsObjeto($ds_objeto)
    {
        $this->ds_objeto = $ds_objeto;

        return $this;
    }

    /**
     * Get the value of Ds Justificativa
     *
     * @return mixed
     */
    public function getDsJustificativa()
    {
        return $this->ds_justificativa;
    }

    /**
     * Set the value of Ds Justificativa
     *
     * @param mixed ds_justificativa
     *
     * @return self
     */
    public function setDsJustificativa($ds_justificativa)
    {
        $this->ds_justificativa = $ds_justificativa;

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
