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
                        item.nr_lote, pre.qt_itens_pre, pre.vl_itens_pre, cont.tp_contrato, (pre.qt_itens_pre *pre.vl_itens_pre) as total, 
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
                    where emp.nr_empenho = :numero";
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

    public function retornaEmpenhoGdof(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            emp.id_pedido,
                            emp.nr_empenho,
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
                            emp.nr_empenho,
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

    public function retornaEmpenhos(PDO $pdo){
        $this->sucesso = false;
        $sql = "select
                    emp.nr_empenho,
                    ped.nr_pedido,
                    coalesce(pf.nr_cpf, pj.nr_cnpj, '') as cpf_cnpj,
                    coalesce(upper(pf.nm_civil), upper(pj.nm_fantasia),'') as nome_razao,
                    tpEmp.nm_tipo_empenho,
                    extract(year from dt_empenho_safira) as competencia,
                    to_char(dt_empenho_safira, 'dd/mm/yyyy') as dt_empenho_safira,
                    trim(to_char(vl_empenho,'999G999G999G990D9999')) as vl_empenho,
                    case sit_empenho 
                         when '1' then 'Cadastrado'
                         when '2' then 'Liquidado Parcial'
                         when '3' then 'Liquidado Total'
                         when '4' then 'Pago Parcial'
                         when '5' then 'Pago Total'
                         when '6' then 'Cancelado'
                    end as situacao
                 from
                    fin_empenho emp 
                    inner join
                       fin_tipo_empenho tpEmp 
                       on tpEmp.id_tipo_empenho = emp.id_tipo_empenho 
                    inner join
                       fin_pedido ped 
                       on ped.id_pedido = emp.id_pedido 
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
                       on pj.id_pessoa = fornec.id_pessoa
                 order by dt_empenho_safira desc,nr_empenho, nr_pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
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
}
