<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamento.class.php";

class ConPagamento {

    private $id_pagamento = null;
    private $id_pagamento_situacao = null;
    private $id_pagamento_status = null;
    private $id_liquidacao = null;
    private $id_liquidacao_situacao = null;
    private $id_empenho = null;
    private $id_lotacao = null;
    private $id_doc_tipo_lotacao = null;
    private $nr_pagamento = null;
    private $dt_pagamento = null;
    private $vl_pagamento = null;
    private $vl_pagamento_saldo = null;
    private $ds_anotacao = null;
    private $st_ativo = null;
    private $docs_pagamento = null;
    private $id_pessoa = null;
    private $idPedido = null;
    private $sitCadastrado = 1;
    private $sitCancelado = 2;

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getIdPagamentoSituacao() {
        return $this->id_pagamento_situacao;
    }

    public function setIdPagamentoSituacao($id_pagamento_situacao) {
        $this->id_pagamento_situacao = $id_pagamento_situacao;

        return $this;
    }

    public function getIdPagamentoStatus() {
        return $this->id_pagamento_status;
    }

    public function setIdPagamentoStatus($id_pagamento_status) {
        $this->id_pagamento_status = $id_pagamento_status;

        return $this;
    }

    public function getIdLiquidacao() {
        return $this->id_liquidacao;
    }

    public function setIdLiquidacao($id_liquidacao) {
        $this->id_liquidacao = $id_liquidacao;

        return $this;
    }

    public function getIdLiquidacaoSituacao() {
        return $this->id_liquidacao_situacao;
    }

    public function setIdLiquidacaoSituacao($id_liquidacao_situacao) {
        $this->id_liquidacao_situacao = $id_liquidacao_situacao;

        return $this;
    }

    public function getIdEmpenho() {
        return $this->id_empenho;
    }

    public function setIdEmpenho($id_empenho) {
        $this->id_empenho = $id_empenho;

        return $this;
    }

    public function getIdLotacao() {
        return $this->id_lotacao;
    }

    public function setIdLotacao($id_lotacao) {
        $this->id_lotacao = $id_lotacao;

        return $this;
    }

    public function getIdDocTipoLotacao() {
        return $this->id_doc_tipo_lotacao;
    }

    public function setIdDocTipoLotacao($id_doc_tipo_lotacao) {
        $this->id_doc_tipo_lotacao = $id_doc_tipo_lotacao;

        return $this;
    }

    public function getNrPagamento() {
        return $this->nr_pagamento;
    }

    public function setNrPagamento($nr_pagamento) {
        $this->nr_pagamento = $nr_pagamento;

        return $this;
    }

    public function getDtPagamento() {
        return $this->dt_pagamento;
    }

    public function setDtPagamento($dt_pagamento) {
        $this->dt_pagamento = $dt_pagamento;

        return $this;
    }

    public function getVlPagamento() {
        return $this->vl_pagamento;
    }

    public function setVlPagamento($vl_pagamento) {
        $this->vl_pagamento = $vl_pagamento;

        return $this;
    }

    public function getVlPagamentoSaldo() {
        return $this->vl_pagamento_saldo;
    }

    public function setVlPagamentoSaldo($vl_pagamento_saldo) {
        $this->vl_pagamento_saldo = $vl_pagamento_saldo;

        return $this;
    }

    public function getDsAnotacao() {
        return $this->ds_anotacao;
    }

    public function setDsAnotacao($ds_anotacao) {
        $this->ds_anotacao = $ds_anotacao;

        return $this;
    }

    public function getStAtivo() {
        return $this->st_ativo;
    }

    public function setStAtivo($st_ativo) {
        $this->st_ativo = $st_ativo;

        return $this;
    }

    public function getDocsPagamento() {
        return $this->docs_pagamento;
    }

    public function setDocsPagamento($docs_pagamento) {
        $this->docs_pagamento = $docs_pagamento;

        return $this;
    }

    public function getIdPessoa() {
        return $this->id_pessoa;
    }

    public function setIdPessoa($id_pessoa) {
        $this->id_pessoa = $id_pessoa;

        return $this;
    }

    function getIdPedido() {
        return $this->idPedido;
    }

    function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }

    public function getSitCadastrado() {
        return $this->sitCadastrado;
    }

    public function getSitCancelado() {
        return $this->sitCancelado;
    }

    public function salvaPagamento() {
        try {

            if (empty($this->id_liquidacao) || empty($this->id_lotacao) || empty($this->id_doc_tipo_lotacao) || empty($this->nr_pagamento) || empty($this->dt_pagamento) || empty($this->vl_pagamento) || empty($this->vl_pagamento_saldo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            if (round(Metodos::ConverteValorIng($this->vl_pagamento_saldo), 4) < round(Metodos::ConverteValorIng($this->vl_pagamento), 4)) {
                return Metodos::retornoAjax("Erro", "alert", "Valor do pagamento e maior que o saldo da liquidação.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            //removendo barra do numero do pagamento
            $this->nr_pagamento = str_replace("/", "", $this->nr_pagamento);

            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamentoSituacao($this->sitCadastrado);
            $daoConPagamento->setIdPagamentoStatus(1);
            $daoConPagamento->setIdLiquidacao($this->id_liquidacao);
            $daoConPagamento->setIdLiquidacaoSituacao($this->id_liquidacao_situacao);
            $daoConPagamento->setIdLotacao($this->id_lotacao);
            $daoConPagamento->setIdDocTipoLotacao($this->id_doc_tipo_lotacao);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setDtPagamento(Metodos::ConverteDataING($this->dt_pagamento));
            $daoConPagamento->setVlPagamento(Metodos::ConverteValorIng($this->vl_pagamento));
            $daoConPagamento->setVlPagamentoSaldo(Metodos::ConverteValorIng($this->vl_pagamento_saldo));
            $daoConPagamento->salvaPagamento($pdo);
            
            echo '<pre>';
            echo $daoConPagamento->getMsgRetorno();
            echo '</pre>';
            
            $this->id_pagamento = $pdo->lastInsertId('con_pagamento_id_pagamento_seq');

            if (!empty($this->docs_pagamento)) {
                foreach ($this->docs_pagamento as $dados) {

                    if (round(Metodos::ConverteValorIng($dados["vl_pagamento_doc_saldo"]), 4) < round(Metodos::ConverteValorIng($dados["vl_pagamento_doc"]), 4)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Verifique os valore(s) do(s) documento(s) fiscais.");
                    }

                    if (round(Metodos::ConverteValorIng($dados["vl_pagamento_doc"]), 4) == 0) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Valor do documento tem que ser maior que 0");
                    }


                    $conPagamentoDoc = new ConPagamentoDoc();
                    $conPagamentoDoc->setIdPagamento($this->id_pagamento);
                    $conPagamentoDoc->setIdDocumentoFiscal($dados["id_documento_fiscal"]);
                    $conPagamentoDoc->setIdDocumentoSituacao($dados["id_documento_situacao"]);
                    $conPagamentoDoc->setVlDocumentoFiscal($dados["vl_pagamento_doc"]);
                    $conPagamentoDoc->setVlPagamentoDocSaldo($dados["vl_pagamento_doc_saldo"]);
                    $conPagamentoDoc->salvaDocPagamento($pdo);

                    if (!$conPagamentoDoc->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro ao salva o(s) documento(s) fiscais.");
                    }

                    if (!$this->atualizaDocumentoFiscalPagamento($pdo, $dados["id_documento_fiscal"])) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situacao do(s) documento(s) fiscais.");
                    }
                }
            }

            $conPagamentoHistorico = new ConPagamentoHistorico();
            $conPagamentoHistorico->setIdPagamento($this->id_pagamento);
            $conPagamentoHistorico->setIdPessoa($this->id_pessoa);
            $conPagamentoHistorico->setIdLotacao($this->id_lotacao);
            $conPagamentoHistorico->setIdDocTipoLotacao($this->id_doc_tipo_lotacao);
            $conPagamentoHistorico->setIdPagamentoSituacao($this->sitCadastrado);
            $conPagamentoHistorico->setIdPagamentoStatus(1);
            $conPagamentoHistorico->setDsPagamentoHistorico($this->ds_anotacao);

            $conPagamentoHistorico->salvaHistoricoPagamento($pdo);

            if (!$conPagamentoHistorico->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salva o historico pagamento");
            }
            if (!empty($this->ds_anotacao)) {
                $conPagamentoAnotacoes = new ConPagamentoAnotacoes();
                $conPagamentoAnotacoes->setIdPagamento($this->id_pagamento);
                $conPagamentoAnotacoes->setIdPessoa($this->id_pessoa);
                $conPagamentoAnotacoes->setDsPagamentoAnotacao($this->ds_anotacao);
                $conPagamentoAnotacoes->salvaAnotacaoPagamento($pdo);

                if (!$conPagamentoAnotacoes->Sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a Anotação");
                }
            }


            //atualiza situacao e status pedido
            $pedido = new Pedido();
            $pedido->setIdPedido($this->idPedido);
            $pedido->atualizaStatusSituacaoOficialPedido($pdo);

            if (!$pedido->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $pedido->getMsgRetorno());
            }
            //atualiza situacao e status empenho
            $empenho = new FinEmpenhoModel();
            $empenho->setIdEmpenho($this->id_empenho);
            $empenho->atualizaStatusSituacaoOficialEmpenho($pdo);

            if (!$empenho->sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", $empenho->getMsgRetorno());
            }

            if (!$this->atualizaLiquidacaoPagamento($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação da liquidação");
            }

            if ($daoConPagamento->Sucesso()) {
                $pdo->commit();
                return Metodos::retornoAjax("ok", "html", "Pagamento cadastrado com sucesso.");
            }

            $pdo->rollBack();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao cadastrar o pagamento");
        } catch (Exception $ex) {
            return $ex->getMessage();
            return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os dados deste Pagamento");
        }
    }

    public function retornaDadosPagamento() {
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamento($this->id_pagamento);
            $daoConPagamento->retornaDadosParaVisualizacaoPagamento($pdo);
            return $daoConPagamento->getMsgRetorno();
        } catch (Exception $ex) {
            
        }
    }

    public function tabelaDocumentoPagamentoVisualiza(bool $condicao = false) {
        try {
            $conPagamentoDoc = new ConPagamentoDoc();
            $conPagamentoDoc->setIdPagamento($this->id_pagamento);
            return $conPagamentoDoc->montaTabelaDocumentosPagamento($condicao);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function cancelarPagamento() {
        try {
            if (empty($this->id_pagamento) || empty($this->ds_anotacao)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamento($this->id_pagamento);
            $daoConPagamento->setIdPagamentoSituacao($this->getSitCancelado());

            $daoConPagamento->retornaDocumentosFiscaisPagamento($pdo);
            $documentoFiscais = array();
            if ($daoConPagamento->Sucesso()) {

                $documentoFiscais = $daoConPagamento->getMsgRetorno();
            }

            $daoConPagamento->retornaDadosLogPagamaneto($pdo);

            if (!$daoConPagamento->Sucesso()) {
                return Metodos::retornoAjax("Erro", "alert", "Erro ao verificar os dados deste Pagamento");
            }

            $dadosPagamento = $daoConPagamento->getMsgRetorno();

            $daoConPagamento->mudaSituacaoPagamento($pdo);

            if (!$daoConPagamento->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", $daoConPagamento->getMsgRetorno());
            }

            if (!empty($documentoFiscais)) {
                foreach ($documentoFiscais as $doc) {
                    if (!$this->atualizaDocumentoFiscalPagamento($pdo, $doc["id_documento_fiscal"])) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situacao do(s) documento(s) fiscais.");
                    }
                }
            }


            $arrayIds = $this->retornaIdPedidoEIdEmpenhoPorIdPagamento($pdo);

            if (array_key_exists("id_pedido", $arrayIds) && is_numeric($arrayIds["id_pedido"])) {
                //atualiza situacao e status pedido
                $pedido = new Pedido();
                $pedido->setIdPedido($arrayIds["id_pedido"]);
                $pedido->atualizaStatusSituacaoOficialPedido($pdo);

                if (!$pedido->sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $pedido->getMsgRetorno());
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível atualiza o pedido.");
            }

            if (array_key_exists("id_empenho", $arrayIds) && is_numeric($arrayIds["id_empenho"])) {
                $empenho = new FinEmpenhoModel();
                $empenho->setIdEmpenho($arrayIds["id_empenho"]);
                $empenho->atualizaStatusSituacaoOficialEmpenho($pdo);

                if (!$empenho->sucesso()) {
                    $pdo->rollBack();
                    return Metodos::retornoAjax("Erro", "alert", $empenho->getMsgRetorno());
                }
            } else {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Não foi possível atualiza o empenho.");
            }

            if (!Log::SalvaLogU('con_pagamento', $this->id_pagamento, $dadosPagamento, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }

            $conPagamentoHistorico = new ConPagamentoHistorico();
            $conPagamentoHistorico->setIdPagamento($this->id_pagamento);
            $conPagamentoHistorico->setIdPessoa($this->id_pessoa);
            $conPagamentoHistorico->setIdLotacao($dadosPagamento["id_lotacao"]);
            $conPagamentoHistorico->setIdDocTipoLotacao($dadosPagamento["id_doc_tipo_lotacao"]);
            $conPagamentoHistorico->setIdPagamentoSituacao($this->sitCancelado);
            $conPagamentoHistorico->setIdPagamentoStatus(1);
            $conPagamentoHistorico->setDsPagamentoHistorico($this->ds_anotacao);

            $conPagamentoHistorico->salvaHistoricoPagamento($pdo);

            if (!$conPagamentoHistorico->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", "Erro na atualização do histórico." . $conPagamentoHistorico->getMsgRetorno());
            }
            $this->id_liquidacao = $dadosPagamento["id_liquidacao"];
            if (!$this->atualizaLiquidacaoPagamento($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação da liquidação");
            }

            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Pagamento cancelado com sucesso.");
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarPagamento() {
        try {

            if (empty($this->id_liquidacao) || empty($this->id_lotacao) || empty($this->id_doc_tipo_lotacao) || empty($this->nr_pagamento) ||
                    empty($this->dt_pagamento) || empty($this->vl_pagamento)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }


            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $conPagamentoDoc = new ConPagamentoDoc();
            $conPagamentoDoc->setIdPagamento($this->id_pagamento);
            $conPagamentoDoc->retornaTodosConPagamentoPorPagamento($pdo);

            if ($this->vl_pagamento == "0,0000" || $this->vl_pagamento == "0,00" || (float) Metodos::ConverteValorIng($this->vl_pagamento) <= 0) {
                return Metodos::retornoAjax("Erro", "alert", "Valor do Documento Fiscal não pode ser Zerado.");
            }

            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamento($this->id_pagamento);

            if ($conPagamentoDoc->Sucesso()) {
                foreach ($conPagamentoDoc->getMsgRetorno() as $entregas) {

                    $daoConPagamento->deletaDocumentoPagamentoEdicao($pdo, $entregas["id_pagamento_doc"]);

                    if (!$daoConPagamento->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação do documento fiscal 01");
                    }
                    if (!$this->atualizaDocumentoFiscalPagamento($pdo, $entregas["id_documento_fiscal"])) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação do documento fiscal 02");
                    }
                }
            }

            if (!empty($this->docs_pagamento)) {

                foreach ($this->docs_pagamento as $dados) {
                    $daoConPagamento->retornaSaldoDocumentoFiscalEdicao($pdo, $dados["id_documento_fiscal"]);
                    $saldo = $daoConPagamento->getMsgRetorno()["saldo"];
                    if (!$daoConPagamento->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro ao retorna o saldo do documento fiscal.");
                    }

                    if (round(Metodos::ConverteValorIng($dados["vl_pagamento_doc"]), 4) == 0) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Valor do documento tem que ser maior que 0");
                    }

                    if (round($saldo, 4) < round(Metodos::ConverteValorIng($dados["vl_pagamento_doc"]), 4)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Saldo insuficiente verifique os valore(s) do(s) documento(s) fiscais.");
                    }

                    $conPagamentoDoc->setIdDocumentoFiscal($dados["id_documento_fiscal"]);
                    $conPagamentoDoc->setIdDocumentoSituacao($dados["id_documento_situacao"]);
                    $conPagamentoDoc->setVlDocumentoFiscal($dados["vl_pagamento_doc"]);
                    $conPagamentoDoc->setVlPagamentoDocSaldo(Metodos::ConverteValorBr($saldo, 4));

                    $conPagamentoDoc->salvaDocPagamento($pdo);

                    if (!$conPagamentoDoc->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro ao salva o(s) documento(s) fiscais." . $conPagamentoDoc->getMsgRetorno());
                    }

                    if (!$this->atualizaDocumentoFiscalPagamento($pdo, $dados["id_documento_fiscal"])) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situacao do(s) documento(s) fiscais.");
                    }
                }
            }

            //removendo barra do numero do pagamento
            $this->nr_pagamento = str_replace("/", "", $this->nr_pagamento);
            $daoConPagamento->setIdPagamento($this->id_pagamento);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setDtPagamento(Metodos::ConverteDataING($this->dt_pagamento));
            $daoConPagamento->setVlPagamento(Metodos::ConverteValorIng($this->vl_pagamento));
            $daoConPagamento->setIdLiquidacao($this->id_liquidacao);
            $daoConPagamento->setIdLiquidacaoSituacao($this->id_liquidacao_situacao);
            $daoConPagamento->retornaSaldoLiquidacaoPagamentoEdicao($pdo);

            if (!$daoConPagamento->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao retorna o saldo da liquidação");
            }
            $saldoLiquidacao = 0;
            $saldoLiquidacao = $daoConPagamento->getMsgRetorno()["saldo"];
            $daoConPagamento->setVlPagamentoSaldo($saldoLiquidacao);

            if (!round($saldoLiquidacao, 4) >= round(Metodos::ConverteValorIng($this->vl_pagamento), 4)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Valor do pagamento e maior que o saldo da liquidação.");
            }

            $daoConPagamento->atualizaPagamento($pdo);

            if (!$daoConPagamento->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao atualiza o pagamento");
            }

            if (!$this->atualizaLiquidacaoPagamento($pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro na atualização da situação da liquidação");
            }


            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Pagamento atualizado com sucesso.");
        } catch (Exception $ex) {
            //Se der algum erro, registra o erro no objeto
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function retornaIdPedidoEIdEmpenhoPorIdPagamento(PDO $pdo = null) {
        $daoConPagamento = new DaoConPagamento();
        $daoConPagamento->setIdPagamento($this->id_pagamento);
        $daoConPagamento->retornaIdPedidoEIdEmpenhoPorPagamento($pdo);
        return $daoConPagamento->getMsgRetorno();
    }

    public function retornaHistorico() {
        $retorno = "";
        try {
            $conexao = new Conexao();
            $pdo = $conexao->connect();

            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamento($this->id_pagamento);
            $daoConPagamento->retornaHistoricoPagamento($pdo);

            if ($daoConPagamento->Sucesso()) {
                foreach ($daoConPagamento->getMsgRetorno() as $linha) {
                    $retorno .= $linha['historico'] . "\n";
                }
            } else {
                $retorno = $daoConPagamento->getMsgRetorno();
            }
            return $retorno;
        } catch (Exception $exc) {
            $retorno = "";
        }
    }

    public function atualizaLiquidacaoPagamento(PDO $pdo) {
        try {
            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdLiquidacao($this->id_liquidacao);
            $daoConPagamento->retornaSituacaoParaAtualizaLiquidacao($pdo);
            if (!$daoConPagamento->Sucesso()) {
                return false;
            }
            $situacao = $daoConPagamento->getMsgRetorno();

            if (!is_numeric($situacao["status"])) {
                return false;
            }

            $daoConPagamento->atualizaSituacaoLiquidacao($pdo, $situacao["status"]);
            if (!$daoConPagamento->Sucesso()) {
                return false;
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function atualizaDocumentoFiscalPagamento(PDO $pdo, $documento = null) {
        try {
            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->retornaSituacaoParaAtualizaDocumentoFiscal($pdo, $documento);
            if (!$daoConPagamento->Sucesso()) {
                return false;
            }
            $situacao = $daoConPagamento->getMsgRetorno();
            if (!is_numeric($situacao["status"])) {
                return false;
            }

            $daoConPagamento->atualizaSituacaoDocumentoFiscal($pdo, $documento, $situacao["status"]);
            if (!$daoConPagamento->Sucesso()) {
                return false;
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function retornaLiquidacaoVerEditarPagamento($pdo) {
        try {

            if (empty($pdo)) {
                $conexao = new Conexao();
                $pdo = $conexao->connect();
            }

            $dadosContrato = '';
            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamento($this->id_pagamento);
            $daoConPagamento->retornaLiquidacaoPorIdPagamento($pdo);

            if ($daoConPagamento->sucesso()) {
                $campos = $daoConPagamento->getMsgRetorno();

                $dadosContrato .= '<div class="panel-group" id="accordionFor" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingFor">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordionFor" href="#collapseFor" 
                                                        aria-expanded="true" aria-controls="collapseFor" >
                                                        <i class="glyphicon glyphicon-chevron-down"></i>
                                                        <b>Dados da Liquidação: </b><span style="color:#758697"> Nº ' . $campos["nr_liquidacao"] . '</span> 
                                                    </a>
                                                </h4>
                                            </div>
                                        
                                            <div id="collapseFor" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFor" aria-expanded="true">
                                                <div class="panel-body">
                                                <input id="id_liquidacao" type="hidden" value="' . $campos['id_liquidacao'] . '" />
                                                <input id="saldoLiquidacao" type="hidden" value="' . $campos['saldo'] . '" /> 
                                                <input id="id_liquidacao_situacao" type="hidden" value="' . $campos['id_liquidacao_situacao'] . '" />    
                                                <table id="tabelaItens" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Data da Liquidação</th>
                                                            <th class="text-center">Valor da Liquidação</th>
                                                            <th class="text-center">Saldo da liquidação</th>
                                                            <th class="text-center">Situação</th>
                                                            <th class="text-center">Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">' . $campos["dt_liquidacao"] . '</td>
                                                            <td class="text-center">' . $campos["vl_liquidacao"] . '</td>
                                                            <td class="text-center">' . $campos["saldo"] . '</td>
                                                            <td class="text-center">' . $campos["situacao"] . '</td>
                                                            <td class="text-center">
                                                                <button type="button" title="Ver Liquidação" class="ver-liquidacao" value="' . $campos['id_liquidacao'] . '">
                                                                <i class="fa fa-file-text-o text-info" aria-hidden="true"></i>
                                                                </button>
                                                            </td>    
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                         </div>
                                    </div>';
                return $dadosContrato;
            }
            return $dadosContrato;
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
            return;
        }
    }

}
