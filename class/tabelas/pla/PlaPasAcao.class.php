<?php

class PlaPasAcao {

    private $id_pas_acao = null;
    private $id_pas = null;
    private $id_acao = null;
    private $id_ppa_proj_ati = null;
    private $ds_parceria = null;
    private $ds_meta_programacao = null;
    private $ds_indicador_programacao = null;
    private $st_ativo = null;

    
    /**
     * Get the value of Id Pas Acao
     *
     * @return mixed
     */
    public function getIdPasAcao()
    {
        return $this->id_pas_acao;
    }

    /**
     * Set the value of Id Pas Acao
     *
     * @param mixed id_pas_acao
     *
     * @return self
     */
    public function setIdPasAcao($id_pas_acao)
    {
        $this->id_pas_acao = $id_pas_acao;

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
     * Get the value of Id Acao
     *
     * @return mixed
     */
    public function getIdAcao()
    {
        return $this->id_acao;
    }

    /**
     * Set the value of Id Acao
     *
     * @param mixed id_acao
     *
     * @return self
     */
    public function setIdAcao($id_acao)
    {
        $this->id_acao = $id_acao;

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
     * Get the value of Ds Parceria
     *
     * @return mixed
     */
    public function getDsParceria()
    {
        return $this->ds_parceria;
    }

    /**
     * Set the value of Ds Parceria
     *
     * @param mixed ds_parceria
     *
     * @return self
     */
    public function setDsParceria($ds_parceria)
    {
        $this->ds_parceria = $ds_parceria;

        return $this;
    }

    /**
     * Get the value of Ds Meta Programacao
     *
     * @return mixed
     */
    public function getDsMetaProgramacao()
    {
        return $this->ds_meta_programacao;
    }

    /**
     * Set the value of Ds Meta Programacao
     *
     * @param mixed ds_meta_programacao
     *
     * @return self
     */
    public function setDsMetaProgramacao($ds_meta_programacao)
    {
        $this->ds_meta_programacao = $ds_meta_programacao;

        return $this;
    }

    /**
     * Get the value of Ds Indicador Programacao
     *
     * @return mixed
     */
    public function getDsIndicadorProgramacao()
    {
        return $this->ds_indicador_programacao;
    }

    /**
     * Set the value of Ds Indicador Programacao
     *
     * @param mixed ds_indicador_programacao
     *
     * @return self
     */
    public function setDsIndicadorProgramacao($ds_indicador_programacao)
    {
        $this->ds_indicador_programacao = $ds_indicador_programacao;

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
