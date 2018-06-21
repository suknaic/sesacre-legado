<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinProtocolo.class.php";

class FinProtocoloTb {

    private $id_protocolo = null;
    private $nm_representante = null;
    private $nr_rg_cpf = null;
    private $nm_email_representante = null;
    private $qt_entrega = null;
    private $dh_recebimento_sistema = null;
    private $dh_recimento = null;
    private $ds_protocolo = null;
    private $id_ordem = null;
    private $id_pessoa = null;
    private $st_ativo = null;
    private $nr_entrega_protocolo = null;
    private $dt_entrega = null;
    private $dt_confirmacao = null;
    private $nr_qtd_entrega = null;
    private $st_protocolo = null;

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

    /**
     * @return mixed
     */
    public function getNrRgCpf() {
        return $this->nr_rg_cpf;
    }

    /**
     * @param mixed $nr_rg_cpf
     *
     * @return self
     */
    public function setNrRgCpf($nr_rg_cpf) {
        $this->nr_rg_cpf = $nr_rg_cpf;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNmEmailRepresentante() {
        return $this->nm_email_representante;
    }

    /**
     * @param mixed $nm_email_representante
     *
     * @return self
     */
    public function setNmEmailRepresentante($nm_email_representante) {
        $this->nm_email_representante = $nm_email_representante;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtEntrega() {
        return $this->qt_entrega;
    }

    /**
     * @param mixed $qt_entrega
     *
     * @return self
     */
    public function setQtEntrega($qt_entrega) {
        $this->qt_entrega = $qt_entrega;

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
    public function getIdPessoa() {
        return $this->id_pessoa;
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

    /**
     * @return mixed
     */
    public function getNrEntregaProtocolo() {
        return $this->nr_entrega_protocolo;
    }

    /**
     * @param mixed $nr_entrega_protocolo
     *
     * @return self
     */
    public function setNrEntregaProtocolo($nr_entrega_protocolo) {
        $this->nr_entrega_protocolo = $nr_entrega_protocolo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEntrega() {
        return $this->dt_entrega;
    }

    /**
     * @param mixed $dt_entrega
     *
     * @return self
     */
    public function setDtEntrega($dt_entrega) {
        $this->dt_entrega = $dt_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtConfirmacao() {
        return $this->dt_confirmacao;
    }

    /**
     * @param mixed $dt_confirmacao
     *
     * @return self
     */
    public function setDtConfirmacao($dt_confirmacao) {
        $this->dt_confirmacao = $dt_confirmacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrQtdEntrega() {
        return $this->nr_qtd_entrega;
    }

    /**
     * @param mixed $nr_qtd_entrega
     *
     * @return self
     */
    public function setNrQtdEntrega($nr_qtd_entrega) {
        $this->nr_qtd_entrega = $nr_qtd_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStProtocolo() {
        return $this->st_protocolo;
    }

    /**
     * @param mixed $st_protocolo
     *
     * @return self
     */
    public function setStProtocolo($st_protocolo) {
        $this->st_protocolo = $st_protocolo;

        return $this;
    }

}
