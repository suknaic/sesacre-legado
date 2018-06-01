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
            if ($pdo != null) {

                $sql = "insert into fin_entrega_confirmacao(id_ordem, id_protocolo, nr_entrega_confirmacao, dt_entrega, nr_qtd_entregas) 
                        values(:ordem, :protocolo, :nrEntrega, :dtEntrega, :qtdEntrega)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
                $stmt->bindValue(":nrEntrega", $this->getNrEntregaConfirmacao(), PDO::PARAM_INT);
                $stmt->bindValue(":dtEntrega", $this->getDtEntrega(), PDO::PARAM_STR);
                $stmt->bindValue(":qtdEntrega", $this->getNrQtdEntrega(), PDO::PARAM_INT);
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
                $sql = "select entregaC.id_entrega_confirmacao, ordemItens.id_ordem_itens, itens.nr_item, mat.nm_material, mat.cd_desc_material,
                        case 
                                when itens.ds_itens is not null then itens.ds_itens
                            else mat.nm_desc_material
                        end nm_desc_material, desp.cd_despesa, desp.ds_despesa, mat.tp_material, itens.fl_valor_variavel, pro.ds_protocolo,
                        itens.nr_lote, pessoa.nm_pessoa, p.nr_pedido, p.ds_pedido, cont.nr_contrato, cont.tp_contrato,
                        ordem.nr_ordem, ordem.aa_ordem, emp.nr_empenho, to_char(ordemItens.qt_itens_ordem, '9G999G990D9999')as qt_itens_ordem,
					   to_char(ordemItens.vl_itens_ordem, '9G999G990D9999')as vl_itens_ordem,
						
                        case 
                                when mat.tp_material = 'C' or mat.tp_material = 'P' and itens.fl_valor_variavel = '0'
                            then (select coalesce(to_char(sum(qt_itens_entrega), '9G999G990D9999'),'0,0000') from fin_entrega_itens where id_entrega_confirmacao = entregaC.id_entrega_confirmacao) 

                                when mat.tp_material = 'C' and itens.fl_valor_variavel = '1'
                            then (select coalesce(to_char(sum(qt_itens_entrega * vl_itens_entrega), '9G999G990D9999'),'0,0000') from fin_entrega_itens where id_entrega_confirmacao = entregaC.id_entrega_confirmacao)

                            when mat.tp_material = 'S' 
                            then (select coalesce(to_char(sum(qt_itens_entrega * vl_itens_entrega), '9G999G990D9999'),'0,0000') from fin_entrega_itens where id_entrega_confirmacao = entregaC.id_entrega_confirmacao)
                            end as entregue,

                        case 
                            when mat.tp_material = 'C' or mat.tp_material = 'P' and itens.fl_valor_variavel = '0'
                            then to_char(( 
						   ordemItens.qt_itens_ordem 
                            - 
                            (select coalesce(sum(qt_itens_entrega),'0.0000') from fin_entrega_itens where id_entrega_confirmacao = entregaC.id_entrega_confirmacao)
							),'9G999G990D9999')
							
                            when mat.tp_material = 'C' and itens.fl_valor_variavel = '1'
                            then to_char(( 
                            round((ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem),4)
                            -
                            (select coalesce(sum(qt_itens_entrega * vl_itens_entrega),'0.0000') from fin_entrega_itens where id_entrega_confirmacao = entregaC.id_entrega_confirmacao)
							),'9G999G990D9999')
                            when mat.tp_material = 'S' 
                            then to_char(( 
                            round((ordemItens.qt_itens_ordem * ordemItens.vl_itens_ordem),4)
                            -
                            (select coalesce(sum(qt_itens_entrega * vl_itens_entrega),'0.0000') from fin_entrega_itens where id_entrega_confirmacao = entregaC.id_entrega_confirmacao)
							),'9G999G990D9999')
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
                        inner join view_despesa as desp
                        on desp.id_despesa = mat.id_despesa 
                        inner join fin_pedido as p
                        on p.id_pedido = ordem.id_pedido
                        inner join fin_empenho as emp
                        on emp.id_pedido = p.id_pedido
                        where entregaC.id_entrega_confirmacao = :protocolo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":protocolo", $this->getIdProtocolo(), PDO::PARAM_INT);
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
            
        }
    }

}
