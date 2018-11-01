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
                $sql = "SELECT * from view_pedido_saldo            
                        WHERE id_pedido = :pedido AND id_pre_ordem = :preOrdem";
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
