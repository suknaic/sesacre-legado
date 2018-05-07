<?php

class SesLog{

    private $id_log = null;
    private $ds_tabela = null;
    private $id_tabela_pk = null;
    private $tp_log = null;
    private $id_pessoa = null;
    private $ds_ip = null;
    private $dh_log = null;
    private $ds_campos_atuais = null;
    private $ds_campos_antigos = null;

    /**
     * Get the value of Id Log
     *
     * @return mixed
     */
    public function getIdLog()
    {
        return $this->id_log;
    }

    /**
     * Set the value of Id Log
     *
     * @param mixed id_log
     *
     * @return self
     */
    public function setIdLog($id_log)
    {
        $this->id_log = $id_log;

        return $this;
    }

    /**
     * Get the value of Ds Tabela
     *
     * @return mixed
     */
    public function getDsTabela()
    {
        return $this->ds_tabela;
    }

    /**
     * Set the value of Ds Tabela
     *
     * @param mixed ds_tabela
     *
     * @return self
     */
    public function setDsTabela($ds_tabela)
    {
        $this->ds_tabela = $ds_tabela;

        return $this;
    }

    /**
     * Get the value of Id Tabela Pk
     *
     * @return mixed
     */
    public function getIdTabelaPk()
    {
        return $this->id_tabela_pk;
    }

    /**
     * Set the value of Id Tabela Pk
     *
     * @param mixed id_tabela_pk
     *
     * @return self
     */
    public function setIdTabelaPk($id_tabela_pk)
    {
        $this->id_tabela_pk = $id_tabela_pk;

        return $this;
    }

    /**
     * Get the value of Tp Log
     *
     * @return mixed
     */
    public function getTpLog()
    {
        return $this->tp_log;
    }

    /**
     * Set the value of Tp Log
     *
     * @param mixed tp_log
     *
     * @return self
     */
    public function setTpLog($tp_log)
    {
        $this->tp_log = $tp_log;

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
     * Get the value of Ds Ip
     *
     * @return mixed
     */
    public function getDsIp()
    {
        return $this->ds_ip;
    }

    /**
     * Set the value of Ds Ip
     *
     * @param mixed ds_ip
     *
     * @return self
     */
    public function setDsIp($ds_ip)
    {
        $this->ds_ip = $ds_ip;

        return $this;
    }

    /**
     * Get the value of Dh Log
     *
     * @return mixed
     */
    public function getDhLog()
    {
        return $this->dh_log;
    }

    /**
     * Set the value of Dh Log
     *
     * @param mixed dh_log
     *
     * @return self
     */
    public function setDhLog($dh_log)
    {
        $this->dh_log = $dh_log;

        return $this;
    }

    /**
     * Get the value of Ds Campos Atuais
     *
     * @return mixed
     */
    public function getDsCamposAtuais()
    {
        return $this->ds_campos_atuais;
    }

    /**
     * Set the value of Ds Campos Atuais
     *
     * @param mixed ds_campos_atuais
     *
     * @return self
     */
    public function setDsCamposAtuais($ds_campos_atuais)
    {
        $this->ds_campos_atuais = $ds_campos_atuais;

        return $this;
    }

    /**
     * Get the value of Ds Campos Antigos
     *
     * @return mixed
     */
    public function getDsCamposAntigos()
    {
        return $this->ds_campos_antigos;
    }

    /**
     * Set the value of Ds Campos Antigos
     *
     * @param mixed ds_campos_antigos
     *
     * @return self
     */
    public function setDsCamposAntigos($ds_campos_antigos)
    {
        $this->ds_campos_antigos = $ds_campos_antigos;

        return $this;
    }

}
