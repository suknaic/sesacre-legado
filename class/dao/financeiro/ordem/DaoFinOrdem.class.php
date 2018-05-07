<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/ordem/FinOrdemTb.class.php";

class DaoFinOrdem extends FinOrdemTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    public function cadastrarOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
//                var_dump($this->getIdPedido());
//                 var_dump($this->getIdLotacao());
//                  var_dump($this->getNrOrdem());
//                   var_dump($this->getAaOrdem());
//                    var_dump($this->getNrOrdem());
//                     var_dump($this->getNrPrazoOrdem());
//                      var_dump($this->getTpOrdem());
//                       var_dump($this->getDtIniOrdem());
//                        var_dump($this->getDtFimOrdem());
//                         var_dump($this->getSitOrdem());
                
                $sql = "INSERT INTO fin_ordem (id_pedido, id_lotacao, id_pessoa, nr_ordem, aa_ordem, fl_unica, nr_prazo_ordem, tp_ordem, dt_ini_ordem, "
                        . "dt_fim_ordem, sit_ordem) VALUES (:pedido, :lotacao, :idPessoa, :numero, :ano, :fl, :prazo, :tpOrdem, :dt_ini, :dt_fim, :sit_ordem)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":idPessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":numero", $this->getNrOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":ano", $this->getAaOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":fl", 0, PDO::PARAM_INT);
                $stmt->bindValue(":prazo", $this->getNrPrazoOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":tpOrdem", $this->getTpOrdem(), PDO::PARAM_INT);
                $stmt->bindValue(":dt_ini", $this->getDtIniOrdem(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFimOrdem(), PDO::PARAM_STR);
                $stmt->bindValue(":sit_ordem", $this->getSitOrdem(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage().'1';
        }
    }

    public function listaItensPreOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select pre.id_pre_ordem, p.id_pedido, p.nr_pedido, p.ds_pedido, tp.nm_tipo_gasto, mat.cd_material, mat.nm_material, mat.nm_grupo,
                        mat.nm_sub_grupo, desp.ds_despesa_elemento, mat.tp_material, contItens.nr_lote, mat.nm_desc_material,
                        pre.qt_itens_pre, pre.vl_itens_pre, contItens.nr_item, unid.nm_unidade_medida,
                        CASE WHEN mat.tp_material = 'C'
                        THEN  coalesce(pre.qt_itens_pre,0.0000)
                        ELSE coalesce((pre.qt_itens_pre * pre.vl_itens_pre),0.0000)
                        END as total,

                        coalesce((select 
                                     CASE WHEN matSub.tp_material = 'C'
                                     THEN  coalesce(sum(itemOrdem.qt_itens_ordem),0.0000)
                                     ELSE coalesce(sum((itemOrdem.qt_itens_ordem * itemOrdem.vl_itens_ordem)),0.0000) END as uti	
                                     from fin_ordem_itens as itemOrdem
                                     inner join fin_pre_ordem as preSub
                                     on itemOrdem.id_pre_ordem = preSub.id_pre_ordem
                                     inner join fin_cont_itens as contItensSub
                                     on contItensSub.id_cont_itens = pre.id_cont_itens
                                     inner join pla_material as matSub
                                     on matSub.id_material = contItensSub.id_material
                                     where itemOrdem.id_pre_ordem = pre.id_pre_ordem
                                     group by itemOrdem.id_pre_ordem, matSub.tp_material
                                     ),0.0000) as utilizado,

                        (CASE WHEN mat.tp_material = 'C' 
                        THEN  coalesce(pre.qt_itens_pre,0.0000)
                        ELSE coalesce((pre.qt_itens_pre * pre.vl_itens_pre),0.0000)
                        END
                        -
                        coalesce((select 
                                     CASE WHEN matSub.tp_material = 'C'
                                     THEN coalesce(sum(itemOrdem.qt_itens_ordem),0.0000)
                                     ELSE coalesce(sum((itemOrdem.qt_itens_ordem * itemOrdem.vl_itens_ordem)),0.0000) END as uti	
                                     from fin_ordem_itens as itemOrdem
                                     inner join fin_pre_ordem as preSub
                                     on itemOrdem.id_pre_ordem = preSub.id_pre_ordem
                                     inner join fin_cont_itens as contItensSub
                                     on contItensSub.id_cont_itens = pre.id_cont_itens
                                     inner join pla_material as matSub
                                     on matSub.id_material = contItensSub.id_material
                                     where itemOrdem.id_pre_ordem = pre.id_pre_ordem
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
                        where pre.id_pedido = :pedido order by contItens.nr_lote, contItens.nr_item";
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
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaValorPreOrdem(PDO $pdo, int $pre = 0) {
        try {
            if (!empty($pdo)) {
                $sql = "select pre.vl_itens_pre from fin_pre_ordem as pre where id_pre_ordem = :pre";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pre", $pre, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaNumeroMaxOrdem(PDO $pdo) {
        try {
            if ($pdo != NULL) {
                $sql = "SELECT MAX(nr_ordem) AS numero FROM fin_ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    return FALSE;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaDadosTrPesquisa(PDO $pdo, string $condicao, int $ano) {
        try {
            if (!empty($pdo)) {
                $sql = "select ordem.id_ordem, p.id_pedido, concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as pedido,
                         p.ds_pedido, tg.nm_tipo_gasto, f.nr_fonte, desp.cd_despesa_elemento, desp.ds_despesa_elemento, ordem.nr_ordem, ordem.tp_ordem,
                        (select sum((itemOrdem.qt_itens_ordem * itemOrdem.vl_itens_ordem)) as v
                        from fin_ordem_itens as itemOrdem
                        where itemOrdem.id_ordem = ordem.id_ordem
                        ) as valorOrdem,
                        case 
                         when ordem.tp_ordem = '1' THEN 'ENTREGA'
                         when ordem.tp_ordem = '2' THEN 'EXECUÇÃO/SERVIÇO'
                         END as tipo

                        
                        from fin_pedido as p
                        inner join fin_ordem as ordem
                        on ordem.id_pedido = p.id_pedido
                        inner join pla_tipo_gasto as tg
                        on tg.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_fonte as f
                        on f.id_fonte = p.id_fonte
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento
                        where ordem.aa_ordem = :ano " . $condicao . "";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ano", $ano, PDO::PARAM_INT);
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
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaPrazoEntrega(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select cont.nr_prazo_entrega from fin_pedido as p 
                        inner join fin_fornecedor as f
                        on f.id_fornecedor = p.id_fornecedor
                        inner join fin_contrato as cont
                        on cont.id_contrato  = f.id_contrato 
                        where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
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

}
