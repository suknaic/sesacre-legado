<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinProtocolo.class.php";

class FinProtocoloModel {

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
    private $dt_entrega = null;
    private $dt_confirmacao = null;
    private $st_protocolo = null;
    private $sucesso = null;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdProtFocolo() {
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

    /**
     * @return mixed
     */
    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * @param mixed $sucesso
     *
     * @return self
     */

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function inforLoadProtocolo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdOrdem($this->id_ordem);
            $daoFinProtocolo->retornaInforLoadProtocolo($pdo);
            if ($daoFinProtocolo->sucesso()) {
                return $daoFinProtocolo->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function salvaProtocolo() {
        try {
            if (empty($this->nm_representante) || empty($this->nm_representante) || empty($this->nr_rg_cpf)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $erro = false;
            $prazo = 0;
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setNmRepresentante($this->nm_representante);
            $daoFinProtocolo->setNrRgCpf($this->nr_rg_cpf);
            $daoFinProtocolo->setNmEmailRepresentante($this->nm_email_representante);
            $daoFinProtocolo->setQtEntrega(1);
            $daoFinProtocolo->setDhRecebimentoSistema(Metodos::ConverteDataING($this->dh_recebimento_sistema));
            $daoFinProtocolo->setDsProtocolo($this->ds_protocolo);
            $daoFinProtocolo->setIdOrdem($this->id_ordem);
            $daoFinProtocolo->setIdPessoa($this->id_pessoa);

            //retorna prazo de entrega
            $daoFinProtocolo->retornaPrazoDeentrega($pdo);
            if (!$daoFinProtocolo->sucesso()) {
                $erro = true;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinProtocolo->getMsgRetorno());
            }
            $prazo = $daoFinProtocolo->getMsgRetorno();
            $data = date('d/m/Y', strtotime('+' . $prazo["nr_prazo_ordem"] . 'days', strtotime(Metodos::ConverteDataING($this->dh_recebimento_sistema))));
            $data = Metodos::ConverteDataING($data);
            $daoFinProtocolo->setDtEntrega($data);

            $daoFinProtocolo->salvaProcotolo($pdo);
            //pegando id do protocolo
            $this->id_protocolo = ($pdo->lastInsertId('fin_protocolo_id_protocolo_seq'));

            if (!$daoFinProtocolo->sucesso()) {
                $erro = true;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinProtocolo->getMsgRetorno());
            }

            $daoFinProtocolo->updateStatusOrdem($pdo);

            if (!$daoFinProtocolo->sucesso()) {
                $erro = true;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinProtocolo->getMsgRetorno());
            }

            if ($erro == false) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinProtocolo->getMsgRetorno());
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaEntregaConfirmacao() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdOrdem($this->id_ordem);
            $daoFinProtocolo->retornaEntregaConfirmacao($pdo);
            if ($daoFinProtocolo->sucesso()) {
                return $daoFinProtocolo->getMsgRetorno();
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return $exc->getMessage();
        }
    }

    public function retornaIdProtocoloPorOrdem() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdOrdem($this->id_ordem);
            $daoFinProtocolo->retornaProtocoloPorOrdem($pdo);
            if ($daoFinProtocolo->sucesso()) {
                return $daoFinProtocolo->getMsgRetorno();
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return $exc->getMessage();
        }
    }

    public function atualizaSituacaoProtocolo(PDO $pdo) {
        try {
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdProtocolo($this->id_protocolo);
            $daoFinProtocolo->setStProtocolo($this->st_protocolo);
            $daoFinProtocolo->updateSituacaoProtocolo($pdo);
            if ($daoFinProtocolo->sucesso()) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return $exc->getMessage();
        }
    }

    public function atualizaEntregueDia(PDO $pdo) {
        try {
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdProtocolo($this->id_protocolo);
            $daoFinProtocolo->retornaEntregueDiaProtocolo($pdo);

            if (!empty($daoFinProtocolo->getMsgRetorno()["dt_confirmacao"])) {

                if (strtotime($daoFinProtocolo->getMsgRetorno()["dt_confirmacao"]) < strtotime($this->dt_confirmacao)) {
                    $daoFinProtocolo->setDtConfirmacao($this->dt_confirmacao);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", "A data informada não pode ser menor que a data da última entrega.");
                    return false;
                }
            } else {
                $daoFinProtocolo->setDtConfirmacao($this->dt_confirmacao);
            }
            $daoFinProtocolo->updateDtConfirmacao($pdo);

            if (!$daoFinProtocolo->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", "Erro na atualização da data da entrega.");
                return false;
            } else {
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }

    public function verificarStatusEntregaParcial(PDO $pdo) {
        try {
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdProtocolo($this->id_protocolo);
            $daoFinProtocolo->verificaEntregaParcial($pdo);
            return $daoFinProtocolo->sucesso();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = Metodos::retornoAjax("Erro", "alert", $exc->getMessage());
        }
    }

}
