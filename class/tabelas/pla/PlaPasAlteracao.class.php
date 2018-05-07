<?php

class PlaPasAlteracao{

    private $id_pas_alteracao = null;
    private $id_pessoa = null;
    private $id_pas = null;
    private $ds_tela = null;
    private $dh_pas_alteracao = null;
    private $ds_pas_alteracao = null;
    private $tp_pas_alteracao = null;
    private $id_pta_titulo = null;
    private $id_pta = null;
    private $id_pta_item = null;
    
    function getIdPtaItem() {
        return $this->id_pta_item;
    }

    function setIdPtaItem($id_pta_item) {
        $this->id_pta_item = $id_pta_item;
        return $this;
    }

        
    function getIdPtaTitulo() {
        return $this->id_pta_titulo;
    }

    function getIdPta() {
        return $this->id_pta;
    }

    function setIdPtaTitulo($id_pta_titulo) {
        $this->id_pta_titulo = $id_pta_titulo;
        return $this;
    }

    function setIdPta($id_pta) {
        $this->id_pta = $id_pta;
        return $this;
    }

                

    /**
     * Get the value of Id Pas Alteracao
     *
     * @return mixed
     */
    public function getIdPasAlteracao()
    {
        return $this->id_pas_alteracao;
    }

    /**
     * Set the value of Id Pas Alteracao
     *
     * @param mixed id_pas_alteracao
     *
     * @return self
     */
    public function setIdPasAlteracao($id_pas_alteracao)
    {
        $this->id_pas_alteracao = $id_pas_alteracao;

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
     * Get the value of Ds Tela
     *
     * @return mixed
     */
    public function getDsTela()
    {
        return $this->ds_tela;
    }

    /**
     * Set the value of Ds Tela
     *
     * @param mixed ds_tela
     *
     * @return self
     */
    public function setDsTela($ds_tela)
    {
        $this->ds_tela = $ds_tela;

        return $this;
    }

    /**
     * Get the value of Dh Pas Alteracao
     *
     * @return mixed
     */
    public function getDhPasAlteracao()
    {
        return $this->dh_pas_alteracao;
    }

    /**
     * Set the value of Dh Pas Alteracao
     *
     * @param mixed dh_pas_alteracao
     *
     * @return self
     */
    public function setDhPasAlteracao($dh_pas_alteracao)
    {
        $this->dh_pas_alteracao = $dh_pas_alteracao;

        return $this;
    }

    /**
     * Get the value of Ds Pas Alteracao
     *
     * @return mixed
     */
    public function getDsPasAlteracao()
    {
        return $this->ds_pas_alteracao;
    }

    /**
     * Set the value of Ds Pas Alteracao
     *
     * @param mixed ds_pas_alteracao
     *
     * @return self
     */
    public function setDsPasAlteracao($ds_pas_alteracao)
    {
        $this->ds_pas_alteracao = $ds_pas_alteracao;

        return $this;
    }

    /**
     * Get the value of Tp Pas Alteracao
     *
     * @return mixed
     */
    public function getTpPasAlteracao()
    {
        return $this->tp_pas_alteracao;
    }

    /**
     * Set the value of Tp Pas Alteracao
     *
     * @param mixed tp_pas_alteracao
     *
     * @return self
     */
    public function setTpPasAlteracao($tp_pas_alteracao)
    {
        $this->tp_pas_alteracao = $tp_pas_alteracao;

        return $this;
    }

}
