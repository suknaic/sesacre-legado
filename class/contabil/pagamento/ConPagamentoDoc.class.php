<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/dao/contabil/pagamento/DaoConPagamentoDoc.class.php";

class ConPagamentoDoc {

    private $id_pagamento_doc = null;
    private $id_pagamento = null;
    private $id_documento_fiscal = null;
    private $vl_documento_fiscal = null;
    private $vl_pagamento_doc_saldo = null;
    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function getIdPagamentoDoc() {
        return $this->id_pagamento_doc;
    }

    public function setIdPagamentoDoc($id_pagamento_doc) {
        $this->id_pagamento_doc = $id_pagamento_doc;

        return $this;
    }

    public function getIdPagamento() {
        return $this->id_pagamento;
    }

    public function setIdPagamento($id_pagamento) {
        $this->id_pagamento = $id_pagamento;

        return $this;
    }

    public function getIdDocumentoFiscal() {
        return $this->id_documento_fiscal;
    }

    public function setIdDocumentoFiscal($id_documento_fiscal) {
        $this->id_documento_fiscal = $id_documento_fiscal;

        return $this;
    }

    public function getVlDocumentoFiscal() {
        return $this->vl_documento_fiscal;
    }

    public function setVlDocumentoFiscal($vl_documento_fiscal) {
        $this->vl_documento_fiscal = $vl_documento_fiscal;

        return $this;
    }

    public function getVlPagamentoDocSaldo() {
        return $this->vl_pagamento_doc_saldo;
    }

    public function setVlPagamentoDocSaldo($vl_pagamento_doc_saldo) {
        $this->vl_pagamento_doc_saldo = $vl_pagamento_doc_saldo;

        return $this;
    }

    public function salvaDocPagamento(PDO $pdo) {
        try {

            if (!empty($this->id_documento_fiscal) && !empty($this->id_pagamento) && !empty($this->vl_documento_fiscal) && !empty($this->vl_pagamento_doc_saldo)) {
                $daoConPagamentoDoc = new DaoConPagamentoDoc();
                $daoConPagamentoDoc->setIdPagamento($this->id_pagamento);
                $daoConPagamentoDoc->setIdDocumentoFiscal($this->id_documento_fiscal);
                $daoConPagamentoDoc->setVlDocumentoFiscal(Metodos::ConverteValorIng($this->vl_documento_fiscal));
                $daoConPagamentoDoc->setVlPagamentoDocSaldo(Metodos::ConverteValorIng($this->vl_pagamento_doc_saldo));
                $daoConPagamentoDoc->salvaDocPagamento($pdo);
                if ($daoConPagamentoDoc->Sucesso()) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = $daoConPagamentoDoc->getMsgRetorno();
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = STR_PREENCHER_CAMPOS;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function montaTabelaDocumentosPagamento(bool $edita = true) {
        try {
            $tabela = '';

            $conexao = new Conexao();
            $pdo = $conexao->connect();
            $daoConPagamentoDoc = new DaoConPagamentoDoc();
            $daoConPagamentoDoc->setIdPagamento($this->id_pagamento);
            $daoConPagamentoDoc->documentosFiscaisPagamento($pdo);
            if ($daoConPagamentoDoc->Sucesso()) {
                foreach ($daoConPagamentoDoc->getMsgRetorno() as $linha) {
                    $tabela .= "<tr data-id=" . $linha['id_documento_fiscal'] . " data-objeto='" . json_encode($linha) . "' class='documentoFiscal'>"
                            . "<td class='text-center'>" . $linha['nr_documento_fiscal'] . "</td>"
                            . "<td class='text-center'>" . $linha['nm_tipo_documento'] . "</td>"
                            . "<td class='text-center'>" . $linha['mm_competencia'] ."/".$linha['aa_competencia'] ."</td>"
                            . "<td class='text-center'>" . $linha['dt_emissao'] . "</td>"
                            . "<td class='text-center'>" . $linha['dt_atesto'] . "</td>"
                            . "<td class='text-center'>" . Metodos::ConverteValorBr($linha['vl_documento'], 4) . "</td>"
                            . "<td class='text-center'>" . Metodos::ConverteValorBr($linha['vl_pagamento_doc_saldo'], 4) . "</td>"
                            . "<td class='text-center'>
                            <input class='form-control valorRetPagamento' type='text' name='valorRetPagamento[]' id='valorRetPagamento[]' 
                             value='".Metodos::ConverteValorBr($linha['vl_pagamento_doc'], 4)."'>
                            </td>"
                            . "<td class='text-center'>" . $linha['nm_situacao'] . "</td>"
                            . "<td class='text-center'>"
                            . "<button type='button' title='Ver Documento Fiscal' class='ver-documento' value=" . $linha['id_documento_fiscal'] . ">"
                            . "<i class='fa fa-file-text-o text-info' aria-hidden='true'></i>"
                            . "</button>";
                    if ($edita) {
                        $tabela .= "<button type='button' title='Remover Documento Fiscal' class='remover-documento'>"
                                . "<i class='fa fa-trash text-danger' aria-hidden='true'></i>"
                                . "</button>";
                    }

                    $tabela .= "</td></tr>";
                }
            }
            return $tabela;
        } catch (Exception $exc) {
            return $ex->getMessage();
        }
    }

    public function retornaTodosConPagamentoPorPagamento($pdo) {
        try {
            if (!empty($pdo)) {
                $daoConPagamentoDoc = new DaoConPagamentoDoc();
                $daoConPagamentoDoc->setIdPagamento($this->id_pagamento);
                $daoConPagamentoDoc->documentosFiscaisPagamento($pdo);
                if ($daoConPagamentoDoc->Sucesso()) {
                    $this->sucesso = true;
                    $this->msgRetorno = $daoConPagamentoDoc->getMsgRetorno();
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum documento fiscal encontrado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro de conexão";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
