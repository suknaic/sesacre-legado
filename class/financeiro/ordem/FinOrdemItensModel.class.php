<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/DaoFinOrdenItens.class.php";

class FinOrdemItensModel {

    private $id_ordem_itens = null;
    private $id_ordem = null;
    private $id_pre_ordem = null;
    private $id_fornecedor = null;
    private $qd_itens_pre = null;
    private $vl_itens_pre = null;
    private $sucesso = null;
    private $msgRetorno = null;
    private $id_pedido = null;
    private $tp_item = null;
    private $fl_valor_variavel = null;
    
    function getFlValorVariavel() {
        return $this->fl_valor_variavel;
    }

    function setFlValorVariavel($fl_valor_variavel) {
        $this->fl_valor_variavel = $fl_valor_variavel;
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
    public function getIdPreOrdem() {
        return $this->id_pre_ordem;
    }

    /**
     * @param mixed $id_pre_ordem
     *
     * @return self
     */
    public function setIdPreOrdem($id_pre_ordem) {
        $this->id_pre_ordem = $id_pre_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdFornecedor() {
        return $this->id_fornecedor;
    }

    /**
     * @param mixed $id_fornecedor
     *
     * @return self
     */
    public function setIdFornecedor($id_fornecedor) {
        $this->id_fornecedor = $id_fornecedor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQdItensPre() {
        return $this->qd_itens_pre;
    }

    /**
     * @param mixed $qd_itens_pre
     *
     * @return self
     */
    public function setQdItensPre($qd_itens_pre) {
        $this->qd_itens_pre = $qd_itens_pre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlItensPre() {
        return $this->vl_itens_pre;
    }

    /**
     * @param mixed $vl_itens_pre
     *
     * @return self
     */
    public function setVlItensPre($vl_itens_pre) {
        $this->vl_itens_pre = $vl_itens_pre;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPedido() {
        return $this->id_pedido;
    }

    /**
     * @param mixed $id_pedido
     *
     * @return self
     */
    public function setIdPedido($id_pedido) {
        $this->id_pedido = $id_pedido;

        return $this;
    }

    public function getTpItem() {
        return $this->tp_item;
    }

    /**
     * @param mixed $tp_ordem
     *
     * @return self
     */
    public function setTpItem($tp_item) {
        $this->tp_item = $tp_item;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadastrarItens(PDO $pdo = null) {
        //variaveis do sistema
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        $daoFinOrdenItens = new DaoFinOrdenItens();
        $daoFinOrdenItens->setIdOrdem($this->id_ordem);
        $daoFinOrdenItens->setIdPreOrdem($this->id_pre_ordem);
        $daoFinOrdenItens->setQdItensPre($this->qd_itens_pre);
        $daoFinOrdenItens->setVlItensPre($this->vl_itens_pre);
        $daoFinOrdenItens->cadastroFinOrdemItens($pdo);
        if ($daoFinOrdenItens->Sucesso()) {
            $this->sucesso = true;
        } else {
            $this->sucesso = false;
        }
    }

    public function retornaSaldoItemPreOrdem(PDO $pdo = null) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinOrdenItens = new DaoFinOrdenItens();
        $daoFinOrdenItens->setIdPreOrdem($this->id_pre_ordem);
        $daoFinOrdenItens->retornaSaldoItemPreOrdem($pdo, $this->id_pedido);

        if ($daoFinOrdenItens->Sucesso()) {
            if (($this->tp_item == "C" || $this->tp_item == "P") && $this->fl_valor_variavel == "0") {
                if (round($daoFinOrdenItens->getMsgRetorno()["saldoordem"], 4) >= round($this->qd_itens_pre, 4)) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else if ($this->tp_item == "S" || $this->fl_valor_variavel == "1") {
                if (round($daoFinOrdenItens->getMsgRetorno()["saldoordem"], 4) >= round(($this->qd_itens_pre * $this->vl_itens_pre), 4)) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
            }
        }
    }

    public function retornaArraySaldoOrdemItens(PDO $pdo) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }

        if (empty($this->id_ordem)) {
            $this->sucesso = false;
        }
        
        $daoFinOrdenItens = new DaoFinOrdenItens();
        $daoFinOrdenItens->setIdOrdem($this->id_ordem);
        $daoFinOrdenItens->retornaSaldoItensOrdem($pdo);
        $this->msgRetorno = $daoFinOrdenItens->getMsgRetorno();
        $this->sucesso = true;

        if (!$daoFinOrdenItens->Sucesso()) {
            $this->sucesso = false;
        }
    }

}
