<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/orcamento/empenho/FinEmpenhoTb.class.php";

class DaoFinEmpenho extends FinEmpenhoTb {

    private $sucesso = false;
    private $msgRetorno = null;

    public function __construct() {
        
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

    /**
     * Retorna os pedido de necessidade que nao possue empenho
     * @param PDO $pdo
     * @param type $condicao
     */
    public function retornaPedidoParaEmpenho(PDO $pdo = null, $condicao = '') {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT
                            Concat(Concat(Concat(p.id_lotacao, '-'), Concat(p.nr_pedido, '/')), To_char(p.dt_pedido, 'yyyy')) AS numero,
                            p.ds_pedido,
                            tp.nm_tipo_gasto,
                            font.nr_fonte,
                            desp.cd_despesa_elemento,
                            p.vl_pedido,
                            To_char(aut.dt_autorizacao, 'DD/MM/YYYY HH24:MI:SS') AS dt_aut_ordenador,
                            p.id_pedido,
                            (
                               SELECT
                                  To_char(pab.dh_pedido_anotacao, 'DD/MM/YYYY HH24:MI:SS') || ' - ' || sp.nm_pessoa || ': ' || pab.ds_pedido_anotacao 
                               from
                                  fin_pedido_anotacao pab,
                                  ses_pessoa sp 
                               WHERE
                                  pab.id_pedido = p.id_pedido 
                                  AND pab.id_pessoa = sp.id_pessoa 
                               ORDER BY
                                  pab.id_pedido_anotacao DESC limit 1
                            )
                            AS ds_pedido_anotacao 
                         FROM
                            fin_pedido AS p 
                            inner join
                               pla_tipo_gasto AS tp 
                               ON tp.id_tipo_gasto = p.id_tipo_gasto 
                            inner join
                               fin_fonte AS font 
                               ON font.id_fonte = p.id_fonte 
                            inner join
                               view_despesa_elemento AS desp 
                               ON desp.id_despesa_elemento = p.id_despesa_elemento 
                            left join
                               fin_autorizacao aut 
                               ON aut.id_pedido = p.id_pedido 
                               AND aut.st_nivel = 14 
                         WHERE
                            p.st_pedido = '15' 
                            AND p.id_pedido NOT IN 
                            (
                               SELECT
                                  emp.id_pedido 
                               FROM
                                  fin_empenho AS emp
                            )
                          " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * retorna os tipos do empenho
     * @param PDO $pdo
     */
    public function retornaTipoEmpenho(PDO $pdo = null) {
        try {
            $sql = "select emp.id_tipo_empenho, emp.nm_tipo_empenho
                    from fin_tipo_empenho as emp
                    where emp.sit_tipo_empenho = '1'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * retorna todos empenhos
     * @param PDO $pdo
     */
    public function retornaTodosEmpenhos(PDO $pdo = null) {
        try {
            $sql = "SELECT concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as nr_pedido, 
                    emp.id_empenho, empTipo.nm_tipo_empenho, emp.nr_empenho, l.nm_lotacao, emp.dh_empenho_sistema, emp.dt_empenho_safira, 
                    emp.vl_empenho, emp.ds_empenho, emp.sit_empenho, tpGasto.nm_tipo_gasto
                    FROM fin_empenho as emp
                    inner join fin_tipo_empenho as empTipo
                    on empTipo.id_tipo_empenho = emp.id_tipo_empenho
                    inner join fin_pedido as p
                    on p.id_pedido = emp.id_pedido
                    inner join ses_lotacao as l
                    on l.id_lotacao = p.id_lotacao
                    inner join pla_tipo_gasto as tpGasto
                    on tpGasto.id_tipo_gasto = p.id_tipo_gasto
                    where to_char(now(),'yyyy') = to_char(p.dt_pedido, 'yyyy')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * Retorna os dados para tela de empenho 
     * @param PDO $pdo
     */
    public function retornaInfPedidoEmpenho(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as numero,
                        to_char(p.dt_pedido, 'DD/MM/YYYY HH24:MI:SS') as dataPedido, l.nm_lotacao, tpGasto.id_tipo_gasto,
                        tpGasto.nm_tipo_gasto, cont.nr_contrato, font.nr_fonte, pt.cd_programa_trabalho,  pt.ds_programa_trabalho, 
                        desp.cd_despesa, desp.ds_despesa, p.ds_pedido, mat.nm_material, mat.nm_desc_material, item.ds_itens, mat.tp_material, 
                        item.nr_lote, pre.qt_itens_pre, pre.vl_itens_pre, cont.tp_contrato, pre.vl_total as total, 
                        p.id_pedido,p.id_fonte, p.id_programa_trabalho, p.id_despesa_elemento, item.nr_item, unid.nm_unidade_medida, mat.cd_desc_material,
                        p.vl_pedido, pj.nm_pessoa, gco.cd_pregao, mod.nm_modalidade, cont.dt_ini_vigencia_contrato, cont.dt_fim_vigencia_contrato, p.st_pedido
                        from fin_pedido as p
                        inner join pla_tipo_gasto as tpGasto
                        on tpGasto.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_fonte as font
                        on font.id_fonte = p.id_fonte
                        inner join fin_programa_trabalho as pt
                        on pt.id_programa_trabalho = p.id_programa_trabalho
                        inner join view_despesa as desp
                        on desp.id_despesa = p.id_despesa
                        inner join ses_lotacao as l
                        on l.id_lotacao = p.id_lotacao
                        left join fin_pre_ordem as pre
                        on pre.id_pedido = p.id_pedido
                        left join fin_cont_itens as item
                        on item.id_cont_itens = pre.id_cont_itens 
                        left join pla_material as mat
                        on mat.id_material = item.id_material
                        left join pla_unidade_medida as unid
                        on unid.id_unidade_medida = item.id_unidade_medida
                        left join fin_fornecedor  as f
                        on f.id_fornecedor = p.id_fornecedor
                        left join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato
                        left join gco_processo as gco
                        on gco.id_processo = cont.id_processo
                        left join gco_modalidade as mod
                        on mod.id_modalidade = gco.id_modalidade
                        left join ses_pessoa as pj
                        on pj.id_pessoa = f.id_pessoa
                        where p.id_pedido = :pedido
                        order by item.nr_lote, item.nr_item";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * Metodo responsavel por verificar ser um empenho ja foi cadastrada atraves do seu numero
     * @param PDO $pdo
     */
    public function verificarEmpenhoPeloNumero(PDO $pdo = null) {
        try {
            $sql = "select emp.id_empenho from fin_empenho as emp
                    where emp.nr_empenho = :numero and emp.sit_empenho <> '6'";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":numero", $this->getNrEmpenho(), PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    /**
     * Metodo responsavel por salva o empenho no banco de dados
     * @param PDO $pdo
     */
    public function insertEmpenho(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_empenho (id_pedido, id_pessoa, id_tipo_empenho, nr_empenho, dt_empenho_safira,
                        vl_empenho, ds_empenho) values (:pedido, :pessoa, :tpEmp, :nrEmp, :dtEmp, :vlEmp, :dsEmp)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":tpEmp", $this->getIdTipoEmpenho(), PDO::PARAM_INT);
                $stmt->bindValue(":nrEmp", $this->getNrEmpenho(), PDO::PARAM_STR);
                $stmt->bindValue(":dtEmp", $this->getDtEmpenhoSafira(), PDO::PARAM_STR);
                $stmt->bindValue(":vlEmp", $this->getVlEmpenho(), PDO::PARAM_STR);
                $stmt->bindValue(":dsEmp", $this->getDsEmpenho(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function updateStPedidoEmpenho(PDO $pdo, int $stPedido = 0) {
        try {
            if (!empty($pdo) && !empty($stPedido)) {
                $sql = "UPDATE fin_pedido SET st_pedido = '" . $stPedido . "' where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function updateValorEmpenho(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "UPDATE fin_empenho SET vl_empenho = :vl_empenho where id_empenho = :id_empenho";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->bindValue(":vl_empenho", $this->getVlEmpenho(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaEmpenhoGdof(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            emp.id_pedido,
                            --emp.nr_empenho,
                            concat(substr(nr_empenho, 1, ((LENGTH(nr_empenho)-4)) ), '/',  substring(nr_empenho FROM '....$')) as nr_empenho,
                            emp.id_empenho,
                            to_char(emp.dt_empenho_safira, 'DD/MM/YYYY') as dataEmpenho,
                            tpEmp.nm_tipo_empenho,
                            emp.vl_empenho,
                            (emp.vl_empenho -
                            coalesce((
                                select sum(vl_documento) 
                                from                     
                                    fin_pedido p
                                inner join fin_documento_fiscal docFis on docFis.id_pedido = p.id_pedido                              
                                where
                                    p.id_pedido = emp.id_pedido
                                    and docFis.id_documento_situacao <> 7 
                                    ), 0)
                            ) as saldo_empenho_gdof 

                         from
                            fin_empenho as emp 
                            inner join
                               fin_tipo_empenho as tpEmp 
                               on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                         where
                            id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaEmpenhoPagamento(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select emp.id_pedido, emp.nr_empenho,emp.id_empenho, to_char(emp.dt_empenho_safira, 'DD/MM/YYYY') as dataEmpenho,
                        tpEmp.nm_tipo_empenho, emp.vl_empenho,
                        (emp.vl_empenho -
                         coalesce((select sum(vl_pagamento) 
                                   from con_pagamento as pagamento 
                                   inner join con_liquidacao as liquidacao
                                   on liquidacao.id_liquidacao = pagamento.id_liquidacao
                                   where liquidacao.id_empenho = emp.id_empenho
                                   ),0)) as saldo_empenho_pagamento

                        from fin_empenho as emp 
                        inner join fin_tipo_empenho as tpEmp 
                        on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                        where emp.id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaEmpenhoLiquidacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            --emp.nr_empenho,
                            concat(substr(nr_empenho, 1, ((LENGTH(nr_empenho)-4)) ), '/',  substring(nr_empenho FROM '....$')) as nr_empenho,
                            emp.id_empenho,
                            to_char(emp.dt_empenho_safira, 'DD/MM/YYYY') as dataEmpenho,
                            tpEmp.nm_tipo_empenho,
                            emp.vl_empenho,
                            (emp.vl_empenho - (
                               select
                                  coalesce(sum(vl_liquidacao),0) 
                               from
                                  con_liquidacao liq
                               where
                                  liq.id_empenho = emp.id_empenho 
                                  and liq.id_liquidacao_situacao <> 4
                            ))
                            as saldo_empenho_liquidacao 
                         from
                            fin_empenho as emp 
                            inner join
                               fin_tipo_empenho as tpEmp 
                               on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                         where
                            id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    

      public function retornaEmpenhoAnulacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
//                $sql = "select concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/', substring(emp.nr_empenho from '....$')) as nr_empenho,
//                        emp.id_empenho                        
//                        ,	to_char(emp.dt_empenho_safira,'DD/MM/YYYY') as dataEmpenho,tpEmp.nm_tipo_empenho,emp.vl_empenho,
//                        (emp.vl_empenho - ROUND(sum(coalesce(ordemItens.total,'0.0000') + coalesce(entregas.total,'0.0000')),4)) as saldo
//                        from fin_pedido as pedido
//
//                        inner join fin_empenho as emp
//                        on emp.id_pedido = pedido.id_pedido
//                        inner join fin_tipo_empenho as tpEmp
//                        on tpEmp.id_tipo_empenho = emp.id_tipo_empenho
//                        inner join fin_pre_ordem as pre 
//                        on	pedido.id_pedido = pre.id_pedido
//                        inner join fin_cont_itens as itens 
//                        on	itens.id_cont_itens = pre.id_cont_itens
//                        inner join pla_material as mat 
//                        on	mat.id_material = itens.id_material
//                        inner join view_despesa as desp 
//                        on	desp.id_despesa = mat.id_despesa
//                        inner join pla_unidade_medida as unid 
//                        on	unid.id_unidade_medida = itens.id_unidade_medida                        
//                        left join (
//                                select
//                                        sum(itens.qt_itens_ordem) as qt_itens_ordem,
//                                        sum(itens.qt_itens_ordem * itens.vl_itens_ordem) as total,
//                                        itens.id_pre_ordem
//                                from
//                                        fin_ordem as ordem
//                                inner join fin_ordem_itens as itens 
//                                on	ordem.id_ordem = itens.id_ordem
//                                where
//                                        ordem.sit_ordem > '0'
//                                        and ordem.sit_ordem < '3'
//                                group by
//                                        itens.id_pre_ordem ) as ordemItens 
//                        on	ordemItens.id_pre_ordem = pre.id_pre_ordem
//                        left join (
//                                select
//                                        sum(itens.qt_itens_entrega)as qt_itens_entrega,
//                                        sum(itens.qt_itens_entrega * itens.vl_itens_entrega) as total,
//                                        ordemItens.id_pre_ordem
//                                from
//                                        fin_pedido as pedido
//                                inner join fin_ordem as ordem 
//                                on	ordem.id_pedido = pedido.id_pedido
//
//                                inner join fin_ordem_itens as ordemItens on
//                                        ordemItens.id_ordem = ordem.id_ordem
//                                inner join fin_entrega_confirmacao as confirmacao on
//                                        confirmacao.id_ordem = ordem.id_ordem
//                                inner join fin_entrega_itens as itens on
//                                        itens.id_ordem_itens = ordemItens.id_ordem_itens
//                                where
//                                        ordem.sit_ordem > '2'
//                                        and confirmacao.sit_entrega > '0'
//                                group by
//                                        ordemItens.id_pre_ordem ) as entregas 
//                        on	entregas.id_pre_ordem = pre.id_pre_ordem
//                        where	pedido.id_pedido = :pedido
//                        group by emp.nr_empenho, emp.vl_empenho, emp.id_empenho, tpEmp.nm_tipo_empenho,	emp.vl_empenho";
                
                $sql = "SELECT concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/', substring(emp.nr_empenho from '....$')) as nr_empenho
                            , emp.id_empenho ,pedido.id_pedido, pedido.nr_pedido
                            , fonte.nr_fonte, DESPESA.cd_despesa_elemento AS cd_despesa_elemento, SALDO.saldo
                            , to_char(emp.dt_empenho_safira,'DD/MM/YYYY') as dataEmpenho, tpEmp.nm_tipo_empenho, emp.vl_empenho
                            FROM fin_pedido AS pedido
                            INNER JOIN fin_empenho AS emp
                            ON emp.id_pedido = pedido.id_pedido
                            INNER JOIN fin_tipo_empenho AS tpEmp
                            ON tpEmp.id_tipo_empenho = emp.id_tipo_empenho
                            INNER JOIN (
                                SELECT DISTINCT ON (PO.id_pedido) PO.id_pedido, DESP.cd_despesa as cd_despesa_elemento
                                FROM fin_pre_ordem PO 
                                INNER JOIN fin_cont_itens CI ON CI.id_cont_itens = PO.id_cont_itens
                                INNER JOIN pla_material M ON M.id_material = CI.id_material
                                INNER JOIN view_despesa DESP ON DESP.id_despesa = M.id_despesa    	
                            ) AS DESPESA ON DESPESA.id_pedido = pedido.id_pedido           
                            INNER JOIN fin_fonte AS fonte 
                            ON fonte.id_fonte = pedido.id_fonte
                            INNER JOIN (
                                SELECT sum(saldo) AS saldo, id_pedido
                                FROM view_pedido_saldo
                                GROUP BY id_pedido    	    	
                            ) AS SALDO ON SALDO.id_pedido = pedido.id_pedido
                            WHERE pedido.id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function buscaEmpenhoPesquisaLiquidacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT p.id_pedido, p.nr_pedido, emp.id_empenho, emp.nr_empenho,
                        emp.dt_empenho_safira, emp.vl_empenho
                        , TE.nm_tipo_empenho, F.nr_fonte, DE.cd_despesa_elemento
                        , (emp.vl_empenho - coalesce((select sum(vl_liquidacao) from con_liquidacao liq where liq.id_empenho = emp.id_empenho and liq.id_liquidacao_situacao <> 4),0)) as saldo
                        FROM fin_empenho AS emp
                        INNER JOIN fin_pedido AS p
                            ON p.id_pedido = emp.id_pedido
                        INNER JOIN fin_tipo_empenho TE 
                            ON TE.id_tipo_empenho = emp.id_tipo_empenho
                        INNER JOIN fin_fonte F 
                            ON F.id_fonte = p.id_fonte
                        INNER JOIN view_despesa_elemento DE 
                            ON DE.id_despesa_elemento = p.id_despesa_elemento
                        WHERE emp.nr_empenho = :nr_empenho";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nr_empenho", $this->getNrEmpenho(), PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function buscaEmpenhoPesquisaAnulacaoEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
//                $sql = "SELECT p.id_pedido, p.nr_pedido, emp.id_empenho, emp.nr_empenho,
//                        emp.dt_empenho_safira, emp.vl_empenho
//                        , TE.nm_tipo_empenho, F.nr_fonte, DE.cd_despesa_elemento
//                        , (emp.vl_empenho - coalesce((select sum(vl_liquidacao) from con_liquidacao liq where liq.id_empenho = emp.id_empenho and liq.id_liquidacao_situacao <> 4),0)) as saldo
//                        FROM fin_empenho AS emp
//                        INNER JOIN fin_pedido AS p
//                            ON p.id_pedido = emp.id_pedido
//                        INNER JOIN fin_tipo_empenho TE 
//                            ON TE.id_tipo_empenho = emp.id_tipo_empenho
//                        INNER JOIN fin_fonte F 
//                            ON F.id_fonte = p.id_fonte
//                        INNER JOIN view_despesa_elemento DE 
//                            ON DE.id_despesa_elemento = p.id_despesa_elemento
//                        WHERE emp.nr_empenho = :nr_empenho";
                
//                $sql = "select concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/', substring(emp.nr_empenho from '....$')) as nr_empenho,
//                        emp.id_empenho , pedido.id_pedido, pedido.nr_pedido
//                        , fonte.nr_fonte, desp.cd_despesa as cd_despesa_elemento
//                        , to_char(emp.dt_empenho_safira,'DD/MM/YYYY') as dataEmpenho,tpEmp.nm_tipo_empenho,emp.vl_empenho,
//                        (emp.vl_empenho - ROUND(sum(coalesce(ordemItens.total,'0.0000') + coalesce(entregas.total,'0.0000')),4)) as saldo
//                        from fin_pedido as pedido
//
//                        inner join fin_empenho as emp
//                        on emp.id_pedido = pedido.id_pedido
//                        inner join fin_tipo_empenho as tpEmp
//                        on tpEmp.id_tipo_empenho = emp.id_tipo_empenho
//                        inner join fin_pre_ordem as pre 
//                        on	pedido.id_pedido = pre.id_pedido
//                        inner join fin_cont_itens as itens 
//                        on	itens.id_cont_itens = pre.id_cont_itens
//                        inner join pla_material as mat 
//                        on	mat.id_material = itens.id_material
//                        inner join view_despesa as desp 
//                        on	desp.id_despesa = mat.id_despesa
//                        inner join pla_unidade_medida as unid 
//                        on	unid.id_unidade_medida = itens.id_unidade_medida    
//                        inner join fin_fonte as fonte 
//                        on fonte.id_fonte = pedido.id_fonte
//                        left join (
//                                select
//                                        sum(itens.qt_itens_ordem) as qt_itens_ordem,
//                                        sum(itens.qt_itens_ordem * itens.vl_itens_ordem) as total,
//                                        itens.id_pre_ordem
//                                from
//                                        fin_ordem as ordem
//                                inner join fin_ordem_itens as itens 
//                                on	ordem.id_ordem = itens.id_ordem
//                                where
//                                        ordem.sit_ordem > '0'
//                                        and ordem.sit_ordem < '3'
//                                group by
//                                        itens.id_pre_ordem ) as ordemItens 
//                        on	ordemItens.id_pre_ordem = pre.id_pre_ordem
//                        left join (
//                                select
//                                        sum(itens.qt_itens_entrega)as qt_itens_entrega,
//                                        sum(itens.qt_itens_entrega * itens.vl_itens_entrega) as total,
//                                        ordemItens.id_pre_ordem
//                                from
//                                        fin_pedido as pedido
//                                inner join fin_ordem as ordem 
//                                on	ordem.id_pedido = pedido.id_pedido
//
//                                inner join fin_ordem_itens as ordemItens on
//                                        ordemItens.id_ordem = ordem.id_ordem
//                                inner join fin_entrega_confirmacao as confirmacao on
//                                        confirmacao.id_ordem = ordem.id_ordem
//                                inner join fin_entrega_itens as itens on
//                                        itens.id_ordem_itens = ordemItens.id_ordem_itens
//                                where
//                                        ordem.sit_ordem > '2'
//                                        and confirmacao.sit_entrega > '0'
//                                group by
//                                        ordemItens.id_pre_ordem ) as entregas 
//                        on	entregas.id_pre_ordem = pre.id_pre_ordem
//                        --where	pedido.id_pedido = :pedido
//                        where emp.nr_empenho = :nr_empenho
//                        group by emp.nr_empenho, emp.vl_empenho, emp.id_empenho, tpEmp.nm_tipo_empenho
//                        , emp.vl_empenho, fonte.id_fonte, desp.cd_despesa, pedido.id_pedido";
                
                
                $sql = "SELECT concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/', substring(emp.nr_empenho from '....$')) as nr_empenho
                            , emp.id_empenho ,pedido.id_pedido, pedido.nr_pedido
                            , fonte.nr_fonte, DESPESA.cd_despesa_elemento AS cd_despesa_elemento, SALDO.saldo
                            , to_char(emp.dt_empenho_safira,'DD/MM/YYYY') as dataEmpenho, tpEmp.nm_tipo_empenho, emp.vl_empenho
                            FROM fin_pedido AS pedido
                            INNER JOIN fin_empenho AS emp
                            ON emp.id_pedido = pedido.id_pedido
                            INNER JOIN fin_tipo_empenho AS tpEmp
                            ON tpEmp.id_tipo_empenho = emp.id_tipo_empenho
                            INNER JOIN (
                                SELECT DISTINCT ON (PO.id_pedido) PO.id_pedido, DESP.cd_despesa as cd_despesa_elemento
                                FROM fin_pre_ordem PO 
                                INNER JOIN fin_cont_itens CI ON CI.id_cont_itens = PO.id_cont_itens
                                INNER JOIN pla_material M ON M.id_material = CI.id_material
                                INNER JOIN view_despesa DESP ON DESP.id_despesa = M.id_despesa    	
                            ) AS DESPESA ON DESPESA.id_pedido = pedido.id_pedido           
                            INNER JOIN fin_fonte AS fonte 
                            ON fonte.id_fonte = pedido.id_fonte
                            INNER JOIN (
                                SELECT sum(saldo) AS saldo, id_pedido
                                FROM view_pedido_saldo
                                GROUP BY id_pedido    	    	
                            ) AS SALDO ON SALDO.id_pedido = pedido.id_pedido
                            WHERE emp.nr_empenho = :nr_empenho";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nr_empenho", $this->getNrEmpenho(), PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaDadosEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_empenho where id_empenho = :idEmpenho";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idEmpenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function retornaDadosEmpenhoPorPedido(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_empenho where id_pedido = :idPedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idPedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function atualizaSituacaoStatusEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_empenho set sit_empenho = :sit_empenho, id_empenho_status = :id_empenho_status where id_empenho = :id_empenho";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":sit_empenho", $this->getSitEmpenho(), PDO::PARAM_STR);
                $stmt->bindValue(":id_empenho_status", $this->getIdEmpenhoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaDadosPedidoPeloEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select pedido.* "
                        . "from fin_empenho empenho, fin_pedido pedido "
                        . "where pedido.id_pedido = empenho.id_pedido "
                        . "and empenho.id_empenho = :id_empenho";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaTotalLiquidadoDoEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select coalesce(sum(vl_liquidacao),0) as total_liquidado from con_liquidacao where id_empenho = :idEmpenho and id_liquidacao_situacao <> 4";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idEmpenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaEmpenhos(PDO $pdo, array $filtroSql = []){
        $str_filtro = '';
        if (!empty($filtroSql)) {
            foreach ($filtroSql as $filtro) {
                $str_filtro .= $filtro['sql'];
            }
        }
        
        $this->sucesso = false;
        $sql = "select
                    emp.id_empenho,
                    (substr(emp.nr_empenho,1,10) || '/' || substr(emp.nr_empenho,11,4))  as nr_empenho,
                    ped.nr_pedido,
                    coalesce(pf.nr_cpf, pj.nr_cnpj, '') as cpf_cnpj,
                    coalesce(upper(pf.nm_civil), upper(pj.nm_fantasia),'') as nome_razao,
                    tpEmp.nm_tipo_empenho,
                    to_char(dt_empenho_safira, 'dd/mm/yyyy') as dt_empenho_safira,
                    tpGasto.nm_tipo_gasto,
                    central.nm_lotacao as central_demanda,
                    trim(to_char(vl_empenho,'999G999G999G990D9999')) as vl_empenho,
                    case sit_empenho 
                         when '1' then 'Cadastrado'
                         when '2' then 'Liquidado Parcial'
                         when '3' then 'Liquidado Total'
                         when '4' then 'Pago Parcial'
                         when '5' then 'Pago Total'
                         when '6' then 'Cancelado'
                    end as situacao
                    , sit_empenho
                 from
                    fin_empenho emp 
                    inner join
                       fin_tipo_empenho tpEmp 
                       on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                    inner join
                       fin_pedido ped 
                       on ped.id_pedido = emp.id_pedido
                    inner join
                        ses_lotacao central
                        on central.id_lotacao = ped.id_lotacao
                    left join
                       fin_fornecedor fornec 
                       on fornec.id_fornecedor = ped.id_fornecedor 
                    left join
                       fin_contrato cnt 
                       on cnt.id_contrato = fornec.id_contrato 
                    left join
                       pla_tipo_gasto tpGasto 
                       on tpGasto.id_tipo_gasto = ped.id_tipo_gasto 
                    left join
                       ses_pessoa_fisica pf 
                       on pf.id_pessoa = fornec.id_pessoa 
                    left join
                       ses_pessoa_juridica pj 
                       on pj.id_pessoa = fornec.id_pessoa ". $str_filtro ."
                 order by dt_empenho_safira desc,nr_empenho, nr_pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                
                if (!empty($filtroSql)) {
                    foreach ($filtroSql as $filtro) {
                        $stmt->bindValue($filtro['bind'], $filtro['valor'], $filtro['pdo_param']);
                    }
                }
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado.';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    
    public function verificaExisteOrdemDocumentoLiquidacao(PDO $pdo = null) {
        try {
            $sql = "SELECT distinct on (E.id_empenho) E.id_empenho, O.id_ordem, DF.id_documento_fiscal, L.id_liquidacao"
                    . " FROM fin_empenho E"
                    . " LEFT JOIN fin_ordem O ON O.id_pedido = E.id_pedido AND O.sit_ordem <> '0'"
                    . " LEFT JOIN fin_documento_fiscal DF ON DF.id_pedido = E.id_pedido AND DF.id_documento_situacao <> 7"
                    . " LEFT JOIN con_liquidacao L ON L.id_empenho = E.id_empenho AND L.id_liquidacao_situacao <> 4"
                    . " WHERE E.id_empenho = :idEmpenho"
                    . " AND ("
                    . " O.id_ordem IS NOT NULL "
                    . " OR DF.id_documento_fiscal IS NOT NULL"
                    . " OR L.id_liquidacao IS NOT NULL"
                    . " )";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":idEmpenho", $this->getIdEmpenho(), PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
                $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
            $this->sucesso = true;
            $this->msgRetorno = $ex->getMessage();
        }
    }
}
