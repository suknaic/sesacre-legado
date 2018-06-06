<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinEntregaConfirmacao.class.php";

class FinEntregaConfirmacaoModel {

    private $id_entrega_confirmacao = null;
    private $id_ordem = null;
    private $id_protocolo = null;
    private $nr_entrega_confirmacao = null;
    private $dt_entrega = null;
    private $dt_confirmacao = null;
    private $dh_cadastramento = null;
    private $nr_qtd_entrega = null;
    private $st_entrega_confirmacao = null;
    private $sit_entrega = null;
    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdEntregaConfirmacao() {
        return $this->id_entrega_confirmacao;
    }

    /**
     * @param mixed $id_entrega_confirmacao
     *
     * @return self
     */
    public function setIdEntregaConfirmacao($id_entrega_confirmacao) {
        $this->id_entrega_confirmacao = $id_entrega_confirmacao;

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
    public function getNrEntregaConfirmacao() {
        return $this->nr_entrega_confirmacao;
    }

    /**
     * @param mixed $nr_entrega_confirmacao
     *
     * @return self
     */
    public function setNrEntregaConfirmacao($nr_entrega_confirmacao) {
        $this->nr_entrega_confirmacao = $nr_entrega_confirmacao;

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
    public function getDhCadastramento() {
        return $this->dh_cadastramento;
    }

    /**
     * @param mixed $dh_cadastramento
     *
     * @return self
     */
    public function setDhCadastramento($dh_cadastramento) {
        $this->dh_cadastramento = $dh_cadastramento;

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
    public function getStEntregaConfirmacao() {
        return $this->st_entrega_confirmacao;
    }

    /**
     * @param mixed $st_entrega_confirmacao
     *
     * @return self
     */
    public function setStEntregaConfirmacao($st_entrega_confirmacao) {
        $this->st_entrega_confirmacao = $st_entrega_confirmacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitEntrega() {
        return $this->sit_entrega;
    }

    /**
     * @param mixed $sit_entrega
     *
     * @return self
     */
    public function setSitEntrega($sit_entrega) {
        $this->sit_entrega = $sit_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function salvaInsertEntregaProtocolo(PDO $pdo) {
        try {
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdOrdem($this->id_ordem);
            $daoFinEntregaConfirmacao->setIdProtocolo($this->id_protocolo);
            $daoFinEntregaConfirmacao->setNrEntregaConfirmacao($this->nr_entrega_confirmacao);
            $daoFinEntregaConfirmacao->setDtEntrega($this->dt_entrega);
            $daoFinEntregaConfirmacao->setNrQtdEntrega($this->nr_qtd_entrega);
            $daoFinEntregaConfirmacao->salvaEntregaConfirmacao($pdo);
            if ($daoFinEntregaConfirmacao->sucesso()) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEntregaConfirmacao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaItensCadEntrega() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdProtocolo($this->id_protocolo);
            $daoFinEntregaConfirmacao->retornaInforParaEntrega($pdo);
            if ($daoFinEntregaConfirmacao->sucesso()) {
                return $daoFinEntregaConfirmacao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function atualizaDataConfirmacao(PDO $pdo) {
        try {
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();
            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->setDtConfirmacao($this->dt_confirmacao);
            //chama a funçao para lista os dados antes do update
            $daoFinEntregaConfirmacao->retornaDados($pdo);
            $busca = [];
            if ($daoFinEntregaConfirmacao->sucesso()) {
                $busca = $daoFinEntregaConfirmacao->getMsgRetorno();
                //ser tudo de certo chamo a funçao de updatae da data de 
                $daoFinEntregaConfirmacao->updateDataConfirmacao($pdo);
            }
            if (!Log::SalvaLogU("fin_entrega_confirmacao", $this->id_entrega_confirmacao, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            if ($daoFinEntregaConfirmacao->sucesso()) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEntregaConfirmacao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function atualizaSituacao(PDO $pdo) {
        try {
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();

            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->setSitEntrega($this->sit_entrega);
            //chama a funçao para lista os dados antes do update
            $daoFinEntregaConfirmacao->retornaDados($pdo);
            $busca = [];
            if ($daoFinEntregaConfirmacao->sucesso()) {
                $busca = $daoFinEntregaConfirmacao->getMsgRetorno();
                //ser tudo de certo chamo a funçao de updatae da situacao
                $daoFinEntregaConfirmacao->atualizaSituacao($pdo);
            }

            if (!Log::SalvaLogU("fin_entrega_confirmacao", $this->id_entrega_confirmacao, $busca, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }


            if ($daoFinEntregaConfirmacao->sucesso()) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEntregaConfirmacao->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function verificaSerAEntregaTotal($pdo) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaConfirmacao = new DaoFinEntregaConfirmacao();

            $daoFinEntregaConfirmacao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaConfirmacao->verificaSerAEntregaTotal($pdo);
            return $daoFinEntregaConfirmacao->sucesso();
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
