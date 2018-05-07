<?php

class FinOrdemTb {

    private $id_ordem = null;
    private $id_pedido = null;
    private $id_lotacao = null;
    private $id_pessoa = null;
    private $nr_ordem = null;
    private $dh_ordem = null;
    private $aa_ordem = null;
    private $nr_prazo_ordem = null;
    private $tp_ordem = null;
    private $sit_ordem = null;
    private $dt_ini_ordem = null;
    private $dt_fim_ordem = null;
    //atributos para pesquisa da ordem
    private $nr_Pedido = null;
    private $central = null;
    private $ano = null;

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

    /**
     * @return mixed
     */
    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    /**
     * @param mixed $id_lotacao
     *
     * @return self
     */
    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;

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
    public function getNrOrdem() {
        return $this->nr_ordem;
    }

    /**
     * @param mixed $nr_ordem
     *
     * @return self
     */
    public function setNrOrdem($nr_ordem) {
        $this->nr_ordem = $nr_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDhOrdem() {
        return $this->dh_ordem;
    }

    /**
     * @param mixed $dh_ordem
     *
     * @return self
     */
    public function setDhOrdem($dh_ordem) {
        $this->dh_ordem = $dh_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAaOrdem() {
        return $this->aa_ordem;
    }

    /**
     * @param mixed $aa_ordem
     *
     * @return self
     */
    public function setAaOrdem($aa_ordem) {
        $this->aa_ordem = $aa_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPrazoOrdem() {
        return $this->nr_prazo_ordem;
    }

    /**
     * @param mixed $nr_prazo_ordem
     *
     * @return self
     */
    public function setNrPrazoOrdem($nr_prazo_ordem) {
        $this->nr_prazo_ordem = $nr_prazo_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpOrdem() {
        return $this->tp_ordem;
    }

    /**
     * @param mixed $tp_ordem
     *
     * @return self
     */
    public function setTpOrdem($tp_ordem) {
        $this->tp_ordem = $tp_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitOrdem() {
        return $this->sit_ordem;
    }

    /**
     * @param mixed $sit_ordem
     *
     * @return self
     */
    public function setSitOrdem($sit_ordem) {
        $this->sit_ordem = $sit_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtIniOrdem() {
        return $this->dt_ini_ordem;
    }

    /**
     * @param mixed $dt_ini_ordem
     *
     * @return self
     */
    public function setDtIniOrdem($dt_ini_ordem) {
        $this->dt_ini_ordem = $dt_ini_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtFimOrdem() {
        return $this->dt_fim_ordem;
    }

    /**
     * @param mixed $dt_fim_ordem
     *
     * @return self
     */
    public function setDtFimOrdem($dt_fim_ordem) {
        $this->dt_fim_ordem = $dt_fim_ordem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrPedido() {
        return $this->nr_Pedido;
    }

    /**
     * @param mixed $nr_Pedido
     *
     * @return self
     */
    public function setNrPedido($nr_Pedido) {
        $this->nr_Pedido = $nr_Pedido;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCentral() {
        return $this->central;
    }

    /**
     * @param mixed $central
     *
     * @return self
     */
    public function setCentral($central) {
        $this->central = $central;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAno() {
        return $this->ano;
    }

    /**
     * @param mixed $ano
     *
     * @return self
     */
    public function setAno($ano) {
        $this->ano = $ano;

        return $this;
    }

}
