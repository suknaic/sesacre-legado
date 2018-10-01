<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/liquidacao/ConLiquidacao.class.php";

class DaoConLiquidacao extends ConLiquidacao {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    function insert($pdo) {
        try {

            $result = $pdo->prepare("INSERT INTO con_liquidacao (nr_liquidacao, id_empenho"
                    . " , id_liquidacao_situacao, id_liquidacao_status, id_doc_tipo_lotacao, id_lotacao, dt_liquidacao, vl_liquidacao"
                    . " , ds_liquidacao)"
                    . " VALUES (:nr_liquidacao, :id_empenho, :id_liquidacao_situacao, :id_liquidacao_status, :id_doc_tipo_lotacao"
                    . " , :id_lotacao, :dt_liquidacao, :vl_liquidacao, :ds_liquidacao);");
            $result->bindValue(":nr_liquidacao", $this->getNrLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao_status", $this->getIdLiquidacaoStatus(), PDO::PARAM_INT);
            $result->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":dt_liquidacao", $this->getDtLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":vl_liquidacao", $this->getVlLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_liquidacao", !empty($this->getDsLiquidacao()) ? $this->getDsLiquidacao() : null, PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET nr_liquidacao = :nr_liquidacao"
                    . " , dt_liquidacao = :dt_liquidacao, vl_liquidacao = :vl_liquidacao"
                    . " , ds_liquidacao = :ds_liquidacao"
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":nr_liquidacao", $this->getNrLiquidacao(), PDO::PARAM_STR);
//            $result->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
            $result->bindValue(":dt_liquidacao", $this->getDtLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":vl_liquidacao", $this->getVlLiquidacao(), PDO::PARAM_STR);
            $result->bindValue(":ds_liquidacao", !empty($this->getDsLiquidacao()) ? $this->getDsLiquidacao() : null, PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET st_ativo = '0'"
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function mudaSituacao($pdo) {
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET id_liquidacao_situacao = :id_liquidacao_situacao"
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao_situacao", $this->getIdLiquidacaoSituacao(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function mudaStatus($pdo) {
        try {
            $result = $pdo->prepare("UPDATE con_liquidacao SET id_liquidacao_status = :id_liquidacao_status"
                    . " WHERE id_liquidacao = :id_liquidacao ");
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao_status", $this->getIdLiquidacaoStatus(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retorna($pdo) {
        $this->sucesso = false;
        $sql = " SELECT *"
                . " FROM con_liquidacao"
                . " WHERE id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDocumentosPorEmpenho($pdo) {
        $this->sucesso = false;
        $sql = "select distinct
                    empenho.nr_empenho,
                    docFis.id_documento_fiscal,
                    docFis.nr_documento_fiscal,
                    tpDoc.nm_tipo_documento,
                    liqDoc.id_liquidacao_doc,
                    (
                       trim(to_char(docFis.mm_competencia, '09')) || '/' || trim(to_char(docFis.aa_competencia, '9999')) 
                    )
                    as competencia,
                    to_char(docFis.dt_emissao, 'dd/mm/yyyy') as dt_emissao,
                    to_char(docFis.dt_atesto, 'dd/mm/yyyy') as dt_atesto,
                    trim(to_char(vl_documento,'999G999G999D9999')) as vl_documento,
                    vl_documento as vl_doc_sem_mascara,
                    docFis.id_documento_situacao,
                    docSit.nm_situacao 
                 from
                    fin_empenho as empenho 
                    inner join
                       fin_ordem as ordem 
                       on ordem.id_pedido = empenho.id_pedido 
                    inner join
                       fin_entrega_confirmacao as entConfirm 
                       on entConfirm.id_ordem = ordem.id_ordem 
                    inner join
                       fin_entrega_documento as entDoc 
                       on entDoc.id_entrega_confirmacao = entConfirm.id_entrega_confirmacao 
                    inner join
                       fin_documento_fiscal as docFis 
                       on docFis.id_documento_fiscal = entDoc.id_documento_fiscal 
                    inner join
                       fin_tipo_documento as tpDoc 
                       on tpDoc.id_tipo_documento = docFis.id_tipo_documento 
                    left join
                       fin_documento_situacao as docSit 
                       on docSit.id_documento_situacao = docFis.id_documento_situacao 
                    left join
                       con_liquidacao as liq
                       on liq.id_empenho = empenho.id_empenho
                       and liq.id_liquidacao_situacao <> 4 /* DIFERENTE DE CANCELADO */
                    left join
                       con_liquidacao_doc as liqDoc
                       on liqDoc.id_documento_fiscal = docFis.id_documento_fiscal
                       and liqDoc.id_liquidacao = liq.id_liquidacao
                 where
                    (docFis.id_documento_situacao = 2 /*Somente 'A Liquidar'*/ or liqDoc.id_liquidacao = :id_liquidacao)
                 and
                    empenho.id_empenho = :id_empenho
                 order by
                    empenho.nr_empenho,
                    docFis.nr_documento_fiscal";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDocumentosPorLiquidacao($pdo) {
        $this->sucesso = false;
        $sql = "select distinct
                    empenho.nr_empenho,
                    liqDoc.id_liquidacao_doc,
                    docFis.id_documento_fiscal,
                    docFis.nr_documento_fiscal,
                    tpDoc.nm_tipo_documento,
                    liqDoc.id_liquidacao_doc,
                    (
                       trim(to_char(docFis.mm_competencia, '09')) || '/' || trim(to_char(docFis.aa_competencia, '9999')) 
                    )
                    as competencia,
                    to_char(docFis.dt_emissao, 'dd/mm/yyyy') as dt_emissao,
                    to_char(docFis.dt_atesto, 'dd/mm/yyyy') as dt_atesto,
                    trim(to_char(vl_documento,'999G999G999D9999')) as vl_documento,
                    vl_documento as vl_doc_sem_mascara,
                    docFis.id_documento_situacao,
                    docSit.nm_situacao 
                 from
                    con_liquidacao as liq 
                    inner join
                       fin_empenho as empenho
                       on empenho.id_empenho = liq.id_empenho
                    inner join 
                       con_liquidacao_doc as liqDoc
                       on liqDoc.id_liquidacao = liq.id_liquidacao
                    inner join
                       fin_documento_fiscal as docFis 
                       on docFis.id_documento_fiscal = liqDoc.id_documento_fiscal 
                    inner join
                       fin_tipo_documento as tpDoc 
                       on tpDoc.id_tipo_documento = docFis.id_tipo_documento 
                    left join
                       fin_documento_situacao as docSit 
                       on docSit.id_documento_situacao = docFis.id_documento_situacao 
                 where
                    liq.id_liquidacao = :id_liquidacao
                 order by
                    docFis.nr_documento_fiscal";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaLiquidacoes($pdo, string $filtros = "") {
        $this->sucesso = false;
        $sql = "select
                    liq.id_liquidacao,
                    liq.nr_liquidacao,
                    ped.nr_pedido,
                    emp.nr_empenho,
                    pj.nr_cnpj,
                    pj.nm_fantasia,
                    to_char(liq.dt_liquidacao,'dd/mm/yyyy') as dt_liquidacao,
                    to_char(liq.vl_liquidacao,'999G999G990D0999') as vl_liquidacao,
                    liqSit.nm_liquidacao_situacao,
                    string_agg(docFis.nr_documento_fiscal, ', ') as documentos_fiscais,
                    liq.id_liquidacao_situacao 
                 from
                    con_liquidacao as liq 
                    inner join
                       con_liquidacao_situacao as liqSit 
                       on liqSit.id_liquidacao_situacao = liq.id_liquidacao_situacao 
                    inner join
                       fin_empenho as emp 
                       on emp.id_empenho = liq.id_empenho 
                    inner join
                       fin_pedido as ped 
                       on ped.id_pedido = emp.id_pedido 
                    left join
                       con_liquidacao_doc as liqDoc 
                       on liqDoc.id_liquidacao = liq.id_liquidacao 
                    inner join
                       fin_fornecedor as fornec 
                       on fornec.id_fornecedor = ped.id_fornecedor 
                    inner join
                       ses_pessoa_juridica as pj 
                       on pj.id_pessoa = fornec.id_pessoa 
                    left join
                       fin_documento_fiscal as docFis 
                       on docFis.id_documento_fiscal = liqDoc.id_documento_fiscal "
                . $filtros .
                " group by
                    liq.id_liquidacao,
                    liq.nr_liquidacao,
                    ped.nr_pedido,
                    emp.nr_empenho,
                    pj.nr_cnpj,
                    pj.nm_fantasia,
                    liq.dt_liquidacao,
                    liq.vl_liquidacao,
                    liqSit.nm_liquidacao_situacao";
        try {
            $result = $pdo->prepare($sql);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDadosLiquidacao($pdo) {
        $this->sucesso = false;
        $sql = "select
                    liq.id_empenho,
                    liq.id_liquidacao,
                    liq.nr_liquidacao,
                    liq.id_lotacao,
                    liq.id_doc_tipo_lotacao,
                    ped.id_tipo_solicitacao,
                    trim(liq.ds_liquidacao) as ds_liquidacao,
                    to_char(liq.dt_liquidacao, 'dd/mm/yyyy') as dt_liquidacao,
                    trim(to_char(liq.vl_liquidacao, '999G999G999D0999')) as vl_liquidacao,
                    ped.id_pedido,
                    ped.nr_pedido 
                 from
                    con_liquidacao as liq 
                    inner join
                       fin_empenho as emp 
                       on emp.id_empenho = liq.id_empenho 
                    inner join
                       fin_pedido as ped 
                       on ped.id_pedido = emp.id_pedido
                where liq.id_liquidacao = :id_liquidacao";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDocumentosFiscaisDiferentesDeALiquidar($pdo, string $documentos = "0") { //Filtro com o número dos documentos temporário; Refatorar 
        $this->sucesso = false;
        $sql = "select
                    * 
                 from
                    fin_documento_fiscal as docFis 
                    left join
                       con_liquidacao_doc as liqDoc 
                       on liqDoc.id_documento_fiscal = docFis.id_documento_fiscal 
                       and liqDoc.id_liquidacao = :id_liquidacao 
                 where
                    docFis.id_documento_fiscal in 
                    (
                       " . $documentos . " 
                    )
                    and 
                    (
                       docFis.id_documento_situacao <> 2 		--diferente de 'A Liquidar'
                       and liqDoc.id_documento_fiscal is null 		--e que não esteja vinculada a Liquidação, pois na atualização a situação do gdof já estará 'Liquidado'
                    )";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_liquidacao", $this->getIdLiquidacao(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaLiquidacaoPorNumeroPamento(PDO $pdo) {
        try {
            $sql = "select empenho.id_empenho, empenho.id_pedido, pedido.nr_pedido, liquidacao.id_liquidacao,
                    liquidacao.nr_liquidacao, to_char(liquidacao.dt_liquidacao,'DD/MM/YYYY') as dt_liquidacao
                    from con_liquidacao as liquidacao
                    inner join fin_empenho as empenho
                    on empenho.id_empenho = liquidacao.id_empenho
                    inner join fin_pedido as pedido
                    on pedido.id_pedido = empenho.id_pedido
                    where liquidacao.nr_liquidacao = :numero";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":numero", $this->getNrLiquidacao(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
