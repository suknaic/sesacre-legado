<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/pagamento/ConPagamentoDocTb.class.php";

class DaoConPagamentoDoc extends ConPagamentoDocTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function salvaDocPagamento(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "INSERT INTO con_pagamento_doc (id_pagamento, id_documento_fiscal, vl_pagamento_doc, vl_pagamento_doc_saldo) "
                        . "values (:pagamento, :documento, :valor, :valorSaldo)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
                $stmt->bindValue(":documento", $this->getIdDocumentoFiscal(), PDO::PARAM_INT);
                $stmt->bindValue(":valor", $this->getVlDocumentoFiscal(), PDO::PARAM_STR);
                $stmt->bindValue(":valorSaldo", $this->getVlPagamentoDocSaldo(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function documentosFiscaisPagamento(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select documento.id_documento_fiscal, documento.nr_documento_fiscal, tpDocumento.nm_tipo_documento, 
                        documento.mm_competencia, to_char(documento.dt_emissao, 'DD/MM/YYYY') as dt_emissao,
                        to_char(documento.dt_atesto, 'DD/MM/YYYY') as dt_atesto, documento.vl_documento, 
                        pagDoc.vl_pagamento_doc, pagDoc.vl_pagamento_doc_saldo, situacao.nm_situacao 
                        from con_pagamento as pagamento
                        inner join con_pagamento_doc as pagDoc
                        on pagDoc.id_pagamento = pagamento.id_pagamento
                        inner join fin_documento_fiscal as documento
                        on documento.id_documento_fiscal = pagDoc.id_documento_fiscal
                        inner join fin_tipo_documento as tpDocumento
                        on tpDocumento.id_tipo_documento = documento.id_tipo_documento
                        inner join fin_documento_situacao as situacao
                        on situacao.id_documento_situacao = documento.id_documento_situacao
                        where pagamento.id_pagamento = :pagamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pagamento", $this->getIdPagamento(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Não encontrou Registros";
                }
            }
        } catch (Exception $ex) {
            
        }
    }

}
