<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/financeiro/ordem/entrega/DaoFinEntregaItens.class.php";

class FinEntregaItensModel {

    private $id_entrega_itens = null;
    private $id_entrega_confirmacao = null;
    private $id_ordem_itens = null;
    private $fl_valor_variavel = null;
    private $qt_itens_entrega = null;
    private $vl_itens_entrega = null;

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
                $contTotal = 0;
                $contParcial = 0;
                //verificar ser ja existem entrega parciais lançadas
                $daoFinEntregaItens->setIdEntregaConfirmacao($dados[0]->id_entrega);
                $daoFinEntregaItens->verificarEntregaParcial($pdo);

                if ($daoFinEntregaItens->sucesso() && $dados[0]->tipoEntrega == 2) {
                    return Metodos::retornoAjax("Erro", "alert", "Como já existe uma entrega parcial cadastrada não e possível lança uma total.");
                }
                //primeira verificaçao para situaçao
                $daoFinEntregaItens->retornaAgurdandoEntrega($pdo);
                if ($daoFinEntregaItens->sucesso()) {
                    $aguardandoentrega = $daoFinEntregaItens->getMsgRetorno();
                } else {
                    $erro = true;
                    return Metodos::retornoAjax("Erro", "console", $daoFinEntregaItens->getMsgRetorno());
                }

                foreach ($dados as $valor) {

                    if ($valor->tp == 'C' || $valor->tp == 'P' && $valor->fl_valor = '0') {

                        foreach ($aguardandoentrega as $v) {
                            if ($v["id_ordem_itens"] == $valor->itemId) {
                                $saldo = 0;
                                $saldo = round(Metodos::ConverteValorIng($v["aguardandoentrega"]) - Metodos::ConverteValorIng($valor->qtd), 4);
                                if ($saldo == 0) {
                                    $contTotal ++;
                                }

                                if ($saldo > 0) {
                                    $contParcial ++;
                                }

                                if ($saldo < 0) {
                                    return Metodos::retornoAjax("Erro", "alert", "Não existem saldo para entrega por favor verifique os itens.");
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
                    } else if ($valor->tp == 'C' || $valor->tp == 'P' && $valor->fl_valor = '1') {
                        foreach ($aguardandoentrega as $v) {
                            if ($v["id_ordem_itens"] == $valor->itemId) {
                                $saldo = 0;
                                $saldo = round(Metodos::ConverteValorIng($v["aguardandoentrega"]), 4) - round((Metodos::ConverteValorIng($valor->qtd) * Metodos::ConverteValorIng($valor->vl)), 4);
                                if ($saldo == 0) {
                                    $contTotal ++;
                                }

                                if ($saldo > 0) {
                                    $contParcial ++;
                                }

                                if ($saldo < 0) {
                                    return Metodos::retornoAjax("Erro", "alert", "Não existem saldo para entrega por favor verifique os itens.");
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
                    } else if ($valor->tp == 'S' && $valor->fl_valor = '1') {
                        foreach ($aguardandoentrega as $v) {
                            if ($v["id_ordem_itens"] == $valor->itemId) {
                                $saldo = 0;
                                $saldo = round(Metodos::ConverteValorIng($v["aguardandoentrega"]), 4) - round((Metodos::ConverteValorIng($valor->qtd) * Metodos::ConverteValorIng($valor->vl)), 4);
                                if ($saldo == 0) {
                                    $contTotal ++;
                                }

                                if ($saldo > 0) {
                                    $contParcial ++;
                                }

                                if ($saldo < 0) {
                                    return Metodos::retornoAjax("Erro", "alert", "Não existem saldo para entrega por favor verifique os itens.");
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
                $finEntregaConfirmacaoModel->retornaUltimaDataEntrega($pdo);
                $dataMaior = null;
                $dataMaior = $finEntregaConfirmacaoModel->getMsgRetorno()["max"];
                if ($finEntregaConfirmacaoModel->sucesso() && strtotime($dataMaior) > strtotime(Metodos::ConverteDataING($valor->data))) {
                    $finEntregaConfirmacaoModel->setDtConfirmacao($dataMaior);
                    $finEntregaConfirmacaoModel->atualizaDataConfirmacao($pdo);
                } else {
                    $finEntregaConfirmacaoModel->setDtConfirmacao(Metodos::ConverteDataING($valor->data));
                    $finEntregaConfirmacaoModel->atualizaDataConfirmacao($pdo);
                }

                //verificar ser a data foi atualiza corretamente 
                if (!$finEntregaConfirmacaoModel->sucesso()) {
                    $erro = true;
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "console", $finEntregaConfirmacaoModel->getMsgRetorno());
                }
                //segunda verficaçao para a situaçao
                $daoFinEntregaItens->retornaAgurdandoEntrega($pdo);
                if ($daoFinEntregaItens->sucesso()) {
                    $aguardandoentrega = $daoFinEntregaItens->getMsgRetorno();
                } else {
                    $erro = true;
                    return Metodos::retornoAjax("Erro", "console", $daoFinEntregaItens->getMsgRetorno());
                }
                foreach ($aguardandoentrega as $v) {
                    if ((Metodos::ConverteValorIng($v["aguardandoentrega"])) > 0) {
                        $contParcial ++;
                    }
                }

                if ($contTotal > 0 && $contParcial == 0) {
                    //atualiza a situacao da entrega
                    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                    $finEntregaConfirmacaoModel->setSitEntrega(2);
                    $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
                } else if ($contParcial > 0) {
                    //atualiza a situacao da entrega
                    $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($valor->id_entrega);
                    $finEntregaConfirmacaoModel->setSitEntrega(1);
                    $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
                }
                //verificar ser a situacao foi atulizada corretamente 
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

    public function listaSituacaoDaEntrega() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoFinEntregaItens = new DaoFinEntregaItens();
            $daoFinEntregaItens->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $daoFinEntregaItens->retornaSituacaoDaEntrega($pdo);
            if ($daoFinEntregaItens->sucesso()) {

                return $daoFinEntregaItens->getMsgRetorno();
            }
        } catch (Exception $ex) {
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
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
            $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            $finEntregaConfirmacaoModel->retornaUltimaDataEntrega($pdo);
            $dataMaior = $finEntregaConfirmacaoModel->getMsgRetorno()["max"];
            //buscando a data do item a ser removido no banco
            $daoFinEntregaItens->setIdEntregaItens($this->id_entrega_itens);
            $daoFinEntregaItens->retornaDataEntregaItens($pdo);

            if ($daoFinEntregaItens->sucesso()) {
                $dataItem = $daoFinEntregaItens->getMsgRetorno();
            } else {
                return Metodos::retornoAjax("Erro", "alert", STR_ERROR);
            }

            if (strtotime($dataMaior) > strtotime($dataItem["dt_entrega"])) {
                return Metodos::retornoAjax("Erro", "alert", "Exclua o item que tem a maior data");
            }

            $daoFinEntregaItens->removeItemEntrega($pdo);
            $erro = false;

            if (!$daoFinEntregaItens->sucesso()) {
                $erro = true;
            }

            $finEntregaConfirmacaoModel->retornaUltimaDataEntrega($pdo);
            $dataMaior = $finEntregaConfirmacaoModel->getMsgRetorno()["max"];

            //verificar ser deu tudo certo no retorno da maio data 
            if ($finEntregaConfirmacaoModel->sucesso()) {
                $finEntregaConfirmacaoModel->setDtConfirmacao($dataMaior);
                $finEntregaConfirmacaoModel->atualizaDataConfirmacao($pdo);
            }

            if (!$finEntregaConfirmacaoModel->sucesso()) {
                $erro = true;
            }

            //seto o id da entrega confirmacao para pode realiza a pesquisa
            $daoFinEntregaItens->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
            //verificar ser e a ultima entrega ser for false e a ultima sendo assim
            //tenho que volta o status da confirmacao da entrega para 0
            $daoFinEntregaItens->verificarUltimaEntrega($pdo);

            if ($daoFinEntregaItens->sucesso()) {
                $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
                $finEntregaConfirmacaoModel->setSitEntrega(1);
                $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
            } else {
                $finEntregaConfirmacaoModel->setIdEntregaConfirmacao($this->id_entrega_confirmacao);
                $finEntregaConfirmacaoModel->setSitEntrega(0);
                $finEntregaConfirmacaoModel->atualizaSituacao($pdo);
            }

            if (!$finEntregaConfirmacaoModel->sucesso()) {
                $erro = true;
            }

            if (!Log::SalvaLogD("fin_entrega_itens", $this->id_entrega_itens, $pdo)) {
                $erro = true;
            }

            if (!$erro) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", STR_REMOCAO_SUCESSO);
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
        if($daoFinEntregaItens->sucesso()){
            var_dump($daoFinEntregaItens->getMsgRetorno());
//            $this->vl_itens_entrega = $daoFinEntregaItens->getMsgRetorno()->vl_itens_ordem;
            return true;
        }else{
            return false;
        }
        
        
    }

}
