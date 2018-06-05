<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinEntregaItensTb.class.php";

class DaoFinEntregaItens extends FinEntregaItensTb {

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

    public function insertentregaItens(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_entrega_itens (id_entrega_confirmacao, id_ordem_itens, qt_itens_entrega, vl_itens_entrega, tp_entrega, dt_entrega)"
                        . " values (:idEntrega, :idOrdemItens, :qt, :vl, :tpEntrega, :dtEntrega)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':idEntrega', $this->getIdEntregaConfirmacao());
                $stmt->bindValue(':idOrdemItens', $this->getIdOrdemItens());
                $stmt->bindValue(':qt', $this->getQtItensEntrega());
                $stmt->bindValue(':vl', $this->getVlItensEntrega());
                $stmt->bindValue(':tpEntrega', $this->getTpEntrega());
                $stmt->bindValue(':dtEntrega', $this->getDhEntrega());
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaValorItenOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select vl_itens_ordem from fin_ordem_itens as ordemItens where ordemItens.id_ordem_itens = :ordemItens";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordemItens", $this->getIdOrdemItens());
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
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function t(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select distinct on(entegaitens.id_entrega_itens) entegaitens.id_entrega_itens, itens.nr_item, mat.nm_material, mat.cd_desc_material, 
                        to_char(ordemItens.qt_itens_ordem, '9G999G990D9999')as qt_itens_ordem, to_char(ordemItens.vl_itens_ordem, '9G999G990D9999')as vl_itens_ordem, 
                        desp.cd_despesa, desp.ds_despesa, mat.tp_material, itens.fl_valor_variavel, pro.ds_protocolo,itens.nr_lote, 
                        case 	
                                when mat.tp_material = 'C' or mat.tp_material = 'P' and itens.fl_valor_variavel = '0'
                                then to_char(entegaitens.qt_itens_entrega , '9G999G990D9999')
                                when mat.tp_material = 'C' and itens.fl_valor_variavel = '1'
                            then to_char((entegaitens.qt_itens_entrega * entegaitens.vl_itens_entrega) , '9G999G990D9999')
                                when mat.tp_material = 'S' 
                            then to_char((entegaitens.qt_itens_entrega * entegaitens.vl_itens_entrega) , '9G999G990D9999')

                        end as entregue,

                        case 
                                when itens.ds_itens is not null then itens.ds_itens
                                else mat.nm_desc_material
                        end nm_desc_material, 
                        case 
                        when entegaitens.tp_entrega = '1' then 'Parcial'
                        when entegaitens.tp_entrega = '2' then 'Total'
                        end as tipo, to_char(entegaitens.dt_entrega, 'DD/MM/YYYY') as dt_entrega

                        from fin_entrega_itens as entegaitens

                        inner join fin_entrega_confirmacao as entregaC
                        on entegaitens.id_entrega_confirmacao = entregaC.id_entrega_confirmacao

                        inner join fin_protocolo as pro
                        on pro.id_protocolo = entregaC.id_protocolo

                        inner join fin_ordem as ordem
                        on ordem.id_ordem = pro.id_ordem

                        inner join fin_ordem_itens as ordemItens
                        on ordemItens.id_ordem_itens = entegaitens.id_ordem_itens

                        inner join fin_pre_ordem as pre
                        on pre.id_pre_ordem = ordemItens.id_pre_ordem

                        inner join fin_cont_itens as itens
                        on itens.id_cont_itens = pre.id_cont_itens

                        inner join fin_fornecedor as f
                        on f.id_fornecedor = pre.id_fornecedor

                        inner join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato

                        inner join ses_pessoa as pessoa
                        on pessoa.id_pessoa = f.id_pessoa

                        inner join pla_material as mat
                        on mat.id_material = itens.id_material

                        inner join view_despesa as desp
                        on desp.id_despesa = mat.id_despesa 

                        inner join fin_pedido as p
                        on p.id_pedido = ordem.id_pedido

                        inner join fin_empenho as emp
                        on emp.id_pedido = p.id_pedido

                        where entegaitens.id_entrega_confirmacao = :entrega";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao());
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function verificarEntregaParcial(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_entrega_itens where id_entrega_confirmacao = :entrega  and tp_entrega = '1'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao());
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

    public function retornaAgurdandoEntrega(PDO $pdo){
              try {
            if (!empty($pdo)) {
                    $sql = "select ordemItens.id_ordem_itens, 
                            case 
                                    when mat.tp_material = 'C' or mat.tp_material = 'P' and itens.fl_valor_variavel = '0'
                                then to_char((ordemItens.qt_itens_ordem 
                                            - 
                                     (select coalesce(sum(qt_itens_entrega),'0.0000') 
									 from fin_entrega_itens 
									 where id_entrega_confirmacao = entregaC.id_entrega_confirmacao
									 and id_ordem_itens = ordemItens.id_ordem_itens
									)),'9G999G990D9999')

                                when mat.tp_material = 'C' and itens.fl_valor_variavel = '1'
                                then to_char((round((ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem),4)
                                                    -
                                (select coalesce(sum(qt_itens_entrega * vl_itens_entrega),'0.0000') 
								from fin_entrega_itens 
								where id_entrega_confirmacao = entregaC.id_entrega_confirmacao
								and id_ordem_itens = ordemItens.id_ordem_itens
								)),'9G999G990D9999')
                                when mat.tp_material = 'S' 
                                then to_char((round((ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem),4)
                                                    -
                                (select coalesce(sum(qt_itens_entrega * vl_itens_entrega),'0.0000') 
								from fin_entrega_itens 
								where id_entrega_confirmacao = entregaC.id_entrega_confirmacao
								and id_ordem_itens = ordemItens.id_ordem_itens
								)),'9G999G990D9999')
                            end as aguardandoEntrega

                            from fin_entrega_confirmacao as entregaC

                            inner join fin_protocolo as pro
                            on pro.id_protocolo = entregaC.id_protocolo

                            inner join fin_ordem as ordem
                            on ordem.id_ordem = entregaC.id_ordem

                            inner join fin_ordem_itens as ordemItens
                            on ordemItens.id_ordem = ordem.id_ordem

                            inner join fin_pre_ordem as pre
                            on pre.id_pre_ordem = ordemItens.id_pre_ordem
 
                            inner join fin_cont_itens as itens
                            on itens.id_cont_itens = pre.id_cont_itens

                            inner join fin_fornecedor as f
                            on f.id_fornecedor = pre.id_fornecedor

                            inner join fin_contrato as cont
                            on cont.id_contrato = f.id_contrato

                            inner join ses_pessoa as pessoa
                            on pessoa.id_pessoa = f.id_pessoa

                            inner join pla_material as mat
                            on mat.id_material = itens.id_material

                            where entregaC.id_entrega_confirmacao = :entrega";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":entrega", $this->getIdEntregaConfirmacao());
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "Nenhum registro encontrado";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Erro PDO";
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $ex->getMessage();
            $this->sucesso = false;
        }
    }

}
