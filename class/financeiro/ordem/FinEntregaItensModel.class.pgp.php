<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinEntregaItens.class.php";

class FinEntregaItensModel {

    private $id_entrega_itens = null;
    private $id_entrega_confirmacao = null;
    private $id_ordem_itens = null;
    private $fl_valor_variavel = null;
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
                //dao do fin entrega Itens
                $daoFinEntregaItens = new DaoFinEntregaItens();
                //instanciando classe de entregaConfirmacaoModel para usa metodos de atualiza Situaçao e a data de confirmaçao
                $finEntregaConfirmacaoModel = new FinEntregaConfirmacaoModel();
                $valorItens = 0;
                $erro = false;
                //verificar ser ja existem entrega parciais lançadas
                $daoFinEntregaItens->setIdEntregaConfirmacao($dados[0]->id_entrega);
                $daoFinEntregaItens->verificarEntregaParcial($pdo);

                if ($daoFinEntregaItens->sucesso() && $dados[0]->tipoEntrega == 2) {
                    return Metodos::retornoAjax("Erro", "alert", "Como já existe uma entrega parcial cadastrada não e possível lança uma total.");
                }

                $daoFinEntregaItens->retornaAgurdandoEntrega($pdo);
                if ($daoFinEntregaItens->sucesso()) {
                    $aguardandoentrega = $daoFinEntregaItens->getMsgRetorno();
                } else {
                    $erro = true;
                    return Metodos::retornoAjax("Erro", "console", $daoFinEntregaItens->getMsgRetorno());
                }

                foreach ($dados as $valor) {

                    if ($valor->tp == 'C' || $valor->tp == 'P') {

                        foreach ($aguardandoentrega as $v) {
                            if ($v["id_ordem_itens"] == $valor->itemId) {
                                $saldo = 0;
                                $saldo = round(Metodos::ConverteValorIng($v["aguardandoentrega"]), 4) - round(Metodos::ConverteValorIng($valor->qtd), 4);
                                if ($saldo == 0) {
                                    //atualiza a situacao da entrega
                                    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                                    $finEntregaConfirmacaoModel->setSitEntrega(2);
                                    $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
                                    //verificar ser a situacao foi atulizada corretamente 
                                    if (!$finEntregaConfirmacaoModel->sucesso()) {
                                        $erro = true;
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax("Erro", "console", $finEntregaConfirmacaoModel->getMsgRetorno());
                                    }
                                } else {
                                    //atualiza a situacao da entrega
                                    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                                    $finEntregaConfirmacaoModel->setSitEntrega(1);
                                    $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
                                    //verificar ser a situacao foi atulizada corretamente 
                                    if (!$finEntregaConfirmacaoModel->sucesso()) {
                                        $erro = true;
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax("Erro", "console", $finEntregaConfirmacaoModel->getMsgRetorno());
                                    }
                                }
                            }
                        }

                        //verificar
                        $daoFinEntregaItens->setIdOrdemItens($valor->itemId);
                        $daoFinEntregaItens->retornaValorItenOrdem($pdo);
                        $valorItens = $daoFinEntregaItens->getMsgRetorno();

                        $daoFinEntregaItens->setIdEntregaConfirmacao($valor->id_entrega);
                        $daoFinEntregaItens->setQtItensEntrega(Metodos::ConverteValorIng($valor->qtd));
                        $daoFinEntregaItens->setVlItensEntrega($valorItens["vl_itens_ordem"]);
                        $daoFinEntregaItens->setTpEntrega($valor->tipoEntrega);
                        $daoFinEntregaItens->setDhEntrega(Metodos::ConverteDataING($valor->data));
                        $daoFinEntregaItens->insertentregaItens($pdo);
                        //verificar ser deu tudo certo no cadastramento do entrega
                        if (!$daoFinEntregaItens->sucesso()) {
                            $erro = true;
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $daoFinEntregaItens->getMsgRetorno());
                        }
                    } else {
                        foreach ($aguardandoentrega as $v) {
                            if ($v["id_ordem_itens"] == $valor->itemId) {
                                $saldo = 0;
                                $saldo = round(Metodos::ConverteValorIng($v["aguardandoentrega"]), 4) -
                                        round((Metodos::ConverteValorIng($valor->qtd) * Metodos::ConverteValorIng($valor->vl)), 4);
                                if ($saldo == 0) {
                                    //atualiza a situacao da entrega
                                    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                                    $finEntregaConfirmacaoModel->setSitEntrega(2);
                                    $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
                                    //verificar ser a situacao foi atulizada corretamente 
                                    if (!$finEntregaConfirmacaoModel->sucesso()) {
                                        $erro = true;
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax("Erro", "console", $finEntregaConfirmacaoModel->getMsgRetorno());
                                    }
                                } else {
                                    //atualiza a situacao da entrega
                                    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                                    $finEntregaConfirmacaoModel->setSitEntrega(1);
                                    $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
                                    //verificar ser a situacao foi atulizada corretamente 
                                    if (!$finEntregaConfirmacaoModel->sucesso()) {
                                        $erro = true;
                                        $pdo->rollBack();
                                        return Metodos::retornoAjax("Erro", "console", $finEntregaConfirmacaoModel->getMsgRetorno());
                                    }
                                }
                            }
                        }
                        $daoFinEntregaItens->setIdOrdemItens($valor->itemId);
                        $daoFinEntregaItens->setIdEntregaConfirmacao($valor->id_entrega);
                        $daoFinEntregaItens->setQtItensEntrega(Metodos::ConverteValorIng($valor->qtd));
                        $daoFinEntregaItens->setVlItensEntrega(Metodos::ConverteValorIng($valor->vl));
                        $daoFinEntregaItens->setTpEntrega($valor->tipoEntrega);
                        $daoFinEntregaItens->setDhEntrega(Metodos::ConverteDataING($valor->data));
                        $daoFinEntregaItens->insertentregaItens($pdo);
                        //verificar ser deu tudo certo no cadastramento do entrega
                        if (!$daoFinEntregaItens->sucesso()) {
                            $erro = true;
                            $pdo->rollBack();
                            return Metodos::retornoAjax("Erro", "console", $daoFinEntregaItens->getMsgRetorno());
                        }
                    }
                }

                //atualiza a data de confirmacao da entrega   
                $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                $finEntregaConfirmacaoModel->setDtConfirmacao(Metodos::ConverteDataING($valor->data));
                $finEntregaConfirmacaoModel->atualizaDataConfirmacao($pdo);
                //verificar ser a data foi atualiza corretamente 
                if (!$finEntregaConfirmacaoModel->sucesso()) {
                    $erro = true;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $finEntregaConfirmacaoModel->getMsgRetorno());
                }




                if (!$erro) {
                    $pdo->commit();
                    return Metodos::retornoAjax("ok", "html", "deu certo");
                }
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
