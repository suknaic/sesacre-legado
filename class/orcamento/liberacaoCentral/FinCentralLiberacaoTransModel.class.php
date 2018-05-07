<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/orcamento/liberacaoCentral/DaoFinCentralLiberacaoTrans.php";

class FinCentralLiberacaoTransModel {

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

    public function salvaLiberacaoTrans(PDO $pdo) {
        if (empty($this->id_central_liberacao) || empty($this->id_qdd_valor) || empty($this->vl_central_liberacao_trans)) {
            return false;
        }
        $daoFinCentralLiberacaoTrans = new DaoFinCentralLiberacaoTrans();
        $daoFinCentralLiberacaoTrans->setIdCentralLiberacao($this->id_central_liberacao);
        $daoFinCentralLiberacaoTrans->setIdQddValor($this->id_qdd_valor);
        $daoFinCentralLiberacaoTrans->setTpCentralLiberacaoTrans(1);
        $daoFinCentralLiberacaoTrans->setVlCentralLiberacaoTrans($this->vl_central_liberacao_trans);
        $daoFinCentralLiberacaoTrans->salvaFinLiberacaoTrans($pdo);
        $this->id_central_liberacao_trans = $pdo->lastInsertId('fin_central_liberacao_trans_id_central_liberacao_trans_seq');
        //log da tabela de central liberacao trans
        if (!Log::SalvaLogI('fin_central_liberacao_trans',  $this->id_central_liberacao_trans, $pdo)) {
            return false;
        }
        
        if ($daoFinCentralLiberacaoTrans->Sucesso()) {
            return true;
        } else {
            return $daoFinCentralLiberacaoTrans->getMsgRetorno();
        }
    }

}
