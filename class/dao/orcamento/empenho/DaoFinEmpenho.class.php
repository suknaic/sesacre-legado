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
            $sql = "SELECT 
                      fin_empenho.id_empenho, 
                      fin_tipo_empenho.nm_tipo_empenho, 
                      fin_empenho.nr_empenho, 
                      fin_empenho.dh_empenho_sistema, 
                      fin_empenho.dt_empenho_safira, 
                      fin_empenho.vl_empenho, 
                      fin_empenho.ds_empenho, 
                      fin_empenho.sit_empenho
                    FROM 
                      public.fin_empenho, 
                      public.fin_tipo_empenho
                    WHERE 
                      fin_empenho.id_tipo_empenho = fin_tipo_empenho.id_tipo_empenho";
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
                $sql = "UPDATE fin_pedido SET st_pedido = '".$stPedido."' where id_pedido = :pedido";
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

}
