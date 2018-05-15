<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinProtocolo.class.php";

class FinProtocoloTb {

    private $id_protocolo = null;
    private $nm_representante = null;
    private $nr_rg_cpf = null;
    private $nm_email_representante = null;
    private $dh_recebimento_sistema = null;
    private $dh_recimento = null;
    private $ds_protocolo = null;
    private $id_ordem = null;
    private $id_pessoa = null;
    private $st_ativo = null;

    /**
     * @return mixed
     */
    public function getIdProtocolo() {
        return $this->id_protocolo;
    }

    /**
     * @param mixed $id_protocolo
     *
     * @return self
     */
    public function setIdProtocolo($id_protocolo) {
        $this->id_protocolo = $id_protocolo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmRepresentante() {
        return $this->nm_representante;
    }

    /**
     * @param mixed $nm_representante
     *
     * @return self
     */
    public function setNmRepresentante($nm_representante) {
        $this->nm_representante = $nm_representante;

        return $this;
    }

    public function getNrRgCpf() {
        return $this->nr_rg_cpf;
    }

    public function setNrRgCpf($nr_rg_cpf) {
        $this->nr_rg_cpf = $nr_rg_cpf;
        return $this;
    }

    public function getNmEmailRepresentante() {
        return $this->nm_email_representante;
    }

    public function setNmEmailRepresentante($nm_email_representante) {
        $this->nm_email_representante = $nm_email_representante;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhRecebimentoSistema() {
        return $this->dh_recebimento_sistema;
    }

    /**
     * @param mixed $dh_recebimento_sistema
     *
     * @return self
     */
    public function setDhRecebimentoSistema($dh_recebimento_sistema) {
        $this->dh_recebimento_sistema = $dh_recebimento_sistema;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhRecimento() {
        return $this->dh_recimento;
    }

    /**
     * @param mixed $dh_recimento
     *
     * @return self
     */
    public function setDhRecimento($dh_recimento) {
        $this->dh_recimento = $dh_recimento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsProtocolo() {
        return $this->ds_protocolo;
    }

    /**
     * @param mixed $ds_protocolo
     *
     * @return self
     */
    public function setDsProtocolo($ds_protocolo) {
        $this->ds_protocolo = $ds_protocolo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdOrdem() {
        return $this->id_ordem;
    }

    /**
     * @param mixed $id_ordem
     *
     * @return self
     */
    public function setIdOrdem($id_ordem) {
        $this->id_ordem = $id_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    /**
     * @param mixed $id_pessoa
     *
     * @return self
     */
    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStAtivo() {
        return $this->st_ativo;
    }

    /**
     * @param mixed $st_ativo
     *
     * @return self
     */
    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;

        return $this;
    }

}
