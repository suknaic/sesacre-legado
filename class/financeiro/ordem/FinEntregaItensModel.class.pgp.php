<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinEntregaItens.class.php";

class FinEntregaItensModel {

    private $id_entrega_itens = null;
    private $id_entrega_confirmacao = null;
    private $id_ordem_itens = null;
    private $qt_itens_entrega = null;
    private $vl_itens_entrega = null;
    private $tp_entrega = null;
    private $dh_entrega = null;

    /**
     * @return mixed
     */
    public function getIdEntregaItens() {
        return $this->id_entrega_itens;
    }

    /**
     * @param mixed $id_entrega_itens
     *
     * @return self
     */
    public function setIdEntregaItens($id_entrega_itens) {
        $this->id_entrega_itens = $id_entrega_itens;

        return $this;
    }

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
    public function getIdOrdemItens() {
        return $this->id_ordem_itens;
    }

    /**
     * @param mixed $id_ordem_itens
     *
     * @return self
     */
    public function setIdOrdemItens($id_ordem_itens) {
        $this->id_ordem_itens = $id_ordem_itens;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQtItensEntrega() {
        return $this->qt_itens_entrega;
    }

    /**
     * @param mixed $qt_itens_entrega
     *
     * @return self
     */
    public function setQtItensEntrega($qt_itens_entrega) {
        $this->qt_itens_entrega = $qt_itens_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlItensEntrega() {
        return $this->vl_itens_entrega;
    }

    /**
     * @param mixed $vl_itens_entrega
     *
     * @return self
     */
    public function setVlItensEntrega($vl_itens_entrega) {
        $this->vl_itens_entrega = $vl_itens_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpEntrega() {
        return $this->tp_entrega;
    }

    /**
     * @param mixed $tp_entrega
     *
     * @return self
     */
    public function setTpEntrega($tp_entrega) {
        $this->tp_entrega = $tp_entrega;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhEntrega() {
        return $this->dh_entrega;
    }

    /**
     * @param mixed $dh_entrega
     *
     * @return self
     */
    public function setDhEntrega($dh_entrega) {
        $this->dh_entrega = $dh_entrega;

        return $this;
    }

    public function cadastraEntregaItens(array $dados) {
        try {
            if (!empty($dados)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
                $pdo->beginTransaction();
                $daoFinEntregaItens = new DaoFinEntregaItens();
                $valorItens = 0;
                foreach ($dados as $valor) {
                    $daoFinEntregaItens->setIdOrdemItens($valor->itemId);
                    $daoFinEntregaItens->retornaValorItenOrdem($pdo);
                    $valorItens = $daoFinEntregaItens->getMsgRetorno();

                    if ($valor->tp == 'C' || $valor->tp == 'P') {
                        $daoFinEntregaItens->setIdEntregaConfirmacao($valor->id_entrega);
                        $daoFinEntregaItens->setQtItensEntrega(Metodos::ConverteValorIng($valor->qtd));
                        $daoFinEntregaItens->setVlItensEntrega($valorItens["vl_itens_ordem"]);
                        $daoFinEntregaItens->setTpEntrega($valor->tipoEntrega);
                        $daoFinEntregaItens->setDhEntrega(Metodos::ConverteDataING($valor->data));
                        $daoFinEntregaItens->insertentregaItens($pdo);
                        if ($daoFinEntregaItens->sucesso()) {
                            $pdo->commit();
                            return "deu certo";
                        } else {
                            $pdo->rollBack();
                            return $daoFinEntregaItens->getMsgRetorno();
                        }
                    } else {
                        $daoFinEntregaItens->setIdEntregaConfirmacao($valor->id_entrega);
                        $daoFinEntregaItens->setQtItensEntrega(Metodos::ConverteValorIng($valor->qtd));
                        $daoFinEntregaItens->setVlItensEntrega(Metodos::ConverteValorIng($valor->vl));
                        $daoFinEntregaItens->setTpEntrega($valor->tipoEntrega);
                        $daoFinEntregaItens->setDhEntrega(Metodos::ConverteDataING($valor->data));
                        $daoFinEntregaItens->insertentregaItens($pdo);
                        if ($daoFinEntregaItens->sucesso()) {
                            $pdo->commit();
                            return Metodos::retornoAjax("ok", "html", "deu certo");
                        } else {
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
//                            return $daoFinEntregaItens->getMsgRetorno();
                        }
                    }
                }
                return false;
            }
        } catch (Exception $ex) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "console", $ex->getMessage());
        }
    }

    public function t() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaItens = new DaoFinEntregaItens();
            $daoFinEntregaItens->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaItens->t($pdo);
            if ($daoFinEntregaItens->sucesso()) {

                return $daoFinEntregaItens->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
