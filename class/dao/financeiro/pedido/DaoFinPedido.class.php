<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/pedido/FinPedidoTb.class.php";

class DaoFinPedido extends FinPedidoTb {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /**
     * [cadastrarFinPedido esse metodo e responsavel por cadastra o pedido de necessidade no banco de dados]
     * @param  [type] $pdo [conexao com o banco de dados]
     * @return [type]      [true = caso consiga grava o pedido no banco; false =  caso nao consiga grava]
     */
    public function cadastrarFinPedido($pdo = null) {

        try {
            if (!empty($pdo)) {
                $sql = "INSERT INTO fin_pedido (nr_pedido, id_tipo_solicitacao, id_fornecedor, id_fonte, id_programa_trabalho, id_despesa_elemento,
                id_despesa,id_tipo_gasto,id_lotacao,ds_pedido, vl_pedido, st_pedido) VALUES (:numero, :tipo, :fornecedor, :fonte, :prograna, :despesaElemento,
                :despesa, :tipoGasto, :lotacao, :descricao, :valor, :situacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrPedido(), PDO::PARAM_STR);
                $stmt->bindValue(":tipo", $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
                $stmt->bindValue(":fornecedor", $this->getIdFornecedor(), PDO::PARAM_INT);
                $stmt->bindValue(":fonte", $this->getIdFonte(), PDO::PARAM_INT);
                $stmt->bindValue(":prograna", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
                $stmt->bindValue(":despesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
                $stmt->bindValue(":despesa", $this->getIdDespesa(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":descricao", $this->getDsPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":valor", $this->getVlPedido(), PDO::PARAM_STR);
                $stmt->bindValue("situacao", $this->getStPedido(), PDO::PARAM_INT);
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
     * [cadastrarFinPedido esse metodo e responsavel por cadastra o pedido de necessidade no banco de dados]
     * @param  [type] $pdo [conexao com o banco de dados]
     * @return [type]      [true = caso consiga grava o pedido no banco; false =  caso nao consiga grava]
     */
    public function cadastrarFinPedidoSemFornecedor($pdo = null) {

        try {
            if (!empty($pdo)) {
                $sql = "INSERT INTO fin_pedido (nr_pedido, id_tipo_solicitacao, id_fonte, id_programa_trabalho, id_despesa_elemento,
                id_despesa,id_tipo_gasto,id_lotacao,ds_pedido, vl_pedido, st_pedido) VALUES (:numero, :tipo,  :fonte, :prograna, :despesaElemento,
                :despesa, :tipoGasto, :lotacao, :descricao, :valor, :situacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrPedido(), PDO::PARAM_STR);
                $stmt->bindValue(":tipo", $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
                $stmt->bindValue(":fonte", $this->getIdFonte(), PDO::PARAM_INT);
                $stmt->bindValue(":prograna", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
                $stmt->bindValue(":despesaElemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
                $stmt->bindValue(":despesa", $this->getIdDespesa(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":descricao", $this->getDsPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":valor", $this->getVlPedido(), PDO::PARAM_STR);
                $stmt->bindValue("situacao", $this->getStPedido(), PDO::PARAM_INT);
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

    public function mudarJustificativa($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "UPDATE fin_pedido SET ds_pedido = :dsPedido WHERE id_pedido = :idPedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idPedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":dsPedido", $this->getDsPedido(), PDO::PARAM_STR);
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

    public function retornaDadosPedido($pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT * FROM fin_pedido WHERE id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Sem conexão';
                    $this->sucesso = false;
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
     * retorna o numero do pedido de necessidade
     * @param type $pdo
     */
    public function NumeroPedido(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select (COALESCE(MAX(id_pedido), '0')+1) as numero from fin_pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
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

    public function totalPedidoPorQdd(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select coalesce(sum(p.vl_pedido),0.0000)
                        from fin_pedido as p
                        where p.st_pedido > '0' 
                        and p.id_lotacao = :lotacao
                        and p.id_tipo_gasto = :tipoGasto
                        and p.id_programa_trabalho = :projeto
                        and p.id_fonte = :fonte
                        and p.id_despesa_elemento = :despesa";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
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

    public function retornaTodosPedidos(PDO $pdo = null) {
        try {
            $sql = "SELECT 
                      fin_pedido.nr_pedido, 
                      fin_tipo_solicitacao.nm_tipo_solicitacao, 
                      fin_pedido.ds_pedido, 
                      fin_pedido.vl_pedido, 
                      fin_pedido.dt_pedido, 
                      fin_pedido.st_pedido
                    FROM 
                      public.fin_pedido, 
                      public.fin_tipo_solicitacao
                    WHERE 
                      fin_pedido.id_tipo_solicitacao = fin_tipo_solicitacao.id_tipo_solicitacao";
            $stmt = $pdo->prepare($sql);
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

    public function retornaDadosPedidoOrdem(PDO $pdo, string $condicao = "") {
        try {
            if (!empty($pdo)) {
                $sql = "select p.id_pedido, concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as pedido, p.ds_pedido,
                        tp.nm_tipo_gasto, font.nr_fonte, desp.ds_despesa_elemento, p.vl_pedido,
                        concat(concat(cont.nr_contrato,'/') , to_char(cont.dt_ini_vigencia_contrato, 'yyyy'))  as contrato, cont.tp_contrato,
                        modalidade.nm_modalidade, pt.cd_programa_trabalho, pt.ds_programa_trabalho, emp.nr_empenho
                        from fin_pedido p 
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_fonte as font
                        on font.id_fonte =  p.id_fonte
                        inner join fin_fornecedor as f
                        on f.id_fornecedor = p.id_fornecedor
                        inner join fin_contrato as cont 
                        on cont.id_contrato =  f.id_contrato
                        inner join fin_programa_trabalho as pt
                        on pt.id_programa_trabalho  = p.id_programa_trabalho
                        inner join fin_empenho as emp
                        on emp.id_pedido = p.id_pedido
                        left join gco_processo as gcon
                        on gcon.id_processo = cont.id_processo
                        left join gco_modalidade as modalidade
                        on modalidade.id_modalidade = gcon.id_modalidade
                        where p.nr_pedido = :pedido " . $condicao;
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getNrPedido(), PDO::PARAM_INT);
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
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaPedidoPesquisa(PDO $pdo, $filter) {
        try {
            if (!empty($pdo)) {
                $sql = "select p.id_pedido, l.id_lotacao, p.nr_pedido, to_char(p.dt_pedido, 'YYYY') as ano, tipo.nm_tipo_solicitacao, font.nr_fonte,
                        desp.cd_despesa, desp.ds_despesa_elemento, tpGasto.nm_tipo_gasto, l.nm_lotacao, pessoa.nm_pessoa, p.vl_pedido, p.ds_pedido,
                        pt.cd_programa_trabalho, pt.ds_programa_trabalho, 
                        case
                         when p.st_pedido  = '9' THEN 'Aguardando finaliza a pre-ordem'
                         when p.st_pedido  = '10' THEN 'Aguardando autorização do responsável imediato' 
                         when p.st_pedido  = '11' THEN 'Aguardando autorização do responsável da central'
                         when p.st_pedido  = '12' THEN 'Aguardando autorização de orçamentário'
                         when p.st_pedido  = '13' THEN 'Aguardando autorização financeiro'
                         when p.st_pedido  = '14' THEN 'Aguardando autorização ordenador de despesa'
                         when p.st_pedido  = '15' THEN 'Aguardando empenho'
                         when p.st_pedido  = '16' THEN 'Aguardando ordem'
                        end as status
                        from fin_pedido as p
                        inner join fin_tipo_solicitacao as tipo
                        on tipo.id_tipo_solicitacao = p.id_tipo_solicitacao
                        inner join view_despesa as desp
                        on desp.id_despesa  = p.id_despesa
                        inner join pla_tipo_gasto as tpGasto
                        on tpGasto.id_tipo_gasto = p.id_tipo_gasto
                        inner join ses_lotacao as l
                        on l.id_lotacao = p.id_lotacao
                        inner join fin_fonte as font
                        on font.id_fonte = p.id_fonte
                        inner join view_programa_trabalho as pt
                        on pt.id_programa_trabalho = p.id_programa_trabalho
                        left join fin_fornecedor as f
                        on f.id_fornecedor = p.id_fornecedor
                        left join ses_pessoa as pessoa
                        on pessoa.id_pessoa = f.id_pessoa
                        where p.st_pedido > '0' " . $filter . " order by p.id_pedido desc";
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
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaPedidoPesquisaComOrdens(PDO $pdo, $filter) {
        try {
            if (!empty($pdo)) {
                $sql = "select
                            p.id_pedido,
                            l.id_lotacao,
                            p.nr_pedido,
                            to_char(p.dt_pedido, 'YYYY') as ano,
                            tipo.nm_tipo_solicitacao,
                            font.nr_fonte,
                            desp.cd_despesa,
                            desp.ds_despesa_elemento,
                            tpGasto.nm_tipo_gasto,
                            l.nm_lotacao,
                            pessoa.nm_pessoa,
                            p.vl_pedido,
                            p.ds_pedido,
                            pt.cd_programa_trabalho,
                            pt.ds_programa_trabalho,
                            p.st_pedido as status,
                            ordem.sit_protocolo,
                            ordem.ordens 
                         from
                            fin_pedido as p 
                            inner join
                               fin_tipo_solicitacao as tipo 
                               on tipo.id_tipo_solicitacao = p.id_tipo_solicitacao 
                            inner join
                               view_despesa as desp 
                               on desp.id_despesa = p.id_despesa 
                            inner join
                               pla_tipo_gasto as tpGasto 
                               on tpGasto.id_tipo_gasto = p.id_tipo_gasto 
                            inner join
                               ses_lotacao as l 
                               on l.id_lotacao = p.id_lotacao 
                            inner join
                               fin_fonte as font 
                               on font.id_fonte = p.id_fonte 
                            inner join
                               view_programa_trabalho as pt 
                               on pt.id_programa_trabalho = p.id_programa_trabalho 
                            left join
                               fin_fornecedor as f 
                               on f.id_fornecedor = p.id_fornecedor 
                            left join
                               ses_pessoa as pessoa 
                               on pessoa.id_pessoa = f.id_pessoa 
                            left join
                               (
                                  select
                                     fo.id_pedido,
                                     array_agg(fo.id_ordem) as ordens,
                                     string_agg(trim(fpro.st_protocolo), '') as sit_protocolo
                                  from
                                     fin_ordem as fo 
				     left join
				        fin_protocolo as fpro
				        on fo.id_ordem = fpro.id_ordem
                                  group by
                                     fo.id_pedido 
                               )
                               as ordem 
                               on ordem.id_pedido = p.id_pedido 
                         where
                            p.st_pedido > '0' " . $filter . "
                          order by
                            p.id_pedido desc";
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
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function retornaQuantidadeSituacaoPedido(PDO $pdo = null) {
        try {
            $sql = "SELECT "
                    . " st_pedido, count(id_pedido) AS quantidade"
                    . " FROM fin_pedido"
                    . " GROUP BY st_pedido";

            $stmt = $pdo->prepare($sql);
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

    public function retornaPedidoGdof(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select p.nr_pedido, p.id_lotacao, p.ds_pedido, f.nr_fonte, p.id_tipo_solicitacao, p.id_pedido,
                        programa.cd_programa_trabalho, programa.ds_programa_trabalho,
                        despesa.cd_despesa, despesa.ds_despesa, tpSol.nm_tipo_solicitacao,
                        p.vl_pedido
                        from fin_pedido as p
                        inner join fin_fonte as f
                        on f.id_fonte = p.id_fonte
                        inner join view_programa_trabalho as programa
                        on programa.id_programa_trabalho = p.id_programa_trabalho
                        inner join view_despesa as despesa
                        on despesa.id_despesa = p.id_despesa
                        left join fin_tipo_solicitacao as tpSol
                        on tpSol.id_tipo_solicitacao = p.id_tipo_solicitacao
                        where p.nr_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getNrPedido(), PDO::PARAM_INT);
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

    public function retornaPedidoOrdemGdof(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select DISTINCT(p.id_pedido), concat(concat(concat(p.id_lotacao, '-'),concat(p.nr_pedido, '/')),to_char(p.dt_pedido, 'yyyy')) as pedido, p.ds_pedido,
                        tp.nm_tipo_gasto, font.nr_fonte, concat(desp.cd_despesa_elemento, ' - ',desp.ds_despesa_elemento) as ds_despesa_elemento, p.vl_pedido, p.st_pedido, p.st_pedido as status,
                        concat(concat(cont.nr_contrato,'/') , to_char(cont.dt_ini_vigencia_contrato, 'yyyy'))  as contrato, cont.tp_contrato,
                        modalidade.nm_modalidade, pt.cd_programa_trabalho, pt.ds_programa_trabalho, emp.nr_empenho,ordemAux.sit_protocolo,
                        ordemAux.ordens, id_tipo_solicitacao 
                        from fin_pedido p 
                        left join fin_ordem as ordem
                        on ordem.id_pedido = p.id_pedido
                        inner join view_despesa_elemento as desp
                        on desp.id_despesa_elemento = p.id_despesa_elemento
                        inner join pla_tipo_gasto as tp
                        on tp.id_tipo_gasto = p.id_tipo_gasto
                        inner join fin_fonte as font
                        on font.id_fonte =  p.id_fonte
                        left join fin_fornecedor as f
                        on f.id_fornecedor = p.id_fornecedor
                        left join fin_contrato as cont 
                        on cont.id_contrato =  f.id_contrato
                        inner join fin_programa_trabalho as pt
                        on pt.id_programa_trabalho  = p.id_programa_trabalho
                        inner join fin_empenho as emp
                        on emp.id_pedido = p.id_pedido
                        left join gco_processo as gcon
                        on gcon.id_processo = cont.id_processo
                        left join gco_modalidade as modalidade
                        on modalidade.id_modalidade = gcon.id_modalidade
                        left join
                        (
                           select
                              fo.id_pedido,
                              array_agg(fo.id_ordem) as ordens,
                              string_agg(trim(fpro.st_protocolo), '') as sit_protocolo
                           from
                              fin_ordem as fo 
                              left join
                                 fin_protocolo as fpro
                                 on fo.id_ordem = fpro.id_ordem
                           group by
                              fo.id_pedido 
                        )
                        as ordemAux 
                        on ordemAux.id_pedido = p.id_pedido
                        where p.nr_pedido = :numero
                        and p.id_tipo_solicitacao in (1,2)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function retornaIdPedidoPorNumero(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select id_pedido from fin_pedido where nr_pedido = :numero";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrPedido(), PDO::PARAM_INT);
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

    public function retornaValoresPedido(PDO $pdo) {
        try {
            if (!empty($pdo)) {
                $sql = "select sum(vl_pedido)
                        from fin_pedido as p
                        where p.st_pedido > '0' 
                        and p.id_fonte = :fonte
                        and p.id_programa_trabalho  = :programa
                        and p.id_despesa_elemento = :elemento
                        and p.id_tipo_gasto = :tipoGasto
                        and p.id_lotacao =  :lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":fonte", $this->getIdFonte(), PDO::PARAM_INT);
                $stmt->bindValue(":programa", $this->getIdProgramaTrabalho(), PDO::PARAM_INT);
                $stmt->bindValue(":elemento", $this->getIdDespesaElemento(), PDO::PARAM_INT);
                $stmt->bindValue(":tipoGasto", $this->getIdTipoGasto(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
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

    public function retornaQuantidadeTipoSolicitacao(PDO $pdo = null) {
        try {

            if (!empty($pdo)) {
                $sql = "SELECT P.id_tipo_solicitacao, count(P.id_pedido) AS quantidade"
                        . " , TS.nm_tipo_solicitacao"
                        . " FROM fin_pedido P"
                        . " INNER JOIN fin_tipo_solicitacao TS ON TS.id_tipo_solicitacao = P.id_tipo_solicitacao"
                        . " WHERE P.st_pedido <> '0' AND P.st_pedido NOT IN ('0', '9', '10')"
                        . " GROUP BY P.id_tipo_solicitacao, TS.id_tipo_solicitacao";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaSituacaoPorSolicitacao(PDO $pdo = null) {
        try {

            if (!empty($pdo)) {
                $sql = "SELECT P.st_pedido, P.id_pedido, ordem.sit_protocolo, ordem.ordens "
                        . " , P.st_pedido as status"
                        . " FROM fin_pedido P"
                        . " LEFT JOIN
                               (
                                  SELECT
                                     fo.id_pedido,
                                     array_agg(fo.id_ordem) as ordens,
                                     string_agg(trim(fpro.st_protocolo), '') as sit_protocolo
                                  FROM
                                     fin_ordem as fo 
				     left join
				        fin_protocolo as fpro
				        on fo.id_ordem = fpro.id_ordem
                                  GROUP BY
                                     fo.id_pedido 
                               )
                               AS ordem 
                               ON ordem.id_pedido = P.id_pedido"
                        . " WHERE P.st_pedido <> '0' AND P.id_tipo_solicitacao = :id_tipo_solicitacao"
                        . " AND P.st_pedido NOT IN ('0', '9', '10')"
                        . "";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_solicitacao", $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaQuantidadeLotacaoPorSolicitacaoSituacao(PDO $pdo = null) {
        try {

            if (!empty($pdo)) {

                $sql = "SELECT id_lotacao, count(id_pedido) AS quantidade, nm_lotacao"
                        . " FROM (SELECT P.id_lotacao, P.id_pedido, L.nm_lotacao"
                        . " , CASE 
                                WHEN (ordem.ordens IS NOT NULL AND (ordem.sit_protocolo !~* '1|2' OR ordem.sit_protocolo IS NULL)) THEN '17'
                                WHEN (ordem.ordens IS NOT NULL AND ordem.sit_protocolo ~* '2') THEN '18'
                                WHEN (ordem.ordens IS NOT NULL AND ordem.sit_protocolo ~* '1' AND ordem.sit_protocolo !~* '2') THEN '19'
                                ELSE P.st_pedido
                            END AS status"
                        . " FROM fin_pedido P"
                        . " INNER JOIN ses_lotacao L ON L.id_lotacao = P.id_lotacao"
                        . " LEFT JOIN
                                (
                                SELECT
                                   fo.id_pedido,
                                   array_agg(fo.id_ordem) as ordens,
                                   string_agg(trim(fpro.st_protocolo), '') as sit_protocolo
                                FROM fin_ordem as fo 
                                    left join
                                       fin_protocolo as fpro
                                       on fo.id_ordem = fpro.id_ordem
                                GROUP BY fo.id_pedido 
                                ) AS ordem ON ordem.id_pedido = P.id_pedido"
                        . " WHERE P.st_pedido <> '0' AND P.id_tipo_solicitacao = :id_tipo_solicitacao) AS tabela"
                        . " WHERE status = :st_pedido "
                        . " GROUP BY tabela.id_lotacao, tabela.nm_lotacao";

                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_solicitacao", $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
                $stmt->bindValue(":st_pedido", $this->getStPedido(), PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaPorSolicitacaoSituacaoLotacao(PDO $pdo = null) {
        try {

            if (!empty($pdo)) {

                $sql = "SELECT id_lotacao, id_pedido, pedido, nm_tipo_gasto, nr_fonte, nr_contrato, cd_despesa_elemento"
                        . " , nm_pessoa, nr_cnpj"
                        . " FROM (SELECT P.id_lotacao, P.id_pedido, TG.nm_tipo_gasto, F.nr_fonte"
                        . " , C.nr_contrato, DE.cd_despesa_elemento, PES.nm_pessoa, PJ.nr_cnpj"
                        . " , concat(concat(concat(P.nr_pedido, '/')),to_char(P.dt_pedido, 'yyyy')) as pedido"
                        . " , CASE 
                                WHEN (ordem.ordens IS NOT NULL AND (ordem.sit_protocolo !~* '1|2' OR ordem.sit_protocolo IS NULL)) THEN '17'
                                WHEN (ordem.ordens IS NOT NULL AND ordem.sit_protocolo ~* '2') THEN '18'
                                WHEN (ordem.ordens IS NOT NULL AND ordem.sit_protocolo ~* '1' AND ordem.sit_protocolo !~* '2') THEN '19'
                                ELSE P.st_pedido
                            END AS status"
                        . " FROM fin_pedido P"
                        . " INNER JOIN view_despesa_elemento DE ON DE.id_despesa_elemento = P.id_despesa_elemento"
                        . " INNER JOIN pla_tipo_gasto TG ON TG.id_tipo_gasto = P.id_tipo_gasto"
                        . " INNER JOIN fin_fonte F ON F.id_fonte = P.id_fonte"
                        . " LEFT JOIN fin_fornecedor FO ON FO.id_fornecedor = P.id_fornecedor"
                        . " LEFT JOIN ses_pessoa PES ON PES.id_pessoa = FO.id_pessoa"
                        . " LEFT JOIN ses_pessoa_juridica PJ ON PJ.id_pessoa = PES.id_pessoa"
                        . " LEFT JOIN fin_contrato C ON C.id_contrato = FO.id_contrato"
                        . " LEFT JOIN
                                (
                                SELECT
                                   fo.id_pedido,
                                   array_agg(fo.id_ordem) as ordens,
                                   string_agg(trim(fpro.st_protocolo), '') as sit_protocolo
                                FROM fin_ordem as fo 
                                    left join
                                       fin_protocolo as fpro
                                       on fo.id_ordem = fpro.id_ordem
                                GROUP BY fo.id_pedido 
                                ) AS ordem ON ordem.id_pedido = P.id_pedido"
                        . " WHERE P.st_pedido <> '0' AND P.id_tipo_solicitacao = :id_tipo_solicitacao"
                        . " AND P.id_lotacao = :id_lotacao) AS tabela"
                        . " WHERE status = :st_pedido"
                        . " ORDER BY id_pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo_solicitacao", $this->getIdTipoSolicitacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":st_pedido", $this->getStPedido(), PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function updateTramitacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update fin_pedido SET st_pedido = :tramitacao where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":tramitacao", $this->getStPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTramitacao(PDO $pdo = null) {
        try {

            if (!empty($pdo)) {
                $sql = "select st_pedido from fin_pedido  where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    public function retornaTipoSolicitacaoPedido(PDO $pdo = null) {
        try {

            if (!empty($pdo)) {
                $sql = "select id_tipo_solicitacao from fin_pedido where id_pedido = :pedido";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                    $this->msgRetorno = "";
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Sem Conexão";
            }
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function atualizaSituacaoStatusPedido(PDO $pdo = null){
        $this->sucesso = false;
        $sql = "update fin_pedido set id_pedido_situacao = :id_pedido_situacao, st_pedido = :st_pedido where id_pedido = :id_pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido_situacao", $this->getIdPedidoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":st_pedido", $this->getStPedido(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    
    public function retornaTotaisDoPedido(PDO $pdo = null) {
        $this->sucesso = false;
        $sql = "select
                    pedido.id_pedido,
                    empenho.id_empenho,
                    empenho.vl_empenho as valor_empenho,
                    pedido.vl_pedido as valor_pedido,
                    tpSol.id_tipo_solicitacao,
                    sum(itens.qt_itens_ordem * itens.vl_itens_ordem) valor_ordenado,
                    sum(coalesce(vl_liquidacao,0)) as valor_liquidado
                    --sum(coalesce(vl_documento,0)) as valor_documento
                 from
                    fin_pedido pedido
                 inner join fin_empenho empenho
                    on empenho.id_pedido = pedido.id_pedido
                 inner join fin_tipo_solicitacao tpSol
                    on tpSol.id_tipo_solicitacao = pedido.id_tipo_solicitacao
                 left join fin_ordem ordem
                    on ordem.id_pedido = pedido.id_pedido
                    and ordem.sit_ordem > '0'
                 /*left join fin_documento_fiscal documento
                    on documento.id_pedido = pedido.id_pedido
                    and documento.id_documento_situacao <> 7*/
                 left join fin_ordem_itens itens
                    on itens.id_ordem = ordem.id_ordem
                 left join con_liquidacao liq
                    on liq.id_empenho = empenho.id_empenho
                    and liq.id_liquidacao_situacao <> 4
                 where
                    pedido.id_pedido = :id_pedido
                 group by
                    pedido.id_pedido, empenho.id_empenho, tpSol.id_tipo_solicitacao";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

}
