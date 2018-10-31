<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinOrdemItensTb.class.php";

class DaoFinOrdenItens extends FinOrdemItensTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function cadastroFinOrdemItens($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "INSERT INTO fin_ordem_itens (id_ordem, id_pre_ordem, qt_itens_ordem, vl_itens_ordem) VALUES (:idOrdem, :pre, :qt, :vl)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":pre", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":qt", $this->getQdItensPre(), PDO::PARAM_STR);
                $stmt->bindValue(":vl", $this->getVlItensPre(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaSaldoItemPreOrdem(PDO $pdo, int $idPedido = 0) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT 
                        CASE 
                            WHEN (mat.tp_material = 'C' OR mat.tp_material = 'P') AND itens.fl_valor_variavel = '0' 
                            THEN (pre.qt_itens_pre - COALESCE(ordemItens.qt_itens_ordem,'0.0000') - COALESCE(entregas.qt_itens_entrega,'0.0000') - COALESCE(anulacoes.qt_anulado,'0.0000'))
                            WHEN mat.tp_material = 'S' OR itens.fl_valor_variavel = '1'
                            THEN (pre.vl_total - COALESCE(ordemItens.total,'0.0000') - COALESCE(entregas.total,'0.0000') - COALESCE(anulacoes.total,'0.0000'))
                        END saldoOrdem
                        FROM fin_pedido AS pedido
                        INNER JOIN fin_pre_ordem AS pre
                        ON pedido.id_pedido = pre.id_pedido
                        INNER JOIN fin_cont_itens AS itens 
                        ON itens.id_cont_itens = pre.id_cont_itens
                        INNER JOIN pla_material AS mat
                        ON mat.id_material = itens.id_material
                        INNER JOIN view_despesa AS desp
                        ON desp.id_despesa = mat.id_despesa
                        INNER JOIN pla_unidade_medida AS unid
                        ON unid.id_unidade_medida = itens.id_unidade_medida
                        LEFT JOIN (SELECT sum(itens.qt_itens_ordem) AS qt_itens_ordem, sum(itens.qt_itens_ordem * itens.vl_itens_ordem) AS total, itens.id_pre_ordem
                                   FROM fin_ordem AS ordem
                                   INNER JOIN fin_ordem_itens AS itens
                                   ON ordem.id_ordem = itens.id_ordem
                                   WHERE ordem.sit_ordem > '0' AND ordem.sit_ordem < '3'	
                                   GROUP BY itens.id_pre_ordem
                                   ) AS ordemItens
                        ON ordemItens.id_pre_ordem = pre.id_pre_ordem

                        LEFT JOIN (SELECT sum(itens.qt_itens_entrega) AS qt_itens_entrega, sum(itens.qt_itens_entrega * itens.vl_itens_entrega) AS total, ordemItens.id_pre_ordem
                                   FROM fin_pedido AS pedido 
                                   INNER JOIN fin_ordem AS ordem
                                   ON ordem.id_pedido = pedido.id_pedido
                                   INNER JOIN fin_ordem_itens AS ordemItens 
                                   ON ordemItens.id_ordem = ordem.id_ordem
                                   INNER JOIN fin_entrega_confirmacao AS confirmacao
                                   ON confirmacao.id_ordem = ordem.id_ordem
                                   INNER JOIN fin_entrega_itens AS itens
                                   ON itens.id_ordem_itens = ordemItens.id_ordem_itens and itens.id_entrega_confirmacao = confirmacao.id_entrega_confirmacao
                                   WHERE ordem.sit_ordem > '2' AND confirmacao.sit_entrega > '0'
                                   GROUP  BY  ordemItens.id_pre_ordem
                                   ) AS entregas
                        ON entregas.id_pre_ordem = pre.id_pre_ordem

                        LEFT JOIN (SELECT sum(qt_anulado) as qt_anulado, sum(vl_anulado)as total, preOrdem.id_pre_ordem 
                                   FROM fin_pedido as pedido
                                   INNER JOIN fin_pre_ordem as preOrdem
                                   ON preOrdem.id_pedido = pedido.id_pedido
                                   INNER JOIN con_empenho_anulacao as anulacao
                                   ON anulacao.id_pedido = pedido.id_pedido
                                   INNER JOIN con_empenho_anulacao_item as itensAnulacao
                                   ON itensAnulacao.id_pre_ordem = preOrdem.id_pre_ordem 
                                   AND itensAnulacao.id_empenho_anulacao = anulacao.id_empenho_anulacao
                                   WHERE anulacao.id_empenho_anulacao_situacao = 1
                                   GROUP  BY preOrdem.id_pre_ordem 
                                  ) as anulacoes
                        ON anulacoes.id_pre_ordem = pre.id_pre_ordem
                        WHERE pre.id_pedido = :pedido AND pre.id_pre_ordem = :preOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $idPedido, PDO::PARAM_INT);
                $stmt->bindValue(":preOrdem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaSaldoItensOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select ordemItens.id_ordem_itens, 
                        case 
                            when (material.tp_material = 'C' OR material.tp_material = 'P') and itens.fl_valor_variavel = '0'
                            then round((ordemItens.qt_itens_ordem - sum(COALESCE(entItens.qt_itens_entrega, '0.0000'))),4)	
                            when (material.tp_material = 'S' OR itens.fl_valor_variavel = '1')
                            then round(((ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem) - sum(COALESCE((entItens.qt_itens_entrega * entItens.vl_itens_entrega),'0.0000'))),4)		
                        end saldoItens
                        from fin_ordem_itens as ordemItens
                        inner join fin_pre_ordem as preOrdem
                        on preOrdem.id_pre_ordem = ordemItens.id_pre_ordem
                        inner join fin_cont_itens as itens
                        on itens.id_cont_itens = preOrdem.id_cont_itens
                        inner join pla_material as material
                        on material.id_material = itens.id_material
                        left join fin_entrega_itens as entItens
                        on entItens.id_ordem_itens = ordemItens.id_ordem_itens
                        where id_ordem = :ordem
                        group by ordemItens.id_ordem_itens, material.tp_material, itens.fl_valor_variavel";
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
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

}
