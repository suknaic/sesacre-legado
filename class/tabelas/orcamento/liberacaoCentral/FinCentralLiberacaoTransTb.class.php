<?php

class FinCentralLiberacaoTransTb {

    private $id_central_liberacao_trans = null;
    private $id_central_liberacao = null;
    private $id_qdd_valor = null;
    private $vl_central_liberacao_trans = null;
    private $tp_central_liberacao_trans = null;

    /**
     * @return mixed
     */
    public function getIdCentralLiberacaoTrans() {
        return $this->id_central_liberacao_trans;
    }

    /**
     * @param mixed $id_central_liberacao_trans
     *
     * @return self
     */
    public function setIdCentralLiberacaoTrans($id_central_liberacao_trans) {
        $this->id_central_liberacao_trans = $id_central_liberacao_trans;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdCentralLiberacao() {
        return $this->id_central_liberacao;
    }

    /**
     * @param mixed $id_central_liberacao
     *
     * @return self
     */
    public function setIdCentralLiberacao($id_central_liberacao) {
        $this->id_central_liberacao = $id_central_liberacao;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdQddValor() {
        return $this->id_qdd_valor;
    }

    /**
     * @param mixed $id_qdd_valor
     *
     * @return self
     */
    public function setIdQddValor($id_qdd_valor) {
        $this->id_qdd_valor = $id_qdd_valor;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVlCentralLiberacaoTrans() {
        return $this->vl_central_liberacao_trans;
    }

    /**
     * @param mixed $vl_central_liberacao_trans
     *
     * @return self
     */
    public function setVlCentralLiberacaoTrans($vl_central_liberacao_trans) {
        $this->vl_central_liberacao_trans = $vl_central_liberacao_trans;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpCentralLiberacaoTrans() {
        return $this->tp_central_liberacao_trans;
    }

    /**
     * @param mixed $tp_central_liberacao_trans
     *
     * @return self
     */
    public function setTpCentralLiberacaoTrans($tp_central_liberacao_trans) {
        $this->tp_central_liberacao_trans = $tp_central_liberacao_trans;

        return $this;
    }

}
