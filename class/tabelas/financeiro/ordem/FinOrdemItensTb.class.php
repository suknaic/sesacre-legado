<?php

class FinOrdemItensTb {

    private $id_ordem_itens = null;
    private $id_ordem = null;
    private $id_pre_ordem = null;
    private $id_fornecedor = null;
    private $qd_itens_pre = null;
    private $vl_itens_pre = null;

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

}
