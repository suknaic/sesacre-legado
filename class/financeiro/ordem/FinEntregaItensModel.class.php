<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinEntregaItens.class.php";

class FinEntregaItensModel {

    private $id_entrega_itens = null;
    private $id_entrega_confirmacao = null;
    private $id_ordem_itens = null;
    private $fl_valor_variavel = null;
    private $qt_itens_entrega = null;
    private $vl_itens_entrega = null;
    private $id_protocolo = null;

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
    public function getFlValorVariavel() {
        return $this->fl_valor_variavel;
    }

    /**
     * @param mixed $fl_valor_variavel
     *
     * @return self
     */
    public function setFlValorVariavel($fl_valor_variavel) {
        $this->fl_valor_variavel = $fl_valor_variavel;

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

    public function cadastraEntregaItens(PDO $pdo) {
        try {
            $daoFinEntregaItens = new DaoFinEntregaItens();
            if (!empty($this->id_entrega_confirmacao) || !empty($this->id_ordem_itens) || !empty($this->qt_itens_entrega) || !empty($this->vl_itens_entrega)) {
                $daoFinEntregaItens->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
                $daoFinEntregaItens->setIdOrdemItens($this->id_ordem_itens);
                $daoFinEntregaItens->setQtItensEntrega($this->qt_itens_entrega);
                $daoFinEntregaItens->setVlItensEntrega($this->vl_itens_entrega);
                $daoFinEntregaItens->insertentregaItens($pdo);
                return $daoFinEntregaItens->sucesso();
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function removeItemEntrega() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            $dataMaior = null;
            $dataItem = null;
            //instanciando objetos 
            $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
            $daoFinEntregaItens = new DaoFinEntregaItens();
            //fim
            //buscando a maior data no banco
            $finEntregaConfirmacaoModel->setIdProtocolo($this->id_protocolo);
            $finEntregaConfirmacaoModel->retornaUltimaDataEntrega($pdo);
            $dataMaior = $finEntregaConfirmacaoModel->getMsgRetorno()["max"];

            //buscando a data do item a ser removido no banco
            $daoFinEntregaItens->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaItens->retornaDataEntregaItens($pdo);

            if ($daoFinEntregaItens->sucesso()) {
                $dataItem = $daoFinEntregaItens->getMsgRetorno();
            } else {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
           
            if (strtotime($dataMaior) > strtotime($dataItem["dt_entrega"])) {
                return Metodos::retornoAjax("Erro", "alert", "Exclua o item que tem a maior data");
            }

            $daoFinEntregaItens->setIdEntregaItens($this->id_entrega_itens);
            $daoFinEntregaItens->removeItemEntrega($pdo);
            $erro = false;

            if (!$daoFinEntregaItens->sucesso()) {
                $erro = true;
            }

            //seto o id da entrega confirmacao para pode realiza a pesquisa
            $daoFinEntregaItens->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            //verificar ser e a ultima entrega ser for false e a ultima sendo assim
            //tenho que volta o status da confirmacao da entrega para 0
            $daoFinEntregaItens->verificarUltimaEntrega($pdo);
            
            if (!$daoFinEntregaItens->sucesso()) {
                $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
                $finEntregaConfirmacaoModel->excluirEntrega($pdo);
            }

            if (!$finEntregaConfirmacaoModel->sucesso()) {
                $erro = true;
            }

            if (!Log::SalvaLogD("fin_entrega_itens", $this->id_entrega_itens, $pdo)) {
                $erro = true;
            }

            $finEntregaConfirmacaoModel->retornaUltimaDataEntrega($pdo);
            $dataMaior = $finEntregaConfirmacaoModel->getMsgRetorno()["max"];
            //verificar ser deu tudo certo no retorno da maio data 
            if ($finEntregaConfirmacaoModel->sucesso()) {
                $finProtocoloModel = new FinProtocoloModel();
                $finProtocoloModel->setIdProtocolo($this->id_protocolo);
                $finProtocoloModel->setDtConfirmacao($dataMaior);
                $finProtocoloModel->atualizaEntregueDia($pdo, 1);
            }
            
            if (!$finProtocoloModel->Sucesso()) {
                $erro = true;
            }

            if (!$erro) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_CADASTRO_SUCESSO);
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }
        } catch (Exception $ex) {
            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function autoSetVlItemOrdem(PDO $pdo) {
        if (empty($pdo)) {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
        }
        $daoFinEntregaItens = new DaoFinEntregaItens();
        $daoFinEntregaItens->setIdOrdemItens($this->id_ordem_itens);
        $daoFinEntregaItens->retornaValorItenOrdem($pdo);
        if ($daoFinEntregaItens->sucesso()) {
            $this->vl_itens_entrega = $daoFinEntregaItens->getMsgRetorno()->vl_itens_ordem;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param type $arrayItensOrdem array com as quantidades e valores da ordem
     * @return type
     */
    public function verificarSaldoOrdemItens($saldoItens) {

        foreach ($saldoItens as $valor) {

            if ($valor["id_ordem_itens"] == $this->id_ordem_itens) {
                if (empty($this->vl_itens_entrega)) {

                    if ((round($valor["saldoitens"], 4) - round($this->qt_itens_entrega, 4)) < 0) {
                        return false;
                    }
                } else {
                    if ((round($valor["saldoitens"], 4) - round(($this->qt_itens_entrega * $this->vl_itens_entrega), 4)) < 0) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

}
