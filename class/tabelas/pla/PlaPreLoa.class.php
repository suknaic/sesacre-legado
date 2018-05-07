<?php

class PlaPreLoa{

    private $id_pre_loa = null;
    private $aa_pre_loa = null;
    private $st_pre_loa = null;
    private $st_ativo = null;


    /**
     * Get the value of Id Pre Loa
     *
     * @return mixed
     */
    public function getIdPreLoa()
    {
        return $this->id_pre_loa;
    }

    /**
     * Set the value of Id Pre Loa
     *
     * @param mixed id_pre_loa
     *
     * @return self
     */
    public function setIdPreLoa($id_pre_loa)
    {
        $this->id_pre_loa = $id_pre_loa;

        return $this;
    }

    /**
     * Get the value of Aa Pre Loa
     *
     * @return mixed
     */
    public function getAaPreLoa()
    {
        return $this->aa_pre_loa;
    }

    /**
     * Set the value of Aa Pre Loa
     *
     * @param mixed aa_pre_loa
     *
     * @return self
     */
    public function setAaPreLoa($aa_pre_loa)
    {
        $this->aa_pre_loa = $aa_pre_loa;

        return $this;
    }

    /**
     * Get the value of St Pre Loa
     *
     * @return mixed
     */
    public function getStPreLoa()
    {
        return $this->st_pre_loa;
    }

    /**
     * Set the value of St Pre Loa
     *
     * @param mixed st_pre_loa
     *
     * @return self
     */
    public function setStPreLoa($st_pre_loa)
    {
        $this->st_pre_loa = $st_pre_loa;

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
