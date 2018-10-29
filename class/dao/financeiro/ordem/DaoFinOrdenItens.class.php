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
                $sql = "select pre.id_pre_ordem,
                        case 
                                when (mat.tp_material = 'C' or mat.tp_material = 'P') and itens.fl_valor_variavel = '0' 
                            then (pre.qt_itens_pre - coalesce(ordemItens.qt_itens_ordem,'0.0000') - coalesce(entregas.qt_itens_entrega,'0.0000'))
                            when mat.tp_material = 'S' or itens.fl_valor_variavel = '1'
                            then ((pre.qt_itens_pre * pre.vl_itens_pre) - coalesce(ordemItens.total,'0.0000') - coalesce(entregas.total,'0.0000'))
                        end saldo
                        from fin_pedido as pedido
                        inner join fin_pre_ordem as pre
                        on pedido.id_pedido = pre.id_pedido
                        inner join fin_cont_itens as itens 
                        on itens.id_cont_itens = pre.id_cont_itens
                        inner join pla_material as mat
                        on mat.id_material = itens.id_material
                        inner join view_despesa as desp
                        on desp.id_despesa = mat.id_despesa
                        inner join pla_unidade_medida as unid
                        on unid.id_unidade_medida = itens.id_unidade_medida
                        left join (select sum(itens.qt_itens_ordem) as qt_itens_ordem, sum(itens.qt_itens_ordem * itens.vl_itens_ordem) as total,  
                                                itens.id_pre_ordem
                                                from fin_ordem as ordem
                                    inner join fin_ordem_itens as itens
                                    on ordem.id_ordem = itens.id_ordem
                                    where ordem.sit_ordem > '0' and ordem.sit_ordem < '3'
                                    group by itens.id_pre_ordem
                                  ) as ordemItens
                        on ordemItens.id_pre_ordem = pre.id_pre_ordem

                        left join (select sum(itens.qt_itens_entrega)as qt_itens_entrega, sum(itens.qt_itens_entrega * itens.vl_itens_entrega) as total, ordemItens.id_pre_ordem
                               from fin_pedido as pedido 
                               inner join fin_ordem as ordem
                               on ordem.id_pedido = pedido.id_pedido
                               inner join fin_ordem_itens as ordemItens 
                               on ordemItens.id_ordem = ordem.id_ordem
                               inner join fin_entrega_confirmacao as confirmacao
                               on confirmacao.id_ordem = ordem.id_ordem
                               inner join fin_entrega_itens as itens
                               on itens.id_ordem_itens = ordemItens.id_ordem_itens and confirmacao.id_entrega_confirmacao = itens.id_entrega_confirmacao
                               where ordem.sit_ordem > '2' and confirmacao.sit_entrega > '0'
                               group  by  ordemItens.id_pre_ordem
                               ) as entregas
                        on entregas.id_pre_ordem = pre.id_pre_ordem
                        where pre.id_pedido = :pedido and pre.id_pre_ordem = :preOrdem";
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
