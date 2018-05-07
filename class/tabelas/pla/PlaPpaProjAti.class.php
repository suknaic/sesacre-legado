<?php

class PlaPpaProjAti{

    private $id_ppa_proj_ati = null;
    private $nm_ppa_proj_ati = null;
    private $id_ppa_prog = null;
    private $tp_ppa_proj_ati = null;
    private $cd_ppa_proj_ati = null;
    private $st_ativo = null;

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
     * Get the value of Nm Ppa Proj Ati
     *
     * @return mixed
     */
    public function getNmPpaProjAti()
    {
        return $this->nm_ppa_proj_ati;
    }

    /**
     * Set the value of Nm Ppa Proj Ati
     *
     * @param mixed nm_ppa_proj_ati
     *
     * @return self
     */
    public function setNmPpaProjAti($nm_ppa_proj_ati)
    {
        $this->nm_ppa_proj_ati = $nm_ppa_proj_ati;

        return $this;
    }

    /**
     * Get the value of Id Ppa Prog
     *
     * @return mixed
     */
    public function getIdPpaProg()
    {
        return $this->id_ppa_prog;
    }

    /**
     * Set the value of Id Ppa Prog
     *
     * @param mixed id_ppa_prog
     *
     * @return self
     */
    public function setIdPpaProg($id_ppa_prog)
    {
        $this->id_ppa_prog = $id_ppa_prog;

        return $this;
    }

    /**
     * Get the value of Tp Ppa Proj Ati
     *
     * @return mixed
     */
    public function getTpPpaProjAti()
    {
        return $this->tp_ppa_proj_ati;
    }

    /**
     * Set the value of Tp Ppa Proj Ati
     *
     * @param mixed tp_ppa_proj_ati
     *
     * @return self
     */
    public function setTpPpaProjAti($tp_ppa_proj_ati)
    {
        $this->tp_ppa_proj_ati = $tp_ppa_proj_ati;

        return $this;
    }
    
    public function getCdPpaProjAti()
    {
        return $this->cd_ppa_proj_ati;
    }

    public function setCdPpaProjAti($cd_ppa_proj_ati)
    {
        $this->cd_ppa_proj_ati = $cd_ppa_proj_ati;

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
