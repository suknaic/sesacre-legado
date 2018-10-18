<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamento.class.php";

class ConPagamento {

    private $id_pagamento = null;
    private $id_pagamento_situacao = null;
    private $id_pagamento_status = null;
    private $id_liquidacao = null;
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

            if (round($this->vl_pagamento_saldo, 4) < round(Metodos::ConverteValorIng($this->vl_pagamento), 4)) {
                return Metodos::retornoAjax("Erro", "alert", "Valor do pagamento e maior que o saldo da liquidação.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();

            $daoConPagamento = new DaoConPagamento();
            $daoConPagamento->setIdPagamentoSituacao($this->sitCadastrado);
            $daoConPagamento->setIdPagamentoStatus(1);
            $daoConPagamento->setIdLiquidacao($this->id_liquidacao);
            $daoConPagamento->setIdLotacao($this->id_lotacao);
            $daoConPagamento->setIdDocTipoLotacao($this->id_doc_tipo_lotacao);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setNrPagamento($this->nr_pagamento);
            $daoConPagamento->setDtPagamento(Metodos::ConverteDataING($this->dt_pagamento));
            $daoConPagamento->setVlPagamento(Metodos::ConverteValorIng($this->vl_pagamento));
            $daoConPagamento->setVlPagamentoSaldo($this->vl_pagamento_saldo);
            $daoConPagamento->salvaPagamento($pdo);
            $this->id_pagamento = $pdo->lastInsertId('con_pagamento_id_pagamento_seq');

            if (!empty($this->docs_pagamento)) {
                foreach ($this->docs_pagamento as $dados) {

                    if (round($dados["vl_pagamento_doc_saldo"], 4) < round(Metodos::ConverteValorIng($dados["vl_pagamento_doc"]), 4)) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Verifique os valore(s) do(s) documento(s) fiscais.");
                    }

                    $conPagamentoDoc = new ConPagamentoDoc();
                    $conPagamentoDoc->setIdPagamento($this->id_pagamento);
                    $conPagamentoDoc->setIdDocumentoFiscal($dados["id_documento_fiscal"]);
                    $conPagamentoDoc->setVlDocumentoFiscal($dados["vl_pagamento_doc"]);
                    $conPagamentoDoc->setVlPagamentoDocSaldo($dados["vl_pagamento_doc_saldo"]);
                    $conPagamentoDoc->salvaDocPagamento($pdo);

                    if (!$conPagamentoDoc->Sucesso()) {
                        $pdo->rollBack();
                        return Metodos::retornoAjax("Erro", "alert", "Erro ao salva o(s) documento(s) fiscais.");
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

            $conPagamentoAnotacoes = new ConPagamentoAnotacoes();
            $conPagamentoAnotacoes->setIdPagamento($this->id_pagamento);
            $conPagamentoAnotacoes->setIdPessoa($this->id_pessoa);
            $conPagamentoAnotacoes->setDsPagamentoAnotacao($this->ds_anotacao);
            $conPagamentoAnotacoes->salvaAnotacaoPagamento($pdo);

            if (!$conPagamentoAnotacoes->Sucesso()) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "alert", "Erro ao salva a Anotação");
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

            if (!Log::SalvaLogU('con_pagamento', $this->id_pagamento, $dadosPagamento, $pdo)) {
                $pdo->rollBack();
                return Metodos::retornoAjax("Erro", "console", STR_ERROR);
            }


            $pdo->commit();
            return Metodos::retornoAjax("ok", "html", "Liquidação cancelada com sucesso.");
        } catch (Exception $exc) {
            //Se der algum erro, registra o erro no objeto
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

    public function editarPagamento() {
        try {
            
            if (empty($this->id_liquidacao) || empty($this->id_lotacao) || empty($this->id_doc_tipo_lotacao) || empty($this->nr_pagamento) || empty($this->dt_pagamento) || empty($this->vl_pagamento) || empty($this->vl_pagamento_saldo)) {
                return Metodos::retornoAjax("Erro", "alert", STR_PREENCHER_CAMPOS);
            }

            if (round($this->vl_pagamento_saldo, 4) < round(Metodos::ConverteValorIng($this->vl_pagamento), 4)) {
                return Metodos::retornoAjax("Erro", "alert", "Valor do pagamento e maior que o saldo da liquidação.");
            }

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $pdo->beginTransaction();
            
            
        } catch (Exception $ex) {
            //Se der algum erro, registra o erro no objeto
            return Metodos::retornoAjax("Erro", "console", $exc->getMessage());
        }
    }

}
