<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/preOrdem/FinPreOrdemTb.class.php";

class DaoFinPreOrdem extends FinPreOrdemTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    public function Sucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function cadastrarPreOrdem($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_pre_ordem (id_cont_itens, id_pedido, id_fornecedor, qt_itens_pre, vl_itens_pre) VALUES (:item, :pedido, :fornecedor, :qtd, :vl)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":item", $this->getIdContItens(), PDO::PARAM_INT);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->bindValue(":qtd", $this->getQtItensPre(), PDO::PARAM_STR);
                $stmt->bindValue(":vl", $this->getVlItensPre(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
                $this->msgRetorno = '';
            } catch (PDOException $e) {
                $this->sucesso = false;

                if ($e->getCode() == "23505") {
                    $this->msgRetorno = 'Alguns itens já ser encontra salvo no sistema';
                } else {
                    $this->msgRetorno = $e->getMessage();
                }
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    public function retornaPreOdemPedido($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "SELECT pre.id_pre_ordem, pre.id_fornecedor, contIt.id_cont_itens, contIt.ds_itens, mat.nm_material, mat.nm_desc_material, mat.nm_grupo, mat.nm_sub_grupo, 
                        desp.cd_despesa, mat.tp_material, contIt.nr_lote, pre.qt_itens_pre, pre.vl_itens_pre, (pre.vl_total) as total,
                        contIt.nr_item, unid.nm_unidade_medida, mat.cd_desc_material
			FROM fin_pre_ordem as pre
			INNER JOIN fin_cont_itens as contIt
			ON contIt.id_cont_itens = pre.id_cont_itens
                        
                        INNER JOIN pla_unidade_medida as unid
			ON unid.id_unidade_medida = contIt.id_unidade_medida
			
                        INNER JOIN pla_material as mat
			ON mat.id_material = contIt.id_material
			
                        INNER JOIN view_despesa as desp
			ON desp.id_despesa = mat.id_despesa
			
                        WHERE pre.id_pedido =  :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;

                if ($e->getCode() == "23505") {
                    $this->msgRetorno = 'Alguns itens já ser encontra salvo no sistema';
                } else {
                    $this->msgRetorno = $e->getMessage();
                }
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }
    
    public function retorna($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "select * from fin_pre_ordem where id_pre_ordem = :id_pre_ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pre_ordem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

    public function retornaItemPreOrdem($pdo = null, $condicao = '') {
        if (!empty($pdo) && !empty($condicao)) {
            try {
                $sql = "select * from fin_pre_ordem " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

    public function retornaDadosEdicaoPreOrdem($pdo = null, $condicao = '') {
        if (!empty($pdo) && !empty($condicao)) {
            try {
                $sql = "select material.cd_desc_material,material.nm_material,material.nm_desc_material,material.nm_grupo, 
                        material.nm_sub_grupo,material.cd_elemento_despesa,material.tp_material,item.nr_lote,item.nm_marca,
                        item.nm_modelo,pre.qt_itens_pre,pre.vl_itens_pre,item.pc_desconto,item.id_fornecedor,item.id_cont_itens,
                        item.ds_itens, pre.id_pre_ordem
                        from fin_pre_ordem as pre
                        inner join fin_cont_itens as item
                        on item.id_cont_itens = pre.id_cont_itens
                        inner join pla_material as material
                        on material.id_material = item.id_material " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }
    }

    public function editarItensPreOrdem($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "update fin_pre_ordem SET qt_itens_pre = :qtd, vl_itens_pre = :valor where id_pre_ordem = :ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":qtd", $this->getQtItensPre(), PDO::PARAM_STR);
                $stmt->bindValue(":valor", $this->getVlItensPre(), PDO::PARAM_STR);
                $stmt->bindValue(":ordem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
                $this->msgRetorno = '';
            } catch (PDOException $e) {
                $this->sucesso = false;

                if ($e->getCode() == "23505") {
                    $this->msgRetorno = 'Alguns itens já ser encontra salvo no sistema';
                } else {
                    $this->msgRetorno = $e->getMessage();
                }
            }
        } else {
            $this->sucesso = false;
        }
    }
    
    public function editarQuantidadeTotalPreOrdem($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "update fin_pre_ordem SET qt_itens_pre = :qtd, vl_total = :vl_total where id_pre_ordem = :ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":qtd", $this->getQtItensPre(), PDO::PARAM_STR);    
                $stmt->bindValue(":vl_total", $this->getVlTotal(), PDO::PARAM_STR);                    
                $stmt->bindValue(":ordem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
                $this->msgRetorno = '';
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
               
            }
        } else {
            $this->sucesso = false;
        }
    }

    public function retornaSaldoPreOrdem($pdo = null, $condicao = '', $subCondicao = '') {
        if (!empty($pdo) && !empty($condicao)) {
            try {
                $sql = "SELECT
                        CASE WHEN mat.tp_material = 'C' OR mat.tp_material = 'P' 
                        THEN  item.qt_itens
                        -
                        coalesce((select
                        CASE WHEN m.tp_material = 'C' OR m.tp_material = 'P' 
                        THEN coalesce(sum(it.qt_itens),0.0000)
                        ELSE coalesce(sum((it.qt_itens * it.vl_itens)),0.0000)
                        END as busca
                        from fin_cont_itens as it
                        inner join pla_material as m
                        ON m.id_material = it.id_material
                        where it.id_cont_itens_alt =  item.id_cont_itens
                        group by m.tp_material)
                        ,0.0000)
                        -
                        coalesce((select 
                        CASE WHEN m.tp_material = 'C' OR m.tp_material = 'P' 
                        THEN coalesce(sum(pre.qt_itens_pre),0.0000)
                        ELSE coalesce(sum((pre.vl_total)),0.0000)
                        END as busca
                        from fin_pre_ordem as pre 
                        inner join fin_pedido as p
                        on p.id_pedido = pre.id_pedido
                        inner join fin_cont_itens as it
                        on it.id_cont_itens = pre.id_cont_itens
                        inner join pla_material as m
                        on m.id_material = it.id_material
                        where p.st_pedido > '0'
                        and pre.id_fornecedor = f.id_fornecedor
                        and pre.id_cont_itens = item.id_cont_itens " . $subCondicao . "
                        group by m.tp_material)
                        ,0.0000)
                        /*Fim*/
                        ELSE (item.qt_itens * item.vl_itens)
                        -
                        coalesce((select
                        CASE WHEN m.tp_material = 'C' OR m.tp_material = 'P' 
                        THEN coalesce(sum(it.qt_itens),0.0000)
                        ELSE coalesce(sum((it.qt_itens * it.vl_itens)),0.0000)
                        END as busca
                        from fin_cont_itens as it
                        INNER JOIN pla_material as m
                        ON m.id_material = it.id_material
                        where it.id_cont_itens_alt =  item.id_cont_itens
                        group by m.tp_material),
                        0.0000)
                        -
                        coalesce((select 
                        CASE WHEN m.tp_material = 'C' OR m.tp_material = 'P' 
                        THEN coalesce(sum(pre.qt_itens_pre),0.0000)
                        ELSE coalesce(sum((pre.qt_itens_pre * pre.vl_itens_pre)),0.0000)
                        END as busca
                        from fin_pre_ordem as pre 
                        inner join fin_pedido as p
                        on p.id_pedido = pre.id_pedido
                        inner join fin_cont_itens as it
                        on it.id_cont_itens = pre.id_cont_itens
                        inner join pla_material as m
                        on m.id_material = it.id_material
                        where p.st_pedido > '0'
                        and pre.id_fornecedor = f.id_fornecedor
                        and pre.id_cont_itens = item.id_cont_itens " . $subCondicao . " 
                        group by m.tp_material)
                        ,0.0000)
                        END as saldo
                        FROM fin_fornecedor as f
                        INNER JOIN  fin_cont_itens as item
                        ON item.id_fornecedor = f.id_fornecedor
                        INNER JOIN pla_material as mat
                        ON mat.id_material = item.id_material " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (Error $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    public function updateValorPedido(PDO $pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "update fin_pedido 
                        set vl_pedido = (select sum(pre.qt_itens_pre * pre.vl_itens_pre) 
                                         from fin_pre_ordem as pre 
                                         where pre.id_pedido = :pedido
                                         )
                        where id_pedido = :pedido";
                
                $sql = "update fin_pedido 
                        set vl_pedido = (SELECT SUM(CASE 
                                        WHEN (M.tp_material = 'C' or M.tp_material = 'P') and CI.fl_valor_variavel = '0' 
                                        THEN coalesce((pre.qt_itens_pre * pre.vl_itens_pre), 0.0000)
                                        WHEN M.tp_material = 'S' or CI.fl_valor_variavel = '1'
                                        THEN coalesce(PRE.vl_total, 0.0000)
                                        END) valor
                                        FROM fin_pre_ordem as PRE
                                        INNER JOIN fin_cont_itens CI ON CI.id_cont_itens = PRE.id_cont_itens
                                        INNER JOIN pla_material M ON M.id_material = CI.id_material
                                        WHERE PRE.id_pedido = :pedido
                                         )
                        where id_pedido = :pedido";
                
                $sql = "update fin_pedido 
                        set vl_pedido = (SELECT SUM(coalesce(PRE.vl_total, 0.0000)) valor
                                        FROM fin_pre_ordem as PRE
                                        INNER JOIN fin_cont_itens CI ON CI.id_cont_itens = PRE.id_cont_itens
                                        INNER JOIN pla_material M ON M.id_material = CI.id_material
                                        WHERE PRE.id_pedido = :pedido
                                         )
                        where id_pedido = :pedido";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (Exception $ex) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    public function updateStatusPedidoOrdem(PDO $pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "update fin_pedido SET st_pedido = '11' where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (Exception $ex) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }

    public function removeItemPreOrdem(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_pre_ordem where id_pre_ordem = :idPreOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idPreOrdem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function verificarItemEmOrdem(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pre_ordem from fin_ordem_itens where id_pre_ordem = :idPreOrdem ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idPreOrdem", $this->getIdPreOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            }
        } catch (Exception $ex) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

}
