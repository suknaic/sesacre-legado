<?php

class PlaEixoPpaProjAti{

    private $id_eixo_ppa_proj_ati = null;
    private $id_eixo = null;
    private $id_ppa_proj_ati = null;

            
    /**
     * Get the value of Id Eixo Ppa Proj Ati
     *
     * @return mixed
     */
    public function getIdEixoPpaProjAti()
    {
        return $this->id_eixo_ppa_proj_ati;
    }

    /**
     * Set the value of Id Eixo Ppa Proj Ati
     *
     * @param mixed id_eixo_ppa_proj_ati
     *
     * @return self
     */
    public function setIdEixoPpaProjAti($id_eixo_ppa_proj_ati)
    {
        $this->id_eixo_ppa_proj_ati = $id_eixo_ppa_proj_ati;

        return $this;
    }

    /**
     * Get the value of Id Eixo
     *
     * @return mixed
     */
    public function getIdEixo()
    {
        return $this->id_eixo;
    }

    /**
     * Set the value of Id Eixo
     *
     * @param mixed id_eixo
     *
     * @return self
     */
    public function setIdEixo($id_eixo)
    {
        $this->id_eixo = $id_eixo;

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

}
