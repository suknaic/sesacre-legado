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
        } catch (PDOException $ex) {
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
        } catch (PDOException $ex) {
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
        } catch (PDOException $ex) {
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
        } catch (PDOException $ex) {
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
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    /**
     * Metodo responsavel por verificar se o número do empenho já existe para atualização
     * @param PDO $pdo
     */
    public function verificarEmpenhoPeloNumeroUpdate(PDO $pdo = null) {
        try {
            $sql = "select emp.id_empenho from fin_empenho as emp
                    where emp.nr_empenho = :numero and emp.sit_empenho <> '6' and emp.id_empenho <> :empenho";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":numero", $this->getNrEmpenho(), PDO::PARAM_STR);
            $stmt->bindValue(":empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (PDOException $ex) {
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
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function updateEmpenho(PDO $pdo = null) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "update
                    fin_empenho 
                 set
                    id_pessoa = :id_pessoa, id_tipo_empenho = :id_tipo_empenho, nr_empenho = :nr_empenho, dt_empenho_safira = :dt_empenho_safira, vl_empenho = :vl_empenho ,ds_empenho = :ds_empenho 
                 where
                    id_empenho = :id_empenho";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_tipo_empenho", $this->getIdTipoEmpenho(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_empenho", $this->getNrEmpenho(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_empenho_safira", $this->getDtEmpenhoSafira(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_empenho", $this->getVlEmpenho(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_empenho", $this->getDsEmpenho(), PDO::PARAM_STR);
                $stmt->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
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
        } catch (PDOException $exc) {
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
        } catch (PDOException $exc) {
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
                $sql = "select emp.id_pedido, emp.id_empenho, to_char(emp.dt_empenho_safira, 'DD/MM/YYYY') as dataEmpenho,
                        tpEmp.nm_tipo_empenho, emp.vl_empenho,
                        concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/',  substring(emp.nr_empenho FROM '....$')) as nr_empenho,
                        (emp.vl_empenho -
                         coalesce((select sum(vl_pagamento) 
                                   from con_pagamento as pagamento 
                                   inner join con_liquidacao as liquidacao
                                   on liquidacao.id_liquidacao = pagamento.id_liquidacao
                                   where liquidacao.id_empenho = emp.id_empenho
                                   and pagamento.id_pagamento_situacao = 1
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
                            id_pedido = :pedido and emp.sit_empenho <> '6'";
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
    

      public function retornaEmpenhoAnulacao(PDO $pdo) {
        try {
            if (!empty($pdo)) {
               
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
        } catch (PDOException $exc) {
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
                        WHERE emp.nr_empenho = :nr_empenho and emp.sit_empenho <> '6'";
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
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function buscaEmpenhoPesquisaAnulacaoEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
               
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
                            WHERE emp.nr_empenho = :nr_empenho and emp.sit_empenho <> '6'";
                
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
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaDadosEmpenho(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            tpEmp.nm_tipo_empenho,
                            emp.ds_empenho,
                            emp.id_empenho,
                            emp.id_pedido,
                            emp.id_tipo_empenho,
                            emp.sit_empenho,
                            to_char(emp.dt_empenho_safira, 'dd/mm/yyyy') as dt_empenho_safira,
                            trim(to_char(emp.vl_empenho, '999G999G999G990D9999')) as vl_empenho,
                            concat(substr(nr_empenho, 1, 
                            (
                         (LENGTH(nr_empenho) - 4) 
                            )
                         ), '/', substring(nr_empenho 
                         FROM
                            '....$')) as nr_empenho,
                            tp.vl_total,
                            ped.vl_pedido
                         from
                            fin_empenho emp 
                            LEFT JOIN
                               (
                                  SELECT
                                     sum(vl_total) AS vl_total,
                                     id_pedido 
                                  FROM
                                     fin_pre_ordem 
                                  GROUP BY
                                     id_pedido
                               )
                               AS TP 
                               ON TP.id_pedido = emp.id_pedido,
                               fin_tipo_empenho tpEmp,
                               fin_pedido ped
                         where
                            emp.id_tipo_empenho = tpEmp.id_tipo_empenho 
                            and emp.id_pedido = ped.id_pedido
                            and id_empenho = :idEmpenho";
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
    
    public function retorna(PDO $pdo) {
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
                    emp.nr_empenho as empenho_sm,
                    ( substr(emp.nr_empenho,
                    1,
                    10) || '/' || substr(emp.nr_empenho,
                    11,
                    4) ) as nr_empenho,
                    (ped.nr_pedido || '/' || to_char(ped.dt_pedido,'YYYY')) nr_pedido,
                    coalesce(pf.nr_cpf,
                    pj.nr_cnpj,
                    '') as cpf_cnpj,
                    coalesce(upper(pf.nm_civil),
                    upper(pj.nm_fantasia),
                    '') as nome_razao,
                    tpEmp.nm_tipo_empenho,
                    to_char(dt_empenho_safira,
                    'dd/mm/yyyy') as dt_empenho_safira,
                    tpGasto.nm_tipo_gasto,
                    central.nm_lotacao as central_demanda,
                    trim(to_char(vl_empenho, '999G999G999G990D9999')) as vl_empenho,
                    (emp.vl_empenho - coalesce(liqPag.vl_liquidacao,0)) as saldo_liquidar,
                    case
                        sit_empenho
                        when '1' then 'Cadastrado'
                        when '2' then 'Liquidado Parcial'
                        when '3' then 'Liquidado Total'
                        when '4' then 'Pago Parcial'
                        when '5' then 'Pago Total'
                        when '6' then 'Cancelado'
                    end as situacao ,
                    case
                        when ( sit_emp.id_liquidacao is null
                        and sit_emp.id_ordem is null
                        and sit_emp.id_documento_fiscal is null ) then 'S'
                        else 'N'
                    end as edita,
                    case
                    when (emp.vl_empenho - coalesce(liqPag.vl_liquidacao,0)) > 0
                        and (ped.id_tipo_solicitacao <> 2
                        or (ped.id_tipo_solicitacao = 2
                        and sit_emp.id_documento_situacao = 2 )) then 'S'
                        else 'N'
                    end as liquida
                from
                    fin_empenho emp
                inner join fin_tipo_empenho tpEmp on
                    tpEmp.id_tipo_empenho = emp.id_tipo_empenho
                inner join fin_pedido ped on
                    ped.id_pedido = emp.id_pedido
                inner join ses_lotacao central on
                    central.id_lotacao = ped.id_lotacao
                left join fin_fornecedor fornec on
                    fornec.id_fornecedor = ped.id_fornecedor
                left join fin_contrato cnt on
                    cnt.id_contrato = fornec.id_contrato
                left join pla_tipo_gasto tpGasto on
                    tpGasto.id_tipo_gasto = ped.id_tipo_gasto
                left join ses_pessoa_fisica pf on
                    pf.id_pessoa = fornec.id_pessoa
                left join ses_pessoa_juridica pj on
                    pj.id_pessoa = fornec.id_pessoa
                left join 
                    (
                        select id_empenho, sum(coalesce(vl_liquidacao,0)) as vl_liquidacao , sum(coalesce(vl_pagamento,0)) as vl_pagamento
                        from con_liquidacao liq
                        left join con_pagamento pag
                        on pag.id_liquidacao = liq.id_liquidacao
                        group by id_empenho
                    ) liqPag
                    on liqPag.id_empenho = emp.id_empenho
                left join (
                    select
                        distinct on
                        (E.id_empenho) E.id_empenho,
                        O.id_ordem,
                        DF.id_documento_fiscal,
                        DF.id_documento_situacao,
                        L.id_liquidacao
                    from
                        fin_empenho E
                    left join fin_ordem O on
                        O.id_pedido = E.id_pedido
                        and O.sit_ordem <> '0'
                    left join fin_documento_fiscal DF on
                        DF.id_pedido = E.id_pedido
                        and DF.id_documento_situacao <> 7
                    left join con_liquidacao L on
                        L.id_empenho = E.id_empenho
                        and L.id_liquidacao_situacao <> 4
                    where
                        ( O.id_ordem is not null
                        or DF.id_documento_fiscal is not null
                        or L.id_liquidacao is not null ) ) sit_emp on
                    sit_emp.id_empenho = emp.id_empenho
                    ".$str_filtro."
                            order by
                               dt_empenho_safira desc,
                               nr_empenho,
                               nr_pedido";
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
    
    public function retornaDadosEmpenhoPedido(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    p.nr_pedido,
                    p.id_lotacao,
                    central.nm_lotacao ,
                    p.ds_pedido,
                    f.nr_fonte,
                    p.id_tipo_solicitacao,
                    p.id_pedido,
                    programa.cd_programa_trabalho,
                    programa.ds_programa_trabalho,
                    despesa.cd_despesa,
                    despesa.ds_despesa,
                    tpSol.nm_tipo_solicitacao,
                    despesa_elemento.cd_despesa_elemento,
                    despesa_elemento.ds_despesa_elemento,
                    p.vl_pedido,
                    to_char(p.dt_pedido,
                    'yyyy') as ano,
                    pedido_saldo.saldo,
                    (emp.vl_empenho - coalesce(liqPag.vl_liquidacao,
                    0)) as saldo_liquidar,
                    (emp.vl_empenho - coalesce(liqPag.vl_pagamento,
                    0)) as saldo_pagar
                from
                        fin_empenho as emp
                inner join fin_pedido as p on
                    p.id_pedido = emp.id_pedido
                inner join fin_fonte as f on
                    f.id_fonte = p.id_fonte
                inner join view_programa_trabalho as programa on
                    programa.id_programa_trabalho = p.id_programa_trabalho
                inner join ses_lotacao as central on
                    central.id_lotacao = p.id_lotacao
                inner join view_despesa as despesa on
                    despesa.id_despesa = p.id_despesa
                inner join view_despesa_elemento as despesa_elemento on
                    despesa_elemento.id_despesa_elemento = p.id_despesa_elemento
                left join (
                    select
                        id_empenho,
                        sum(coalesce(vl_liquidacao, 0)) as vl_liquidacao ,
                        sum(coalesce(vl_pagamento, 0)) as vl_pagamento
                    from
                        con_liquidacao liq
                    left join con_pagamento pag on
                        pag.id_liquidacao = liq.id_liquidacao
                    group by
                        id_empenho ) liqPag on
                    liqPag.id_empenho = emp.id_empenho
                left join (
                    select
                        id_pedido,
                        sum(saldo) as saldo
                    from
                        view_pedido_saldo
                    group by
                        id_pedido ) as pedido_saldo on
                    pedido_saldo.id_pedido = p.id_pedido
                left join fin_tipo_solicitacao as tpSol on
                        tpSol.id_tipo_solicitacao = p.id_tipo_solicitacao
                where
                        emp.id_pedido = :pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosEmpenhoPedidoDiaria(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    diaria.id_diaria,
                    diaria.nr_protocolo,
                    pes_proponente.nm_pessoa as nm_proponente,
                    lot_proponente.nm_lotacao as lt_proponente,
                    fn_proponente.nm_funcao as fn_proponente,
                    pes_proposto.nm_pessoa as nm_proposto,
                    lot_proposto.nm_lotacao as lt_proposto,
                    fn_proposto.nm_funcao as fn_proposto,
                    cid_ini.nm_cidade as nm_cidade_origem,
                    est_ini.nm_sigla as uf_cidade_origem,
                    trim(to_char(dest.dh_inicio,'dd/mm/yyyy hh24:mi')) as dh_inicio,
                    cid_fim.nm_cidade as nm_cidade_destino,
                    est_fim.nm_sigla as uf_cidade_destino,
                    trim(to_char(dest.dh_fim,'dd/mm/yyyy hh24:mi')) as dh_fim,
                    dest.qt_diaria_destino,
                    dest.vl_diaria_destino
                 from
                    dia_diaria diaria,
                    dia_diaria_destino dest,
                    fin_empenho emp,
                    ses_lotacao lot_proponente,
                    ses_lotacao lot_proposto,
                    ses_pessoa pes_proponente,
                    ses_pessoa pes_proposto,
                    ses_funcao fn_proponente,
                    ses_funcao fn_proposto,
                    ses_cidade cid_ini,
                    ses_estado est_ini,
                    ses_cidade cid_fim,
                    ses_estado est_fim
                 where
                    diaria.id_pedido = emp.id_pedido 
                    and diaria.id_diaria = dest.id_diaria 
                    and diaria.id_lotacao_proponente = lot_proponente.id_lotacao 
                    and diaria.id_pessoa_proponente = pes_proponente.id_pessoa 
                    and diaria.id_funcao_proponente = fn_proponente.id_funcao 
                    and diaria.id_lotacao_proposto = lot_proposto.id_lotacao 
                    and diaria.id_pessoa_proposto = pes_proposto.id_pessoa 
                    and diaria.id_funcao_proposto = fn_proposto.id_funcao 
                    and dest.id_cidade_inicio = cid_ini.id_cidade 
                    and dest.id_cidade_fim = cid_fim.id_cidade 
                    and cid_ini.id_estado = est_ini.id_estado
                    and cid_fim.id_estado = est_fim.id_estado
                    and diaria.id_pedido = :pedido
                 order by
                    diaria.id_diaria, dest.id_diaria_destino";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosEmpenhoPedidoItens(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select * from view_pedido_saldo where id_pedido = :pedido order by nr_item";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosEmpenhoPedidoItensAnulados(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    saldo_item.tp_material,
                    saldo_item.nr_item,
                    saldo_item.nm_material,
                    saldo_item.nm_desc_material,
                    saldo_item.total,
                    saldo_item.qt_utilizado,
                    saldo_item.vl_utilizado,
                    anulacao.id_empenho_anulacao,
                    anulacao.nr_empenho_anulacao,
                    anulacao_item.vl_anulado,
                    anulacao_item.qt_anulado,
                    anulacao_item.vl_item,
                    anulacao_item.qt_item,
                    anulacao.nr_empenho_anulacao,
                    anulacao_situacao.nm_empenho_anulacao_situacao
                 from
                    con_empenho_anulacao anulacao,
                    con_empenho_anulacao_item anulacao_item,
                    con_empenho_anulacao_situacao anulacao_situacao,
                    view_pedido_saldo saldo_item 
                 where
                    anulacao.id_empenho_anulacao = anulacao_item.id_empenho_anulacao 
                    and saldo_item.id_pedido = anulacao.id_pedido
                    and saldo_item.id_pre_ordem = anulacao_item.id_pre_ordem
                    and anulacao.id_empenho_anulacao_situacao = anulacao_situacao.id_empenho_anulacao_situacao
                    and anulacao.id_empenho_anulacao_situacao = 2
                    and anulacao.id_pedido = :pedido
                    order by anulacao.id_empenho_anulacao,nr_item";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosEmpenhoContrato(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select cont.nr_contrato, cont.nr_contrato, processo.cd_pregao, tp.nm_tipo_gasto, obj.nm_objeto, central.nm_lotacao,cont.id_contrato,
                        mod.nm_modalidade, p.nm_pessoa, cont_itens.vl_contrato,
                        case 
                                when pf.nr_cpf is not null then pf.nr_cpf
                            when pf.nr_cpf is null then pj.nr_cnpj
                        end as cpfCnpj
                        from fin_empenho as emp
                        inner join fin_pedido as pedido 
                        on pedido.id_pedido = emp.id_pedido
                        inner join fin_fornecedor as f
                        on f.id_fornecedor  =  pedido.id_fornecedor
                        inner join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato
                        inner join fin_cont_central as cont_central
                        on cont_central.id_contrato = cont.id_contrato
                        left join ses_lotacao as central
                        on central.id_lotacao = cont_central.id_lotacao
                        inner join (select id_fornecedor, round(sum(qt_itens * vl_itens),4) as vl_contrato from fin_cont_itens group by id_fornecedor) as cont_itens
                        on cont_itens.id_fornecedor = f.id_fornecedor
                        inner join gco_processo as processo
                        on processo.id_processo = cont.id_processo
                        inner join gco_objeto as obj
                        on obj.id_objeto = processo.id_objeto
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = cont.id_tipo_gasto
                        inner join gco_modalidade as mod
                        on mod.id_modalidade = processo.id_modalidade
                        inner join ses_pessoa as p
                        on p.id_pessoa = f.id_pessoa 
                        left join ses_pessoa_fisica as pf
                        on pf.id_pessoa = p.id_pessoa
                        left join ses_pessoa_juridica as pj
                        on pj.id_pessoa = p.id_pessoa
                        where emp.id_pedido = :pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaStatusEmpenho(PDO $pdo){
        $this->sucesso = false;
        $sql = "SELECT 
                    E.id_empenho, 
                    P.id_pedido, P.nr_pedido, P.id_tipo_solicitacao
                    , P.id_fornecedor, P.dt_pedido, P.st_pedido, P.id_pedido_situacao
                    , E.id_empenho as id_pedido_empenho
                    , L.id_pedido AS id_pedido_liquidacao
                    , SALLIQUIDACAO.id_pedido AS id_pedido_saldo_liquidacao
                    , PAG.id_pedido AS id_pedido_pagamento
                    , SALPAG.id_pedido AS id_pedido_saldo_pagamento

                    , CASE	

                            /*
                             * Pedido Possui Empenho, não possui Liquidação nem Pagamento
                             * Deve ser Aguardando Liquidação
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL							
                                            AND E.id_pedido IS NOT NULL			
                                    ) THEN 1	

                            /*
                             * Pedido Possui Liquidação e Não possui Pagamento
                             * Precisa Verificar os Valores da Liquidação desse Pedido 
                             * Pode ser Aguardando Finalizar Liquidação ou Aguardando Pagamento
                             * O Pedido não tem mais Saldo de Acordo com as Liquidações então ele é Aguardando Pagamento
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALLIQUIDACAO.id_pedido IS NULL
                                    ) THEN 3
                            /*
                             * O Pedido possui Saldo de Acordo com as Liquidações então ele é Aguardando Finalizar Liquidação 
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALLIQUIDACAO.id_pedido IS NOT NULL
                                    ) THEN 2

                            /*
                             * Pedido Possui Pagamento 
                             * Precisa Verificar os Valores da Pagamento desse Pedido 
                             * Pode ser Aguardando Finalizar Pagamento ou Finalizado
                             * O Pedido não tem mais Saldo de Acordo com os Pagamentos então ele é Finalizado
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALPAG.id_pedido IS NULL
                                    ) THEN 5
                            /*
                             * O Pedido possui Saldo de Acordo com os Pagamentos então ele é Aguardando Finalizar Pagamento
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALPAG.id_pedido IS NOT NULL
                                    ) THEN 4

                            ELSE null
                    END AS status_oficial	

                    /*
                     * Situação do Empenho
                     */
                    , CASE
                            /*
                             * Pedido Possui Empenho, não possui Liquidação nem Pagamento
                             * Deve ser Cadastrado
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL							
                                            AND E.id_pedido IS NOT NULL			
                                    ) THEN 1	

                            /*
                             * Pedido Possui Liquidação e Não possui Pagamento
                             * Precisa Verificar os Valores da Liquidação desse Pedido 
                             * Pode ser Liquidado Parcial ou Liquidado
                             * O Pedido não tem mais Saldo de Acordo com as Liquidações então ele é Liquidado
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALLIQUIDACAO.id_pedido IS NULL
                                    ) THEN 3
                            /*
                             * O Pedido possui Saldo de Acordo com as Liquidações então ele é Liquidado Parcial
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALLIQUIDACAO.id_pedido IS NOT NULL
                                    ) THEN 2

                            /*
                             * Pedido Possui Pagamento 
                             * Precisa Verificar os Valores da Pagamento desse Pedido 
                             * Pode ser Pago Parcial ou Pago
                             * O Pedido não tem mais Saldo de Acordo com os Pagamentos então ele é Pago
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALPAG.id_pedido IS NULL
                                    ) THEN 5
                            /*
                             * O Pedido possui Saldo de Acordo com os Pagamentos então ele é Pago Parcial
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALPAG.id_pedido IS NOT NULL
                                    ) THEN 4

                            ELSE null
                    END AS situacao_oficial

                    FROM fin_pedido P
                    LEFT JOIN fin_empenho E ON E.id_pedido = P.id_pedido AND E.sit_empenho <> '6'

                    LEFT JOIN (
                                            SELECT distinct on (P.id_pedido) P.id_pedido
                                            FROM fin_pedido P
                                            INNER JOIN fin_empenho E ON E.id_pedido = P.id_pedido AND E.sit_empenho <> '6'
                                            INNER JOIN con_liquidacao L ON L.id_empenho = E.id_empenho AND L.id_liquidacao_situacao <> 4
                                            ) AS L ON L.id_pedido = P.id_pedido

                    LEFT JOIN (
                                            SELECT distinct on (P.id_pedido) P.id_pedido
                                            FROM fin_pedido P
                                            INNER JOIN fin_empenho E ON E.id_pedido = P.id_pedido AND E.sit_empenho <> '6'
                                            INNER JOIN con_liquidacao L ON L.id_empenho = E.id_empenho AND L.id_liquidacao_situacao <> 4
                                            INNER JOIN con_pagamento PAG ON PAG.id_liquidacao = L.id_liquidacao AND PAG.id_pagamento_situacao <> 2
                                            ) AS PAG ON PAG.id_pedido = P.id_pedido						


                    LEFT JOIN (SELECT * 
                                            FROM (
                                            select
                                                ped.id_pedido,                    
                                                coalesce(sum(vl_liquidacao), 0) as valor_liquidado,                                       
                                                vl_pedido as valor_pedido     
                                                , (vl_pedido - coalesce(sum(vl_liquidacao), 0)) AS saldo 
                                             from
                                                fin_pedido ped                     
                                                inner join
                                                   fin_empenho emp 
                                                   on ped.id_pedido = emp.id_pedido AND emp.sit_empenho <> '6'
                                                left join
                                                   con_liquidacao liq 
                                                   on emp.id_empenho = liq.id_empenho 
                                                   and liq.id_liquidacao_situacao <> 4 
                                             group by ped.id_pedido ) t2  
                                             where t2.saldo > 0
                                            ) AS SALLIQUIDACAO ON SALLIQUIDACAO.id_pedido = P.id_pedido

                    LEFT JOIN (SELECT *
                                            FROM (
                                            select
                                                ped.id_pedido,                    
                                                coalesce(sum(vl_pagamento), 0) as valor_pago,                                       
                                                vl_pedido as valor_pedido     
                                                , (vl_pedido - coalesce(sum(vl_pagamento), 0)) AS saldo 
                                             from
                                                fin_pedido ped                     
                                                inner join
                                                   fin_empenho emp 
                                                   on ped.id_pedido = emp.id_pedido AND emp.sit_empenho <> '6'
                                                left join
                                                   con_liquidacao liq 
                                                   on emp.id_empenho = liq.id_empenho 
                                                   and liq.id_liquidacao_situacao <> 4
                                                 left join
                                                   con_pagamento pag 
                                                   on pag.id_liquidacao = liq.id_liquidacao 
                                                   and pag.id_pagamento_situacao <> 2
                                             group by ped.id_pedido ) t2  
                                             where t2.saldo > 0
                                            ) AS SALPAG ON SALPAG.id_pedido = P.id_pedido
                    WHERE E.id_empenho = :id_empenho";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho", $this->getIdEmpenho(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
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
    
        
}
