<?php

class FinPortaria{

    private $id_portaria = null;
    private $id_rede_tematica = null;
    private $nm_portaria = null;
    private $dt_portaria = null;
    private $st_portaria = null;
    private $vl_total = null;
                    

    /**
     * Get the value of Id Portaria
     *
     * @return mixed
     */
    public function getIdPortaria()
    {
        return $this->id_portaria;
    }

    /**
     * Set the value of Id Portaria
     *
     * @param mixed id_portaria
     *
     * @return self
     */
    public function setIdPortaria($id_portaria)
    {
        $this->id_portaria = $id_portaria;

        return $this;
    }

    /**
     * Get the value of Id Rede Tematica
     *
     * @return mixed
     */
    public function getIdRedeTematica()
    {
        return $this->id_rede_tematica;
    }

    /**
     * Set the value of Id Rede Tematica
     *
     * @param mixed id_rede_tematica
     *
     * @return self
     */
    public function setIdRedeTematica($id_rede_tematica)
    {
        $this->id_rede_tematica = $id_rede_tematica;

        return $this;
    }

    /**
     * Get the value of Nm Portaria
     *
     * @return mixed
     */
    public function getNmPortaria()
    {
        return $this->nm_portaria;
    }

    /**
     * Set the value of Nm Portaria
     *
     * @param mixed nm_portaria
     *
     * @return self
     */
    public function setNmPortaria($nm_portaria)
    {
        $this->nm_portaria = $nm_portaria;

        return $this;
    }

    /**
     * Get the value of Dt Portaria
     *
     * @return mixed
     */
    public function getDtPortaria()
    {
        return $this->dt_portaria;
    }

    /**
     * Set the value of Dt Portaria
     *
     * @param mixed dt_portaria
     *
     * @return self
     */
    public function setDtPortaria($dt_portaria)
    {
        $this->dt_portaria = $dt_portaria;

        return $this;
    }

    /**
     * Get the value of St Portaria
     *
     * @return mixed
     */
    public function getStPortaria()
    {
        return $this->st_portaria;
    }

    /**
     * Set the value of St Portaria
     *
     * @param mixed st_portaria
     *
     * @return self
     */
    public function setStPortaria($st_portaria)
    {
        $this->st_portaria = $st_portaria;

        return $this;
    }

    /**
     * Get the value of Vl Total
     *
     * @return mixed
     */
    public function getVlTotal()
    {
        return $this->vl_total;
    }

    /**
     * Set the value of Vl Total
     *
     * @param mixed vl_total
     *
     * @return self
     */
    public function setVlTotal($vl_total)
    {
        $this->vl_total = $vl_total;

        return $this;
    }

}
