<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/DaoFinOrdemAdministracao.php";

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
    private $ds_ordem_administracao_anotacao = null;

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

    public function getDsOrdemAdministracaoAnotacao() {
        return $this->ds_ordem_administracao_anotacao;
    }

    public function setDsOrdemAdministracaoAnotacao($ds_ordem_administracao_anotacao) {
        $this->ds_ordem_administracao_anotacao = $ds_ordem_administracao_anotacao;

        return $this;
    }

    public function retornaSituacaoOrdemPorTipoAdministracao() {
        switch ($this->tp_administracao) {
            case '1':
                return 2; //2 que significa que a situacao da ordem vai ser Resquisitado
                break;

            case '2':
                return 4; //4 que significa que a situacao da ordem vai ser Finalizado por Supressão do Ordenado
                break;

            case '3':
                return 5; //5 que significa que a situacao da ordem vai ser Finalizado por Descumprimento da Contratada	
                break;

            default;
                return null;
                break;
        }
    }

    public function reativacaoOrdem() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoFinOrdemAdministracao = new DaoFinOrdemAdministracao();
            $daoFinOrdemAdministracao->setIdOrdem($this->id_ordem);
            $daoFinOrdemAdministracao->setIdProtocolo($this->id_protocolo);
            $daoFinOrdemAdministracao->setIdSolicitante($this->id_solicitante);
            $daoFinOrdemAdministracao->setIdLotacaoSolicitante($this->id_lotacao_solicitante);
            $daoFinOrdemAdministracao->setTpAdministracao(1);
            $daoFinOrdemAdministracao->reativarOrdem($pdo);

            $this->id_ordem_administracao = $pdo->lastInsertId('fin_ordem_administracao_id_ordem_administracao_seq');

            if (!$daoFinOrdemAdministracao->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao cadastrar a reativação.");
            }

            if (!empty($this->ds_ordem_administracao_anotacao)) {
                $finOrdemAdministracaoAnotacaoModel = new FinOrdemAdministracaoAnotacaoModel();
                $finOrdemAdministracaoAnotacaoModel->setIdOrdemAdministracao($this->id_ordem_administracao);
                $finOrdemAdministracaoAnotacaoModel->setDsOrdemAdministracaoAnotacao($this->ds_ordem_administracao_anotacao);
                $finOrdemAdministracaoAnotacaoModel->setIdPessoa($this->id_solicitante);

                $finOrdemAdministracaoAnotacaoModel->cadastrarAnotacao($pdo);

                if (!$finOrdemAdministracaoAnotacaoModel->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao cadastrar a anotação.");
                }
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function retornaDadosReativacaoOrdem() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinOrdemAdministracao = new DaoFinOrdemAdministracao();
            $daoFinOrdemAdministracao->setIdOrdemAdministracao($this->id_ordem_administracao);
            $daoFinOrdemAdministracao->retornaDadosReativacaoOrdem($pdo);
            if(!$daoFinOrdemAdministracao->Sucesso()){
                return false;
            }
            
            return $daoFinOrdemAdministracao->getMsgRetorno();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
