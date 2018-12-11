<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/DaoFinOrdem.class.php";

class FinOrdemAdministracaoModel {

    private $id_ordem_administracao = null;
    private $id_ordem = null;
    private $id_protocolo = null;
    private $id_solicitante = null;
    private $id_lotacao_solicitante = null;
    private $dt_solicitacao = null;
    private $id_autorizado = null;
    private $id_lotacao_autorizado = null;
    private $dt_autorizacao = null;
    private $tp_administracao = null;

    public function getIdOrdemAdministracao() {
        return $this->id_ordem_administracao;
    }

    public function setIdOrdemAdministracao($id_ordem_administracao) {
        $this->id_ordem_administracao = $id_ordem_administracao;

        return $this;
    }

    public function getIdOrdem() {
        return $this->id_ordem;
    }

    public function setIdOrdem($id_ordem) {
        $this->id_ordem = $id_ordem;

        return $this;
    }

    public function getIdProtocolo() {
        return $this->id_protocolo;
    }

    public function setIdProtocolo($id_protocolo) {
        $this->id_protocolo = $id_protocolo;

        return $this;
    }

    public function getIdSolicitante() {
        return $this->id_solicitante;
    }

    public function setIdSolicitante($id_solicitante) {
        $this->id_solicitante = $id_solicitante;

        return $this;
    }

    public function getIdLotacaoSolicitante() {
        return $this->id_lotacao_solicitante;
    }

    public function setIdLotacaoSolicitante($id_lotacao_solicitante) {
        $this->id_lotacao_solicitante = $id_lotacao_solicitante;

        return $this;
    }

    public function getDtSolicitacao() {
        return $this->dt_solicitacao;
    }

    public function setDtSolicitacao($dt_solicitacao) {
        $this->dt_solicitacao = $dt_solicitacao;

        return $this;
    }

    public function getIdAutorizado() {
        return $this->id_autorizado;
    }

    public function setIdAutorizado($id_autorizado) {
        $this->id_autorizado = $id_autorizado;

        return $this;
    }

    public function getIdLotacaoAutorizado() {
        return $this->id_lotacao_autorizado;
    }

    public function setIdLotacaoAutorizado($id_lotacao_autorizado) {
        $this->id_lotacao_autorizado = $id_lotacao_autorizado;

        return $this;
    }

    public function getDtAutorizacao() {
        return $this->dt_autorizacao;
    }

    public function setDtAutorizacao($dt_autorizacao) {
        $this->dt_autorizacao = $dt_autorizacao;

        return $this;
    }

    public function getTpAdministracao() {
        return $this->tp_administracao;
    }

    public function setTpAdministracao($tp_administracao) {
        $this->tp_administracao = $tp_administracao;

        return $this;
    }

    public function reativacaoOrdem() {
        try {
            $daoFinOrdemAdministracao = new DaoFinOrdemAdministracao();
            $daoFinOrdemAdministracao->setIdOrdem($this->id_ordem);
            $daoFinOrdemAdministracao->setIdProtocolo($this->id_protocolo);
            $daoFinOrdemAdministracao->setIdSolicitante($this->id_solicitante);
            $daoFinOrdemAdministracao->setIdLotacaoSolicitante($this->id_lotacao_solicitante);
            $daoFinOrdemAdministracao->setTpAdministracao(1);
            $daoFinOrdemAdministracao->reativarOrdem($pdo);
            if ($daoFinOrdemAdministracao->Sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
