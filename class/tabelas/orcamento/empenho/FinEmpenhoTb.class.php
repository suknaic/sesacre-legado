<?php

class FinEmpenhoTb {

    private $id_empenho = null;
    private $id_pedido = null;
    private $id_pessoa = null;
    private $id_tipo_empenho = null;
    private $nr_empenho = null;
    private $dt_empenho_sistema = null;
    private $dt_empenho_safira = null;
    private $vl_empenho = null;
    private $ds_empenho = null;
    private $sit_empenho = null;

    /**
     * @return mixed
     */
    public function getIdEmpenho() {
        return $this->id_empenho;
    }

    /**
     * @param mixed $id_empenho
     *
     * @return self
     */
    public function setIdEmpenho($id_empenho) {
        $this->id_empenho = $id_empenho;

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
    public function getIdTipoEmpenho() {
        return $this->id_tipo_empenho;
    }

    /**
     * @param mixed $id_tipo_empenho
     *
     * @return self
     */
    public function setIdTipoEmpenho($id_tipo_empenho) {
        $this->id_tipo_empenho = $id_tipo_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNrEmpenho() {
        return $this->nr_empenho;
    }

    /**
     * @param mixed $nr_empenho
     *
     * @return self
     */
    public function setNrEmpenho($nr_empenho) {
        $this->nr_empenho = $nr_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEmpenhoSistema() {
        return $this->dt_empenho_sistema;
    }

    /**
     * @param mixed $dt_empenho_sistema
     *
     * @return self
     */
    public function setDtEmpenhoSistema($dt_empenho_sistema) {
        $this->dt_empenho_sistema = $dt_empenho_sistema;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtEmpenhoSafira() {
        return $this->dt_empenho_safira;
    }

    /**
     * @param mixed $dt_empenho_safira
     *
     * @return self
     */
    public function setDtEmpenhoSafira($dt_empenho_safira) {
        $this->dt_empenho_safira = $dt_empenho_safira;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlEmpenho() {
        return $this->vl_empenho;
    }

    /**
     * @param mixed $vl_empenho
     *
     * @return self
     */
    public function setVlEmpenho($vl_empenho) {
        $this->vl_empenho = $vl_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDsEmpenho() {
        return $this->ds_empenho;
    }

    /**
     * @param mixed $ds_empenho
     *
     * @return self
     */
    public function setDsEmpenho($ds_empenho) {
        $this->ds_empenho = $ds_empenho;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSitEmpenho() {
        return $this->sit_empenho;
    }

    /**
     * @param mixed $sit_empenho
     *
     * @return self
     */
    public function setSitEmpenho($sit_empenho) {
        $this->sit_empenho = $sit_empenho;

        return $this;
    }

}
