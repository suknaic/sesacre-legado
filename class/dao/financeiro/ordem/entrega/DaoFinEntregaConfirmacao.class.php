<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinEntregaConfirmacaoTb.class.php";

class DaoFinEntregaConfirmacao extends FinEntregaConfirmacaoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    /**
     * [sucesso e responsavel ]
     * @return [type]
     */
    public function sucesso() {
        return $this->sucesso;
    }

    public function salvaEntregaConfirmacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {

                $sql = "insert into fin_entrega_confirmacao(id_ordem, id_protocolo, nr_entrega_confirmacao, dt_entrega, sit_entrega) 
                        values(:ordem, :protocolo, :nrEntrega, :dtEntrega, :situacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->bindValue(":nrEntrega", $this->getNrEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->bindValue(":dtEntrega", $this->getDtEntrega(), PDO::PARAM_STR);
                $stmt->bindValue(":situacao", $this->getSitEntrega(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = "Sem conexao";
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaInforParaEntrega(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select orItens.id_ordem_itens, itens.nr_item, mat.cd_desc_material, mat.nm_material, itens.fl_valor_variavel,  
case 
	when ds_itens is null then mat.nm_desc_material
    when ds_itens is not null then itens.ds_itens
end itenDescricao, mat.cd_elemento_despesa, mat.tp_material, itens.nr_lote, 
to_char(orItens.qt_itens_ordem, '9G999G990D9999') as qt_itens_ordem, to_char(orItens.vl_itens_ordem, '9G999G990D9999') as vl_itens_ordem ,
/* Inicio da sql que calcula o valor ultilado dos itens */
coalesce(
	(select 
    		case 
        when ((mat.tp_material = 'C' OR mat.tp_material = 'P') and itens.fl_valor_variavel = '0')
        then round(sum(entItens.qt_itens_entrega),4)
        when mat.tp_material is not null
        then round(sum((entItens.qt_itens_entrega * entItens.vl_itens_entrega)),4) 
        else '0.0000'
     end saldo
     from fin_entrega_itens as entItens
     inner join fin_ordem_itens as ordemItens
     on ordemItens.id_ordem_itens =  entItens.id_ordem_itens
     inner join fin_pre_ordem as preOrdem
     on preOrdem.id_pre_ordem = ordemItens.id_pre_ordem
     inner join fin_cont_itens as itens 
     on itens.id_cont_itens =  preOrdem.id_cont_itens
     inner join pla_material as mat
     on mat.id_material = itens.id_material
     where entItens.id_ordem_itens = orItens.id_ordem_itens
     group by mat.tp_material, itens.fl_valor_variavel
     ),'0.0000') as entregue,
 /* Fim da sql que calcula o valor ultilado dos itens */
 /* Inicio da sql que calcula o saldo dos itens */
    (case 
     when (mat.tp_material = 'C' OR mat.tp_material = 'P') and itens.fl_valor_variavel = '0'
     then round(orItens.qt_itens_ordem,4)
     when (mat.tp_material = 'S' OR itens.fl_valor_variavel = '1')
     then round((orItens.qt_itens_ordem * orItens.vl_itens_ordem),4)
     end 
     -
    coalesce((select 
				case 
                 when ((mat.tp_material = 'C' OR mat.tp_material = 'P') and itens.fl_valor_variavel = '0')
                 then round(sum(entItens.qt_itens_entrega),4)
                 when (mat.tp_material = 'S' OR itens.fl_valor_variavel = '1')
                 then round(sum((entItens.qt_itens_entrega * entItens.vl_itens_entrega)),4) 
                 else '0.0000'
    				 end saldo
    				 from fin_entrega_itens as entItens
                 inner join fin_ordem_itens as ordemItens
                 on ordemItens.id_ordem_itens =  entItens.id_ordem_itens
                 inner join fin_pre_ordem as preOrdem
                 on preOrdem.id_pre_ordem = ordemItens.id_pre_ordem
                 inner join fin_cont_itens as itens 
                 on itens.id_cont_itens =  preOrdem.id_cont_itens
                 inner join pla_material as mat
                 on mat.id_material = itens.id_material
                 where entItens.id_ordem_itens = orItens.id_ordem_itens
                 group by mat.tp_material, itens.fl_valor_variavel
               ),'0.0000')) as aguardandoentrega
/* Fim da sql que calcula o saldo dos itens */
from fin_ordem_itens as orItens
inner join fin_pre_ordem as pre
on pre.id_pre_ordem = orItens.id_pre_ordem
inner join fin_pedido as p
on p.id_pedido = pre.id_pedido
inner join fin_cont_itens as itens
on itens.id_cont_itens = pre.id_cont_itens
inner join pla_material as mat
on mat.id_material = itens.id_material
inner join pla_unidade_medida as um
on um.id_unidade_medida = itens.id_unidade_medida
where orItens.id_ordem = :ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function updateDataConfirmacao(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "update fin_entrega_confirmacao set dt_confirmacao = :dtConfirmacao where id_entrega_confirmacao = :entrega";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dtConfirmacao", $this->getDtConfirmacao(), PDO::PARAM_STR);
                $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaDados(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select * from fin_entrega_confirmacao where id_entrega_confirmacao = :entrega";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function verificaSerAEntregaTotal(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select * from fin_entrega_confirmacao where id_entrega_confirmacao = :entrega and sit_entrega = 2";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaUltimaDataEntrega(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select max(dt_entrega) from fin_entrega_confirmacao where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaNumeroEntregaConfirmacao(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select max(nr_entrega_confirmacao) as nr_entrega_confirmacao from fin_entrega_confirmacao where id_protocolo = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_OBJ);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    /**
     * Retorna as entregas confirmacao com a somatorias dos itens
     * @param PDO $pdo
     */
    public function retornaEntregaConfirmacao(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select entrega.id_entrega_confirmacao, entrega.nr_entrega_confirmacao, 
                        to_char(entrega.dt_entrega, 'dd/mm/YYYY') as dt_entrega,
                        to_char(entrega.dh_cadastramento, 'DD/MM/YYYY HH24:MI:SS') as dt_sistema,
                        case 
                                when entrega.sit_entrega = '1' then 'Entrega Parcial'
                                when entrega.sit_entrega = '2' then 'Entrega Total'
                        end tipo, 
                        round(sum((entItens.qt_itens_entrega * entItens.vl_itens_entrega)),4) as total
                        from fin_entrega_confirmacao as entrega
                        inner join fin_entrega_itens as entItens
                        on entItens.id_entrega_confirmacao = entrega.id_entrega_confirmacao
                        where entrega.id_ordem = :ordem
                        group by entrega.id_entrega_confirmacao
                        order by entrega.nr_entrega_confirmacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    /**
     * 
     * @param PDO $pdo
     */
    public function retornaSituacaoEntrega(PDO $pdo) {
        try {
            if ($pdo != null) {
                $sql = "select entregaItens.id_entrega_itens, confirmacao.nr_entrega_confirmacao, itens.nr_item, mat.cd_desc_material, 
                        mat.nm_material, to_char(confirmacao.dt_entrega, 'DD/MM/YYYY') as dt_entrega, 
                        to_char(confirmacao.dh_cadastramento, 'DD/MM/YYYY HH:MI:SS') as dh_cadastramento, mat.tp_material, 
                        itens.nr_lote, entregaItens.qt_itens_entrega, entregaItens.vl_itens_entrega, confirmacao.id_entrega_confirmacao,
                        
                        case 
                        when confirmacao.sit_entrega = 1 then 'Parcial'
                        when confirmacao.sit_entrega = 2 then 'Total'
                        end situacao,
                        
                        case 
                        when itens.ds_itens != '' then itens.ds_itens
                        else mat.nm_desc_material 
                        end descricao, 
                        
                        case 
                        when (mat.tp_material  = 'C' or mat.tp_material  = 'P') and itens.fl_valor_variavel = '0'
                                then entregaItens.qt_itens_entrega
                        when  mat.tp_material  = 'S' or itens.fl_valor_variavel = '1' then (entregaItens.qt_itens_entrega * entregaItens.vl_itens_entrega)
                        end entregue
                        
                        from fin_entrega_confirmacao as confirmacao
                        inner join fin_entrega_itens as entregaItens
                        on entregaItens.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao
                        inner join fin_ordem_itens as ordemItens 
                        on ordemItens.id_ordem_itens = entregaItens.id_ordem_itens
                        inner join fin_pre_ordem as preOrdem 
                        on preOrdem.id_pre_ordem = ordemItens.id_pre_ordem
                        inner join fin_cont_itens as itens 
                        on itens.id_cont_itens = preOrdem.id_cont_itens
                        inner join pla_material as mat
                        on mat.id_material = itens.id_material 
                        inner join view_despesa as despesa 
                        on despesa.id_despesa = mat.id_despesa
                        where confirmacao.id_ordem = :ordem
                        order by confirmacao.nr_entrega_confirmacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function removeEntregaConfirmacao(PDO $pdo) {
        try {
            $sql = "delete from fin_entrega_confirmacao where id_entrega_confirmacao  = :entrega";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function verificarUltimaEntrega(PDO $pdo) {
        try {
            $sql = "select * from fin_entrega_confirmacao where id_protocolo = :protocolo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function updateSitEntrega(PDO $pdo) {
        try {
            $sql = "update fin_entrega_confirmacao set sit_entrega = :situacao where id_entrega_confirmacao = :entrega";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":situacao", $this->getSitEntrega(), PDO::PARAM_INT);
            $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao(), PDO::PARAM_INT);
            $stmt->execute();
            $this->sucesso = true;
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaDadosOptionGdof(PDO $pdo, $idOrdens
    , string $sqlDocumentoExiste = null, int $idDocumentoFiscal = null, int $idDocSitCadastrado) {
        try {
            $sqlDocumentoFiscal = " AND (tramitacao.id_documento_situacao = :idDocumentoSituacao)";
            if (!empty($idDocumentoFiscal)) {
                $sqlDocumentoFiscal = $sqlDocumentoExiste;
            }
            $sql = "SELECT confirmacao.id_entrega_confirmacao, confirmacao.nr_entrega_confirmacao,
                    concat(concat(ordem.nr_ordem,'/'),ordem.aa_ordem) as ordem 
                    FROM fin_protocolo as protocolo
                    INNER JOIN fin_entrega_confirmacao as confirmacao
                    ON protocolo.id_protocolo = confirmacao.id_protocolo
                    INNER JOIN fin_ordem as ordem
                    ON confirmacao.id_ordem = ordem.id_ordem
                    LEFT JOIN ( SELECT DISTINCT ON (id_entrega_confirmacao) *
                        FROM fin_entrega_documento
                        ORDER BY id_entrega_confirmacao, id_entrega_documento desc 
                    ) AS entDoc ON entDoc.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao                    
                    LEFT JOIN ( select DISTINCT ON (t.id_documento_fiscal) *
                            FROM fin_doc_tramitacao t				
                            ORDER BY t.id_documento_fiscal, t.dh_doc_tramitacao desc, t.fl_pesquisa asc) AS tramitacao 
                    ON tramitacao.id_documento_fiscal = entDoc.id_documento_fiscal
                    WHERE protocolo.id_ordem in(" . $idOrdens . ")";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaEntregaGdof(PDO $pdo, $idEntrega) {
        try {
            $sql = "SELECT confirmacao.id_entrega_confirmacao, confirmacao.nr_entrega_confirmacao,
                    concat(concat(ordem.nr_ordem,'/'),ordem.aa_ordem) as ordem, 
                    to_char(protocolo.dh_recebimento, 'DD/MM/YYYY') as dataaviso,
                    to_char(protocolo.dt_entrega, 'DD/MM/YYYY') as datalimite, ordem.nr_prazo_ordem,
                    to_char(confirmacao.dt_entrega, 'DD/MM/YYYY') as entreguedia,
                    sum(item.vl_itens_entrega * item.qt_itens_entrega) as valor, ordem.id_ordem,
                   
                    (sum(item.vl_itens_entrega * item.qt_itens_entrega) 
					-
					(select COALESCE(sum(entDocumento.vl_entrega_documento),'0.0000') 
					 from fin_entrega_documento as entDocumento
                                         inner join fin_documento_fiscal as documento
                                         on documento.id_documento_fiscal = entDocumento.id_documento_fiscal
					 where entDocumento.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao
                                         and documento.id_documento_situacao <> 7
				    )) as saldo ,
                    case 
                    when confirmacao.sit_entrega = '1' then 'Entrega Parcial'
                    when confirmacao.sit_entrega = '2' then 'Entrega Total'
                    end situacao
                    from fin_protocolo as protocolo
                    inner join fin_entrega_confirmacao as confirmacao
                    on protocolo.id_protocolo = confirmacao.id_protocolo
                    inner join fin_ordem as ordem
                    on confirmacao.id_ordem = ordem.id_ordem
                    inner join fin_entrega_itens as item
                    on item.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao
                    where confirmacao.id_entrega_confirmacao in(" . $idEntrega . ")
                    group by confirmacao.id_entrega_confirmacao, protocolo.id_protocolo, ordem.id_ordem
                    order by concat(concat(ordem.nr_ordem,'/'),ordem.aa_ordem), confirmacao.nr_entrega_confirmacao";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    /**
     * Passando um conjunto de Id Entrega Confirmação, irá ser verifica e retornado quais delas podem
     * ser utilizadas para cadastro no documento fiscal
     * @param PDO $pdo
     * @param string $idsEntregas
     * @param int $idDocSitCadastrado
     */
    public function verificaEntregasAptasParaDocFiscal(PDO $pdo, string $idsEntregas, int $idDocSitCancelado) {
        try {

            $sql = "SELECT confirmacao.id_entrega_confirmacao
                    FROM fin_entrega_confirmacao as confirmacao
                    LEFT JOIN ( SELECT DISTINCT ON (id_entrega_confirmacao) *
                    FROM fin_entrega_documento
                    ORDER BY id_entrega_confirmacao, id_entrega_documento desc 
                    ) AS entDoc ON entDoc.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao                    
                    LEFT JOIN ( select DISTINCT ON (t.id_documento_fiscal) *
                        FROM fin_doc_tramitacao t				
                        ORDER BY t.id_documento_fiscal, t.dh_doc_tramitacao desc, t.fl_pesquisa asc) AS tramitacao 
                    ON tramitacao.id_documento_fiscal = entDoc.id_documento_fiscal
                    WHERE confirmacao.id_entrega_confirmacao IN (" . $idsEntregas . ") AND
                    (entDoc.id_documento_fiscal IS NULL OR tramitacao.id_documento_situacao = :idDocumentoSituacao)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idDocumentoSituacao", $idDocSitCancelado, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = true;
                $this->msgRetorno = array();
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
