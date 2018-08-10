<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinItensTb.class.php";

class DaoFinItens extends FinItensTb {

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
    public function Sucesso() {
        return $this->sucesso;
    }

    /**
     * [cadastrarItemAta é responsável por armazena a ATA no banco de dados]
     * @param  [type] $pdo [Conexão com o banco]
     */
    public function cadastrarItem($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_cont_itens (nr_item, nr_lote, nm_marca, nm_modelo, ds_itens, qt_itens, pc_desconto, vl_itens, id_material, id_fornecedor, id_cont_itens_alt, id_unidade_medida)
                VALUES (:nrItem, :lote, :marca, :modelo, :dsItem, :qtd, :desconto, :vl, :material, :fornecedor, :fornecedor_alt, :unidadeMedida)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nrItem", $this->getNrItem(), PDO::PARAM_INT);
                $stmt->bindValue(":lote", $this->getNrLote(), PDO::PARAM_STR);
                $stmt->bindValue(":marca", $this->getNmMarca(), PDO::PARAM_STR);
                $stmt->bindValue(":modelo", $this->getNmModelo(), PDO::PARAM_STR);
                $stmt->bindValue(":dsItem", $this->getDescItem(), PDO::PARAM_STR);
                $stmt->bindValue(":qtd", $this->getQtItens(), PDO::PARAM_STR);
                $stmt->bindValue(":desconto", $this->getPcDesconto(), PDO::PARAM_STR);
                $stmt->bindValue(":vl", $this->getVlItens(), PDO::PARAM_STR);
                $stmt->bindValue(":material", $this->getIdMaterial(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor_alt", $this->getIdContItensAlt(), PDO::PARAM_INT);
                $stmt->bindValue(":unidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
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

    /**
     * [retornaItens é responsável por retorna os itens da ata]
     * @param  [type] $pdo [Conexão com o banco]
     * @return string      [ser tudo de certo retorna um array com os itens da ata]
     */
    public function retornaItens($pdo = null, $condicao = '') {
        if (!empty($pdo)) {
            try {
                
                $sql = "select material.cd_desc_material,material.nm_material,material.nm_desc_material,material.nm_grupo, material.nm_sub_grupo,material.cd_elemento_despesa,
                        material.tp_material,item.nr_lote,item.nm_marca,item.nm_modelo,item.qt_itens,item.vl_itens,item.pc_desconto,item.id_fornecedor,item.id_cont_itens,
                        item.ds_itens, unid.nm_unidade_medida,item.nr_item, material.cd_desc_material,
                        CASE
                                WHEN item.pc_desconto is not null or item.pc_desconto <> '0'
                            THEN ((item.qt_itens * item.vl_itens)-((item.pc_desconto*(item.qt_itens * item.vl_itens))/100))
                            ELSE (item.qt_itens * item.vl_itens)
                        END as total,


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
                        +
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
                                  and pre.id_cont_itens = item.id_cont_itens
                                  group by m.tp_material)
                        ,0.0000)
                        as utilizado,
                        
                                CASE WHEN material.tp_material = 'C' OR material.tp_material = 'P'
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
                        and pre.id_cont_itens = item.id_cont_itens
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
                        inner join pla_material as m
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
                                  and pre.id_cont_itens = item.id_cont_itens
                                  group by m.tp_material)
                        ,0.0000)

                        END as saldo,
                        
                        (
						  (item.qt_itens * item.vl_itens)
	                        -
	                        coalesce((select coalesce(sum((it.qt_itens * it.vl_itens)),0.0000) as busca
			                       	from fin_cont_itens as it
			                         inner join pla_material as m
			                         ON m.id_material = it.id_material
			                         where it.id_cont_itens_alt =  item.id_cont_itens
			                         group by m.tp_material), 0.0000)
	                        -
	                        coalesce((select coalesce(sum((pre.qt_itens_pre * pre.vl_itens_pre)),0.0000) as busca
	                                  from fin_pre_ordem as pre 
	                                  inner join fin_pedido as p
	                                  on p.id_pedido = pre.id_pedido
	                                  inner join fin_cont_itens as it
	                                  on it.id_cont_itens = pre.id_cont_itens
	                                  inner join pla_material as m
	                                  on m.id_material = it.id_material
                                          where p.st_pedido > '0'
	                                  and pre.id_fornecedor = f.id_fornecedor
	                                  and pre.id_cont_itens = item.id_cont_itens
	                                  group by m.tp_material),0.0000)
						) 
                        as totalSaldo

                        from fin_fornecedor as f
                        inner join fin_cont_itens as item
                        on f.id_fornecedor  = item.id_fornecedor
                        inner join pla_material as material
                        on material.id_material = item.id_material
                        inner join pla_unidade_medida as unid
                        on unid.id_unidade_medida = item.id_unidade_medida " . $condicao. " order by item.nr_lote, item.nr_item";
                
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

    /**
     * [editarItensAta Método resposável por editar os itens da ata]
     * @param  [type] $pdo [Conexão com o banco]
     */
    public function editarItens($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "update fin_cont_itens SET nr_item = :nrItem, id_material = :idMaterial, nr_lote = :lote, nm_marca = :marca, nm_modelo = :modelo,
                qt_itens = :qtd, vl_itens = :vl, pc_desconto = :desconto, ds_itens = :dsItem, id_unidade_medida = :unid
                where id_cont_itens = :idContItens and id_fornecedor = :fornecedor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nrItem", $this->getNrItem(), PDO::PARAM_INT);
                $stmt->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
                $stmt->bindValue(":lote", $this->getNrLote(), PDO::PARAM_STR);
                $stmt->bindValue(":marca", $this->getNmMarca(), PDO::PARAM_STR);
                $stmt->bindValue(":modelo", $this->getNmModelo(), PDO::PARAM_STR);
                $stmt->bindValue(":qtd", $this->getQtItens(), PDO::PARAM_STR);
                $stmt->bindValue(":vl", $this->getVlItens(), PDO::PARAM_STR);
                $stmt->bindValue(":desconto", $this->getPcDesconto(), PDO::PARAM_STR);
                $stmt->bindValue(":dsItem", $this->getDescItem(), PDO::PARAM_STR);
                $stmt->bindValue(":idContItens", $this->getIdContItens(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->bindValue(":unid", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (Error $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    /**
     * [excluirItemAta método responsável por excluir um item da ata do sistema]
     * @param  [type] $pdo [Conexão com o banco]
     */
    public function excluirItem($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "delete from fin_cont_itens where id_cont_itens = :idItens";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idItens", $this->getIdContItens(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (Error $e) {
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    /**
     * [retornaItensPorID método responsável por retorna os itens da ata de acordo com os itens informado]
     * @param  [type] $pdo [Conexão com o banco]
     * @param  [type] $ids [String com os ids da ata]
     */
    public function retornaItensPorID($pdo = null, $ids = null) {
        if (!empty($pdo) && !empty($ids)) {
            try {
                $sql = "select material.id_material, material.cd_desc_material, material.nm_material, material.nm_desc_material, material.nm_grupo, material.nm_sub_grupo,
						material.cd_elemento_despesa, material.tp_material, item.nr_lote, item.nm_marca, item.nm_modelo, item.qt_itens, item.vl_itens, item.pc_desconto,
						item.id_cont_itens,id_cont_itens_alt, f.id_fornecedor, item.id_unidade_medida, item.nr_item, item.ds_itens,
						CASE
						WHEN item.pc_desconto is not null or item.pc_desconto <> '0'
						THEN ((item.qt_itens * item.vl_itens)-((item.pc_desconto*(item.qt_itens * item.vl_itens))/100))
						ELSE (item.qt_itens * item.vl_itens)
						END as total
						from fin_fornecedor as f
						inner join fin_cont_itens as item
						on item.id_fornecedor = f.id_fornecedor
						inner join pla_material as material
						on material.id_material = item.id_material
						where id_cont_itens in(" . $ids . ")  order by item.nr_item";
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

    /**
     * [retornaItensSaldo Retorna todas informações dos item e saldo que existem para consumo]
     * @param  [type] $pdo [Conexão com o banco]
     */
    public function retornaItensAtaSaldo($pdo) {
        if (!empty($pdo)) {
            try {
                $sql = "SELECT f.id_fornecedor, item.id_cont_itens, mat.nm_material, mat.nm_desc_material, mat.nm_grupo, mat.nm_sub_grupo,
						mat.cd_elemento_despesa, mat.tp_material, item.nr_lote, item.qt_itens, item.vl_itens,
						item.pc_desconto, unid.nm_unidade_medida, item.nr_item, mat.cd_desc_material,
						CASE WHEN mat.tp_material = 'C' OR mat.tp_material = 'P'
						THEN  item.qt_itens
						ELSE (item.qt_itens * item.vl_itens)
						END as total,

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
                                                
                                                +
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
                                                          and pre.id_cont_itens = item.id_cont_itens
                                                         group by m.tp_material)
                                                ,0.0000)
                                                as utilizado,

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
                                                          and pre.id_cont_itens = item.id_cont_itens
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
								inner join pla_material as m
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
                                                          and pre.id_cont_itens = item.id_cont_itens
                                                         group by m.tp_material)
                                                ,0.0000)

						END as saldo

						FROM fin_fornecedor as f
						INNER JOIN  fin_cont_itens as item
						ON item.id_fornecedor = f.id_fornecedor
						INNER JOIN pla_material as mat
						ON mat.id_material = item.id_material
                                                INNER JOIN pla_unidade_medida as unid
                                                ON unid.id_unidade_medida = item.id_unidade_medida
						where f.id_fornecedor = :fornecedor order by item.nr_lote, item.nr_item";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
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
        }
    }

    /**
     * [retornaItensPorSubElemento Retorna todas informações dos item e saldo por sub-elemento]
     * @param  [type] $pdo [Conexão com o banco]
     */
    public function retornaItensPorSubElemento($pdo = null, $subElemento = null) {
        if (!empty($pdo) && !empty($subElemento)) {
            try {
                $sql = "SELECT f.id_fornecedor, item.id_cont_itens, item.ds_itens, mat.nm_material, mat.nm_desc_material, mat.nm_grupo, mat.nm_sub_grupo,
						mat.cd_elemento_despesa, mat.tp_material, item.nr_lote, item.qt_itens, item.vl_itens,
						item.pc_desconto, item.nr_item, unid.nm_unidade_medida, mat.cd_desc_material,
						CASE WHEN mat.tp_material = 'C' OR mat.tp_material = 'P'
						THEN  item.qt_itens
						ELSE (item.qt_itens * item.vl_itens)
						END as total,

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
                                                
                                                +  
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
                                                          and pre.id_fornecedor = :fornecedor
                                                          and pre.id_cont_itens = item.id_cont_itens
                                                          and p.id_despesa = :subElemento
                                                         group by m.tp_material)
                                                ,0.0000)
                                                
                                                as utilizado,

						CASE WHEN mat.tp_material = 'C' OR mat.tp_material = 'P'
						THEN  item.qt_itens
						-
						coalesce((select
								CASE WHEN m.tp_material = 'C'
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
                                                          and pre.id_fornecedor = :fornecedor
                                                          and pre.id_cont_itens = item.id_cont_itens
                                                          and p.id_despesa = :subElemento
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
								inner join pla_material as m
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
                                                          and pre.id_fornecedor = :fornecedor
                                                          and pre.id_cont_itens = item.id_cont_itens
                                                          and p.id_despesa = :subElemento
                                                         group by m.tp_material)
                                                ,0.0000)

						END as saldo

						FROM fin_fornecedor as f
						INNER JOIN  fin_cont_itens as item
						ON item.id_fornecedor = f.id_fornecedor
						INNER JOIN pla_material as mat
						ON mat.id_material = item.id_material
                                                INNER JOIN pla_unidade_medida as unid
						ON unid.id_unidade_medida = item.id_unidade_medida
						where f.id_fornecedor = :fornecedor
						AND mat.id_despesa = :subElemento
                                                order by item.nr_lote, item.nr_item";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->bindValue(":subElemento", $subElemento, PDO::PARAM_INT);
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
        }
    }

    /**
     * []
     * @param  [type] $pdo [Conexão com o banco]
     */
    public function retornaSaldoItemAta($pdo = null, $condicao = '', $subCondicao = '') {
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
						" . $subCondicao . "
						group by m.tp_material)
						,0.0000)
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
                                                          and pre.id_cont_itens = item.id_cont_itens
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
						" . $subCondicao . "
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
                                                          and pre.id_cont_itens = item.id_cont_itens
                                                         group by m.tp_material)
                                                ,0.0000)

						END as saldo

						FROM fin_fornecedor as f
						INNER JOIN  fin_cont_itens as item
						ON item.id_fornecedor = f.id_fornecedor
						INNER JOIN pla_material as mat
						ON mat.id_material = item.id_material " . $condicao . " ";
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

    public function valorUtilizadoItem($pdo = null, $condicao = '') {
        if (!empty($pdo) && !empty($condicao)) {
            try {
                $sql = "select
						coalesce((select
							  CASE WHEN m.tp_material = 'C'
							  THEN coalesce(sum(it.qt_itens),0.0000)
						          ELSE coalesce(sum((it.qt_itens * it.vl_itens)),0.0000)
							  END as busca
							  from fin_cont_itens as it
							  inner join pla_material as m
							  ON m.id_material = it.id_material
							  where it.id_cont_itens_alt =  item.id_cont_itens
							  group by m.tp_material
							  )
							,0.0000) as utilizado
						from fin_cont_itens as item " . $condicao;
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
    
    public function retornaItensFornecedor($pdo){
        if (!empty($pdo)){
            try{
                $sql = "SELECT F.id_fornecedor"
                    . " , ITEM.id_cont_itens, ITEM.nr_lote, ITEM.qt_itens, ITEM.vl_itens"
                    . " , ITEM.pc_desconto, ITEM.nr_item, ITEM.nm_marca, ITEM.nm_modelo"
                    . " , ITEM.fl_valor_variavel, ITEM.ds_itens"
                    . " , ITEM.id_material, ITEM.id_cont_itens_alt, ITEM.id_cont_itens_aditivo"
                    . " , ITEM.id_unidade_medida"
                    . " , MAT.nm_material, MAT.nm_desc_material, MAT.nm_grupo, MAT.nm_sub_grupo"
                    . " , MAT.cd_elemento_despesa, MAT.tp_material"
                    . " , UNID.nm_unidade_medida, MAT.cd_desc_material"
                    . " FROM fin_fornecedor F"
                    . " INNER JOIN fin_cont_itens AS ITEM ON ITEM.id_fornecedor = F.id_fornecedor"
                    . " INNER JOIN pla_material AS MAT ON MAT.id_material = ITEM.id_material"
                    . " INNER JOIN pla_unidade_medida AS UNID ON UNID.id_unidade_medida = ITEM.id_unidade_medida"
                    . " WHERE F.id_fornecedor = :fornecedor"
                    . " ORDER BY ITEM.nr_lote, ITEM.nr_item";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (Error $e){
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }
    
    public function cadastrarItemAditivo($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_cont_itens (nr_item, nr_lote, nm_marca, nm_modelo, qt_itens, vl_itens, pc_desconto"
                        . " , fl_valor_variavel, ds_itens, id_material, id_fornecedor, id_cont_itens_alt, id_unidade_medida"
                        . " , id_cont_itens_aditivo)"
                        . " VALUES (:nrItem, :lote, :marca, :modelo, :qtd, :vl, :desconto"
                        . " , :flValorVariavel, :dsItem"
                        . " , :material, :fornecedor, :fornecedor_alt, :unidadeMedida, :idContItensAditivo)";                    
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nrItem", $this->getNrItem(), PDO::PARAM_INT);
                $stmt->bindValue(":lote", $this->getNrLote(), PDO::PARAM_STR);
                $stmt->bindValue(":marca", $this->getNmMarca(), PDO::PARAM_STR);
                $stmt->bindValue(":modelo", $this->getNmModelo(), PDO::PARAM_STR);
                $stmt->bindValue(":qtd", $this->getQtItens(), PDO::PARAM_STR);
                $stmt->bindValue(":vl", $this->getVlItens(), PDO::PARAM_STR);
                $stmt->bindValue(":desconto", $this->getPcDesconto(), PDO::PARAM_STR);
                $stmt->bindValue(":flValorVariavel", $this->getFlValorVariavel(), PDO::PARAM_STR);                
                $stmt->bindValue(":dsItem", $this->getDescItem(), PDO::PARAM_STR);                                                
                $stmt->bindValue(":material", $this->getIdMaterial(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor_alt", $this->getIdContItensAlt(), PDO::PARAM_INT);
                $stmt->bindValue(":unidadeMedida", $this->getIdUnidadeMedida(), PDO::PARAM_INT);
                $stmt->bindValue(":idContItensAditivo", $this->getIdContItensAditivo(), PDO::PARAM_INT);
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
    
    public function retornaItensFornecedorSemJoins($pdo){
        if (!empty($pdo)){
            try{
                $sql = "SELECT "
                    . " ITEM.id_cont_itens, ITEM.nr_item, ITEM.nr_lote, ITEM.nm_marca"
                    . " , ITEM.nm_modelo, ITEM.qt_itens, ITEM.vl_itens"
                    . " , ITEM.pc_desconto, ITEM.fl_valor_variavel"
                    . " , ITEM.ds_itens, ITEM.id_material"
                    . " , ITEM.id_fornecedor, ITEM.id_cont_itens_alt"
                    . " , ITEM.id_cont_itens_aditivo, ITEM.id_unidade_medida"                                            
                    . " FROM fin_cont_itens AS ITEM"                    
                    . " WHERE ITEM.id_fornecedor = :fornecedor";
                    
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (Error $e){
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }
    
    public function retorna($pdo){
        if (!empty($pdo)){
            try{
                $sql = "SELECT *"
                    . " FROM fin_cont_itens"                    
                    . " WHERE id_cont_itens = :idContItens";
                    
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContItens", $this->getIdContItens(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (Error $e){
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }
    
    public function quantidadeItensExecutado(string $itens, PDO $pdo = null){
        if (!empty($pdo)){
            try {
                $sql = "SELECT CI.id_cont_itens, CI.qt_itens, CI.vl_itens"
                        . " , COALESCE(sum(FPO.qt_itens_pre), 0) as qtd_quantitativo"
                        . " , (CI.qt_itens - COALESCE(sum(FPO.qt_itens_pre), 0)) as saldo_quantitativo"
                        . " FROM fin_cont_itens CI"
                        . " LEFT JOIN fin_pre_ordem FPO ON FPO.id_cont_itens = CI.id_cont_itens"
                        . " LEFT JOIN fin_pedido FP ON FP.id_pedido = FPO.id_pedido AND FP.st_pedido > '0'"
                        . " WHERE CI.id_cont_itens IN (".$itens.")"
                        . " GROUP BY CI.id_cont_itens";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0){
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = "Sem Itens";
                    $this->sucesso = false;
                }
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        }else{
            $this->sucesso = false;
            $this->msgRetorno = "PDO FAIL";
        }
    }
    
    
    public function retornaContratosPorMaterial($pdo){
        if (!empty($pdo)){
            try{
                $sql = "SELECT C.id_contrato, C.ds_objeto, C.nr_contrato"
                    . " , to_char(C.dt_ini_vigencia_contrato, 'DD/MM/YYYY') as dt_ini_vigencia_contrato"
                    . " , to_char(C.dt_fim_vigencia_contrato, 'DD/MM/YYYY') as dt_fim_vigencia_contrato"
                    . " , P.nm_pessoa"
                    . " , C.tp_contrato, TG.nm_tipo_gasto"
                    . " FROM fin_cont_itens CI"
                    . " INNER JOIN fin_fornecedor F ON F.id_fornecedor = CI.id_fornecedor"
                    . " INNER JOIN ses_pessoa P ON P.id_pessoa = F.id_pessoa"
                    . " INNER JOIN fin_contrato C ON C.id_contrato = F.id_contrato"
                    . " INNER JOIN pla_tipo_gasto TG ON TG.id_tipo_gasto = C.id_tipo_gasto"
                    . " WHERE CI.id_material = :idMaterial AND C.st_ativo ='1'";
                    
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idMaterial", $this->getIdMaterial(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } catch (Error $e){
                $this->msgRetorno = $e->getMessage();
                $this->sucesso = false;
            }
        }
    }
    
    

}
