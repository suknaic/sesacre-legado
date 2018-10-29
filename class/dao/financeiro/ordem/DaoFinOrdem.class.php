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

    /**
     * Cadastrar ordem
     * @param PDO $pdo
     */
    public function cadastrarOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
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
            $this->msgRetorno = $ex->getMessage() . '1';
        }
    }

    /**
     * Retorna os itens da pre ordem 
     * @param PDO $pdo
     */
    public function listaItensPreOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select pedido.id_pedido, pre.id_pre_ordem, itens.nr_item, mat.nm_material, mat.nm_grupo, mat.nm_sub_grupo,
                        unid.nm_unidade_medida, desp.ds_despesa_elemento, mat.tp_material, pre.qt_itens_pre, pre.vl_itens_pre,
                        mat.nm_desc_material, itens.nr_lote, itens.fl_valor_variavel, (pre.qt_itens_pre * pre.vl_itens_pre ) as total,
                        mat.cd_desc_material,
                        case 
                                when (mat.tp_material = 'C' or mat.tp_material = 'P') and itens.fl_valor_variavel = '0' 
                            then  coalesce(ordemItens.qt_itens_ordem,'0.0000') + coalesce(entregas.qt_itens_entrega,'0.0000')
                            when mat.tp_material = 'S' or itens.fl_valor_variavel = '1'
                            then coalesce(ordemItens.total,'0.0000') + coalesce(entregas.total,'0.0000')
                        end utilizado,
                        coalesce(ordemItens.qt_itens_ordem,'0.0000') + coalesce(entregas.qt_itens_entrega,'0.0000') as qt_utilizado,
                        coalesce(ordemItens.total,'0.0000') + coalesce(entregas.total,'0.0000') as vl_utilizado,

                        case 
                                when (mat.tp_material = 'C' or mat.tp_material = 'P') and itens.fl_valor_variavel = '0' 
                            then (pre.qt_itens_pre - coalesce(ordemItens.qt_itens_ordem,'0.0000') - coalesce(entregas.qt_itens_entrega,'0.0000'))
                            when mat.tp_material = 'S' or itens.fl_valor_variavel = '1'
                            then (pre.vl_total - coalesce(ordemItens.total,'0.0000') - coalesce(entregas.total,'0.0000'))
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
                        where pedido.id_pedido = :pedido
                        order by itens.nr_lote, itens.nr_item";
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

    /**
     * Retorna o valor da pre ordem para seta no banco
     * @param PDO $pdo
     * @param int $pre
     */
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

    /**
     * Retorna o numero da ultima ordem feita no sistema
     * @param PDO $pdo
     * @return boolean
     */
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

    /**
     * Retorna as ordem para tela de pesquisa da ordem 
     * @param PDO $pdo
     * @param string $condicao
     * @param int $ano
     */
    public function retornaDadosTrPesquisa(PDO $pdo, string $condicao, int $ano) {
        try {
            if (!empty($pdo)) {
                
                $sql = "select ordem.id_ordem, p.id_pedido, concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as pedido,
                        p.ds_pedido, tg.nm_tipo_gasto, f.nr_fonte, desp.cd_despesa_elemento, desp.ds_despesa_elemento, ordem.nr_ordem, ordem.tp_ordem, ordem.sit_ordem,
                        valorOrdem.valor,
                        case 
                            when ordem.tp_ordem = '1' THEN 'ENTREGA'
                            when ordem.tp_ordem = '2' THEN 'EXECUÇÃO/SERVIÇO'
                        END as tipo, 
                        case 
                            when ordem.sit_ordem = '1' THEN 'Cadastrado'
                            when ordem.sit_ordem = '2' THEN 'Requisitado'
                            when ordem.sit_ordem = '3' THEN 'Finalizado'
                            when ordem.sit_ordem = '4' THEN 'Finalizado por Supressão do Ordenado'
                            when ordem.sit_ordem = '5' THEN 'Finalizado por Descumprimento da Contratada'
                        END as situacao

                        from fin_pedido as p

                        inner join fin_ordem as ordem
                        on ordem.id_pedido = p.id_pedido

                        inner join pla_tipo_gasto as tg
                        on tg.id_tipo_gasto = p.id_tipo_gasto

                        inner join fin_fonte as f
                        on f.id_fonte = p.id_fonte

                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento

                        inner join (select itemOrdem.id_ordem, round(sum((itemOrdem.qt_itens_ordem * itemOrdem.vl_itens_ordem)),4) as valor
                                    from fin_ordem_itens as itemOrdem
                                    group by itemOrdem.id_ordem
                        ) as valorOrdem
                        on valorOrdem.id_ordem = ordem.id_ordem

                        where ordem.sit_ordem > '0' and ordem.aa_ordem = :ano " . $condicao . " order by ordem.nr_ordem";
                
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

    /**
     * Retorna prazo de entrega do fornecedor
     * @param PDO $pdo
     */
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

    /**
     * Retorna Quantidade de ordem por tipo para o grafico inical do sistema
     * @param PDO $pdo
     */
    public function retornaQuantidadeTipo(PDO $pdo = null) {
        try {
            $sql = "SELECT "
                    . " tp_ordem, count(id_ordem) AS quantidade"
                    . " FROM fin_ordem"
                    . " WHERE aa_ordem = :aaOrdem"
                    . " GROUP BY tp_ordem";

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":aaOrdem", date("Y"), PDO::PARAM_STR);
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
     * Atualiza o status da ordem para que ela fique desativada
     * @param PDO $pdo
     */
    public function deleteOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_ordem set sit_ordem = 0 where id_ordem = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    /**
     * Retorna toda as informaçoes da ordem especifica informado
     * @param PDO $pdo
     */
    public function retornaOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_ordem where id_ordem = :idOrdem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idOrdem", $this->getIdOrdem(), PDO::PARAM_INT);
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

    public function ordemGdof(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select ordem.id_ordem, ordem.nr_ordem, ordem.aa_ordem 
                        from fin_ordem as ordem
                        inner join fin_protocolo as protocolo
                        on protocolo.id_ordem  = ordem.id_ordem
                        where ordem.id_pedido = :pedido
                        and (ordem.sit_ordem in('3', '4', '5') OR ordem.tp_ordem = '2')";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
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

    public function retornaTipoValor(PDO $pdo) {
        try {
            if (!empty($pdo)) {

                $sql = "select ordem.id_ordem, (ordem.nr_ordem || '/' || ordem.aa_ordem) as ordem,
                        case 
                                when ordem.tp_ordem = '1' then 'ENTREGA'
                                when ordem.tp_ordem = '2' then 'EXECURÇÃO/SERVIÇO'
                        end tipo,
                        case
                            when ordem.sit_ordem = '0' then 'Cancelada'
                            when ordem.sit_ordem = '1' THEN 'Cadastrado'
                            when ordem.sit_ordem = '2' THEN 'Requisitado'
                            when ordem.sit_ordem = '3' THEN 'Finalizado'
                            when ordem.sit_ordem = '4' THEN 'Finalizado por Supresão do Ordenado'
                            when ordem.sit_ordem = '5' THEN 'Finalizado por Descumprimento da Contratada'
                        end situacao,

                        trim(to_char(sum(itensOrdem.qt_itens_ordem * itensOrdem.vl_itens_ordem),'999G999G990D0999')) as valor
                        from fin_ordem as ordem

                        inner join fin_ordem_itens as itensOrdem
                        on itensOrdem.id_ordem = ordem.id_ordem

                        inner join fin_pre_ordem as pre
                        on pre.id_pre_ordem = itensOrdem.id_pre_ordem

                        inner join fin_cont_itens as itens 
                        on itens.id_cont_itens = pre.id_cont_itens

                        inner join pla_material as mat
                        on mat.id_material = itens.id_material
                        where ordem.id_ordem = :ordem
                        and (ordem.sit_ordem in('3', '4', '5') OR ordem.tp_ordem = '2')
                        group by ordem.id_ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
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

    public function atualizaSituacaoOrden(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_ordem set sit_ordem = :situacao where id_ordem = :ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":situacao", $this->getSitOrdem(), PDO::PARAM_STR);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "erro conexao";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaSituacaoOrdem(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select sit_ordem from fin_ordem where id_ordem = :ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ordem", $this->getIdOrdem(), PDO::PARAM_INT);
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
    
    public function retornaEntregasOrdem(PDO $pdo){
        try {
            if (!empty($pdo)) {
                $sql = "select
                            entItens.* 
                         from
                            fin_ordem as ordem 
                            inner join
                               fin_entrega_confirmacao as entConf 
                               on entConf.id_ordem = ordem.id_ordem 
                            inner join
                               fin_ordem_itens as ordemItens 
                               on ordemItens.id_ordem = ordem.id_ordem
                            inner join
                               fin_entrega_itens as entItens
                               on entItens.id_entrega_confirmacao = entConf.id_entrega_confirmacao
                         where
                            ordem.id_ordem = :id_ordem
                            and entConf.sit_entrega > '0'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_ordem", $this->getIdOrdem(), PDO::PARAM_INT);
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
    
    public function ordemProtocolo(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        try {
            if (!empty($pdo)) {
                $sql = "select * from fin_protocolo where id_ordem = :id_ordem";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_ordem", $this->getIdOrdem(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    /**
     * 
     * @param type $itens
     * @param PDO $pdo
     */
    public function listaItensPreOrdemPorPreOrdem($itens, PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select pedido.id_pedido, pre.id_pre_ordem, itens.nr_item, mat.nm_material, mat.nm_grupo, mat.nm_sub_grupo,
                        unid.nm_unidade_medida, desp.ds_despesa_elemento, mat.tp_material, pre.qt_itens_pre, pre.vl_itens_pre,
                        mat.nm_desc_material, itens.nr_lote, itens.fl_valor_variavel, pre.vl_total as total,
                        case 
                                when (mat.tp_material = 'C' or mat.tp_material = 'P') and itens.fl_valor_variavel = '0' 
                            then  coalesce(ordemItens.qt_itens_ordem,'0.0000') + coalesce(entregas.qt_itens_entrega,'0.0000')
                            when mat.tp_material = 'S' or itens.fl_valor_variavel = '1'
                            then coalesce(ordemItens.total,'0.0000') + coalesce(entregas.total,'0.0000')
                        end utilizado,

                        coalesce(ordemItens.qt_itens_ordem,'0.0000') + coalesce(entregas.qt_itens_entrega,'0.0000') as qt_utilizado,

                        coalesce(ordemItens.total,'0.0000') + coalesce(entregas.total,'0.0000') as vl_utilizado,


                        case 
                                when (mat.tp_material = 'C' or mat.tp_material = 'P') and itens.fl_valor_variavel = '0' 
                            then (pre.qt_itens_pre - coalesce(ordemItens.qt_itens_ordem,'0.0000') - coalesce(entregas.qt_itens_entrega,'0.0000'))
                            when mat.tp_material = 'S' or itens.fl_valor_variavel = '1'
                            then (pre.vl_total - coalesce(ordemItens.total,'0.0000') - coalesce(entregas.total,'0.0000'))
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
                        where pre.id_pre_ordem in ( ".$itens." )";                        
                $stmt = $pdo->prepare($sql);                
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
    

}
