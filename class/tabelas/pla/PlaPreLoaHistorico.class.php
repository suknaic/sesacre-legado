<?php

class PlaPreLoaHistorico{

    private $id_pre_loa_historico = null;
    private $id_pre_loa = null;
    private $id_pessoa = null;
    private $ds_pre_loa_historico = null;
    private $dh_pre_loa_historico = null;
    private $st_pre_loa = null;


    /**
     * Get the value of Id Pre Loa Historico
     *
     * @return mixed
     */
    public function getIdPreLoaHistorico()
    {
        return $this->id_pre_loa_historico;
    }

    /**
     * Set the value of Id Pre Loa Historico
     *
     * @param mixed id_pre_loa_historico
     *
     * @return self
     */
    public function setIdPreLoaHistorico($id_pre_loa_historico)
    {
        $this->id_pre_loa_historico = $id_pre_loa_historico;

        return $this;
    }

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
     * Get the value of Ds Pre Loa Historico
     *
     * @return mixed
     */
    public function getDsPreLoaHistorico()
    {
        return $this->ds_pre_loa_historico;
    }

    /**
     * Set the value of Ds Pre Loa Historico
     *
     * @param mixed ds_pre_loa_historico
     *
     * @return self
     */
    public function setDsPreLoaHistorico($ds_pre_loa_historico)
    {
        $this->ds_pre_loa_historico = $ds_pre_loa_historico;

        return $this;
    }

    /**
     * Get the value of Dh Pre Loa Historico
     *
     * @return mixed
     */
    public function getDhPreLoaHistorico()
    {
        return $this->dh_pre_loa_historico;
    }

    /**
     * Set the value of Dh Pre Loa Historico
     *
     * @param mixed dh_pre_loa_historico
     *
     * @return self
     */
    public function setDhPreLoaHistorico($dh_pre_loa_historico)
    {
        $this->dh_pre_loa_historico = $dh_pre_loa_historico;

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

}
