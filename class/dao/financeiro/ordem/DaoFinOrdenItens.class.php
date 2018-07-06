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
                        (CASE WHEN mat.tp_material = 'C' OR mat.tp_material = 'P' 
                                THEN  coalesce(pre.qt_itens_pre,0.0000)
                            ELSE coalesce((pre.qt_itens_pre * pre.vl_itens_pre),0.0000)
                            END
                            -
                            coalesce((select 
                            CASE WHEN matSub.tp_material = 'C' OR matSub.tp_material = 'P' 
                            THEN coalesce(sum(itemOrdem.qt_itens_ordem),0.0000)
                            ELSE coalesce(sum((itemOrdem.qt_itens_ordem * itemOrdem.vl_itens_ordem)),0.0000) END as uti	
                            from fin_ordem as ordem  
                            inner join fin_ordem_itens as itemOrdem
                            on ordem.id_ordem = itemOrdem.id_ordem
                            inner join fin_pre_ordem as preSub
                            on itemOrdem.id_pre_ordem = preSub.id_pre_ordem
                            inner join fin_cont_itens as contItensSub
                            on contItensSub.id_cont_itens = pre.id_cont_itens
                            inner join pla_material as matSub
                            on matSub.id_material = contItensSub.id_material
                            where ordem.sit_ordem > '0'
                            and itemOrdem.id_pre_ordem = pre.id_pre_ordem
                            group by itemOrdem.id_pre_ordem, matSub.tp_material
                            ),0.0000) 
                         ) as saldo
                        from fin_pre_ordem as pre
                        inner join fin_pedido as p
                        on p.id_pedido = pre.id_pedido
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_cont_itens as contItens
                        on contItens.id_cont_itens = pre.id_cont_itens
                        inner join pla_material as mat
                        on mat.id_material = contItens.id_material
                        inner join pla_unidade_medida as unid
                        on unid.id_unidade_medida = contItens.id_unidade_medida
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento
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
            $this->msgRetorno = $e->getMessage();
        }
    }

}
