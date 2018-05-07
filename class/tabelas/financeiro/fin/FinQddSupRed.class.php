<?php

class FinQddSupRed{

    private $id_qdd_sup_red = null;
    private $id_qdd = null;
    private $id_pessoa = null;
    private $dh_qdd_sup_red = null;
    private $ds_qdd_sup_red = null;
    private $tp_qdd_sup_red = null;
    private $st_qdd_sup_red = null;
    private $id_pessoa_st = null;
    
    function getStQddSupRed() {
        return $this->st_qdd_sup_red;
    }

    function getIdPessoaSt() {
        return $this->id_pessoa_st;
    }

    function setStQddSupRed($st_qdd_sup_red) {
        $this->st_qdd_sup_red = $st_qdd_sup_red;
        return $this;
    }

    function setIdPessoaSt($id_pessoa_st) {
        $this->id_pessoa_st = $id_pessoa_st;
        return $this;
    }
    

    /**
     * Get the value of Id Qdd Sup Red
     *
     * @return mixed
     */
    public function getIdQddSupRed()
    {
        return $this->id_qdd_sup_red;
    }

    /**
     * Set the value of Id Qdd Sup Red
     *
     * @param mixed id_qdd_sup_red
     *
     * @return self
     */
    public function setIdQddSupRed($id_qdd_sup_red)
    {
        $this->id_qdd_sup_red = $id_qdd_sup_red;

        return $this;
    }

    /**
     * Get the value of Id Qdd
     *
     * @return mixed
     */
    public function getIdQdd()
    {
        return $this->id_qdd;
    }

    /**
     * Set the value of Id Qdd
     *
     * @param mixed id_qdd
     *
     * @return self
     */
    public function setIdQdd($id_qdd)
    {
        $this->id_qdd = $id_qdd;

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
     * Get the value of Dh Qdd Sup Red
     *
     * @return mixed
     */
    public function getDhQddSupRed()
    {
        return $this->dh_qdd_sup_red;
    }

    /**
     * Set the value of Dh Qdd Sup Red
     *
     * @param mixed dh_qdd_sup_red
     *
     * @return self
     */
    public function setDhQddSupRed($dh_qdd_sup_red)
    {
        $this->dh_qdd_sup_red = $dh_qdd_sup_red;

        return $this;
    }

    /**
     * Get the value of Ds Qdd Sup Red
     *
     * @return mixed
     */
    public function getDsQddSupRed()
    {
        return $this->ds_qdd_sup_red;
    }

    /**
     * Set the value of Ds Qdd Sup Red
     *
     * @param mixed ds_qdd_sup_red
     *
     * @return self
     */
    public function setDsQddSupRed($ds_qdd_sup_red)
    {
        $this->ds_qdd_sup_red = $ds_qdd_sup_red;

        return $this;
    }

    /**
     * Get the value of Tp Qdd Sup Red
     *
     * @return mixed
     */
    public function getTpQddSupRed()
    {
        return $this->tp_qdd_sup_red;
    }

    /**
     * Set the value of Tp Qdd Sup Red
     *
     * @param mixed tp_qdd_sup_red
     *
     * @return self
     */
    public function setTpQddSupRed($tp_qdd_sup_red)
    {
        $this->tp_qdd_sup_red = $tp_qdd_sup_red;

        return $this;
    }

}
