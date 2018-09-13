<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/gdof/DaoFinEntregaDocumento.class.php";

class FinEntregaDocumento {

    private $id_entrega_documento = null;
    private $id_documento_fiscal = null;
    private $id_entrega_confirmacao = null;
    private $vl_entrega_documento = null;
    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * @return mixed
     */
    public function getIdEntregaDocumento() {
        return $this->id_entrega_documento;
    }

    /**
     * @param mixed $id_entrega_documento
     *
     * @return self
     */
    public function setIdEntregaDocumento($id_entrega_documento) {
        $this->id_entrega_documento = $id_entrega_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    /**
     * @param mixed $id_documento_fiscal
     *
     * @return self
     */
    public function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;

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
    public function getVlEntregaDocumento() {
        return $this->vl_entrega_documento;
    }

    /**
     * @param mixed $vl_entrega_documento
     *
     * @return self
     */
    public function setVlEntregaDocumento($vl_entrega_documento) {
        $this->vl_entrega_documento = $vl_entrega_documento;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSucesso() {
        return $this->sucesso;
    }

    /**
     * @param mixed $sucesso
     *
     * @return self
     */
    public function setSucesso($sucesso) {
        $this->sucesso = $sucesso;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * @param mixed $msgRetorno
     *
     * @return self
     */
    public function setMsgRetorno($msgRetorno) {
        $this->msgRetorno = $msgRetorno;

        return $this;
    }

    public function cadastrarEntregaDocumento(PDO $pdo) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinEntregaDocumento = new DaoFinEntregaDocumento();
        $daoFinEntregaDocumento->setIdDocumentoFiscal($this->id_documento_fiscal);
        $daoFinEntregaDocumento->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
        $daoFinEntregaDocumento->setVlEntregaDocumento(Metodos::ConverteValorIng($this->vl_entrega_documento));
        $daoFinEntregaDocumento->insertEntregaDocumento($pdo);
        //log do pedido de necessidade
        $daoFinEntregaDocumento->setIdEntregaDocumento($pdo->lastInsertId('fin_entrega_documento_id_entrega_documento_seq'));

        if (!Log::SalvaLogI('fin_entrega_documento', $daoFinEntregaDocumento->getIdEntregaConfirmacao(), $pdo)) {
            return false;
        }

        if (!$daoFinEntregaDocumento->sucesso()) {
            return false;
        }

        return true;
    }

    public function removerEntregaDocumento(PDO $pdo = null) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $daoFinEntregaDocumento = new DaoFinEntregaDocumento();
            $daoFinEntregaDocumento->setIdEntregaDocumento($this->id_entrega_documento);

            if (!Log::SalvaLogD('fin_entrega_documento', $daoFinEntregaDocumento->getIdEntregaDocumento(), $pdo)) {
                $this->sucesso = false;
                $this->msgRetorno = "Erro no Log para remover Entrega Documento";
                return true;
            }

            $daoFinEntregaDocumento->remove($pdo);
            if (!$daoFinEntregaDocumento->sucesso()) {
                $this->sucesso = false;
                $this->msgRetorno = $daoFinEntregaDocumento->getMsgRetorno();
                return true;
            }

            $this->sucesso = true;
            $this->msgRetorno = "Removido com Sucesso";
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTodosDocumentoFiscal(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdDocumentoFiscal($this->id_documento_fiscal);
            $dao->retornaPorDocumentoFiscal($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retorna(PDO $pdo = null) {
        try {
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdEntregaDocumento($this->id_entrega_documento);
            $dao->retorna($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaSaldoEntregas(PDO $pdo = null) {
        try {
            
            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }
            
            $dao = new DaoFinEntregaDocumento();
            $dao->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $dao->retornaSaldoEntregas($pdo);
            $this->sucesso = $dao->sucesso();
            $this->msgRetorno = $dao->getMsgRetorno();
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
