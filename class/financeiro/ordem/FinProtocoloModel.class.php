<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinProtocolo.class.php";

class FinProtocoloModel {

    private $id_protocolo = null;
    private $nm_representante = null;
    private $nr_rg_cpf = null;
    private $nm_email_representante = null;
    private $dh_recebimento_sistema = null;
    private $dh_recimento = null;
    private $ds_protocolo = null;
    private $id_ordem = null;
    private $qd_entrega = null;
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
    public function getQdEntrega() {
        return $this->qd_entrega;
    }

    /**
     * @param mixed $qd_entrega
     *
     * @return self
     */
    public function setQdEntrega($qd_entrega) {
        $this->qd_entrega = $qd_entrega;

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

    public function inforLoadProtocolo() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $daoFinProtocolo = new DaoFinProtocolo();
            $daoFinProtocolo->setIdOrdem($this->id_ordem);
            $daoFinProtocolo->retornaInforLoadProtocolo($pdo);
            if ($daoFinProtocolo->sucesso()) {
                return $daoFinProtocolo->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function salvaProtocolo() {
        try {
            if (empty($this->nm_representante) || empty($this->nm_representante) || empty($this->nr_rg_cpf) || empty($this->qd_entrega)) {
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
            $daoFinProtocolo->setDhRecebimentoSistema(Metodos::ConverteDataING($this->dh_recebimento_sistema));
            $daoFinProtocolo->setNmEmailRepresentante($this->nm_email_representante);
            $daoFinProtocolo->setDsProtocolo($this->ds_protocolo);
            $daoFinProtocolo->setQdEntrega($this->qd_entrega);
            $daoFinProtocolo->setIdOrdem($this->id_ordem);
            $daoFinProtocolo->setIdPessoa($this->id_pessoa);
            $daoFinProtocolo->salvaProcotolo($pdo);

            if (!$daoFinProtocolo->sucesso()) {
                $erro = true;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinProtocolo->getMsgRetorno());
            }
            //retorna prazo de entrega
            $daoFinProtocolo->retornaPrazoDeentrega($pdo);
            if (!$daoFinProtocolo->sucesso()) {
                $erro = true;
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $daoFinProtocolo->getMsgRetorno());
            }

            $prazo = $daoFinProtocolo->getMsgRetorno();
            //instanciando a clase para cadastra a confirmacao da entrega 
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $finEntregaConfirmacaoModel->setIdOrdem($this->id_ordem);
            $finEntregaConfirmacaoModel->setNrQtdEntrega(((int) $this->qd_entrega));

            for ($i = 1; $i <= ((int) $this->qd_entrega); $i++) {
                //codigo abaixo e para descobri as data da entrega
                $data = date('d/m/Y', strtotime('+' . (($prazo["nr_prazo_ordem"] * $i) - 1) . 'days', strtotime(Metodos::ConverteDataING($this->dh_recebimento_sistema))));
                $data = Metodos::ConverteDataING($data);

                $finEntregaConfirmacaoModel->setNrEntregaConfirmacao($i);
                $finEntregaConfirmacaoModel->setDtEntrega($data);

                $finEntregaConfirmacaoModel->salvaInsertEntregaProtocolo($pdo);

                if (!$finEntregaConfirmacaoModel->sucesso()) {
                    $erro = true;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $finEntregaConfirmacaoModel->getMsgRetorno());
                }
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

}
