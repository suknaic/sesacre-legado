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
                $sql = "select distinct on (p.id_pedido)
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
                            ordem.ordens,
                            emp.nr_empenho, 
                            emp.id_empenho,
                            p.id_tipo_solicitacao,
                            doc.id_documento_fiscal,
                            ps.nm_pedido_situacao
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
                            left join 
                                fin_empenho emp 
                                on emp.id_pedido = p.id_pedido
                            left join fin_documento_fiscal doc
                                on doc.id_pedido = p.id_pedido
                            left join fin_pedido_situacao ps
                                on ps.id_pedido_situacao = p.id_pedido_situacao
                         where
                            p.id_pedido is not null " . $filter . "
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
        } catch (PDOException $ex) {
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
                        p.vl_pedido, to_char(p.dt_pedido, 'yyyy') AS ano
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
        } catch (PDOException $ex) {
            $this->sucesso = false;
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaPedidoSemEmpenho(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    pedido.id_pedido,
                    pedido.nr_pedido,
                    pedido.ds_pedido,
                    tpGasto.nm_tipo_gasto,
                    fonte.nr_fonte,
                    (despesa.cd_despesa_elemento || ' - ' || despesa.ds_despesa_elemento) as ds_despesa_elemento,
                    pedido.vl_pedido,
                    contrato.tp_contrato,
                    contrato.nr_contrato,
                    (programa_trabalho.cd_programa_trabalho || ' - ' || programa_trabalho.ds_programa_trabalho) as ds_programa_trabalho,
                    modalidade.nm_modalidade,
                    pedido_situacao.nm_pedido_situacao
                from
                    fin_pedido pedido
                inner join pla_tipo_gasto tpGasto on
                    tpGasto.id_tipo_gasto = pedido.id_tipo_gasto
                inner join fin_fonte fonte on
                    fonte.id_fonte = pedido.id_fonte
                inner join view_despesa_elemento despesa on
                    despesa.id_despesa_elemento = pedido.id_despesa_elemento
                inner join fin_programa_trabalho programa_trabalho on
                    programa_trabalho.id_programa_trabalho = pedido.id_programa_trabalho
                left join fin_pedido_situacao pedido_situacao on
                    pedido_situacao.id_pedido_situacao = pedido.id_pedido_situacao
                left join fin_fornecedor fornecedor on
                    fornecedor.id_fornecedor = pedido.id_fornecedor
                left join fin_contrato contrato on
                    contrato.id_contrato = fornecedor.id_contrato
                left join gco_processo gcon on
                    gcon.id_processo = contrato.id_processo
                left join gco_modalidade modalidade on
                    modalidade.id_modalidade = gcon.id_modalidade
                left join fin_empenho empenho on
                    empenho.id_pedido = pedido.id_pedido
                where (pedido.id_pedido_situacao <> 10 /*Diferente de cancelado*/ or pedido.id_pedido_situacao is null)
                and empenho.id_empenho is null
                and pedido.nr_pedido = :pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getNrPedido(), PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = 'Nenhum pedido encontrado.';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $exc) {
             $this->msgRetorno = $exc->getMessage();
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
                    ped.id_pedido,
                    ped.id_tipo_solicitacao,
                    coalesce(sum(vl_liquidacao), 0) as valor_liquidado,
                    coalesce(sum(vl_empenho), 0) as valor_empenho,
                    coalesce((
                       select
                          sum(coalesce(qt_itens_ordem * vl_itens_ordem, 0)) 
                       from
                          fin_ordem ordem,
                          fin_ordem_itens itens 
                       where
                          ordem.id_ordem = itens.id_ordem 
                          and ordem.sit_ordem > '0' 
                          and ordem.id_pedido = ped.id_pedido
                    ),0)
                    as valor_ordenado,
                    vl_pedido as valor_pedido 
                 from
                    fin_pedido ped 
                    inner join
                       fin_tipo_solicitacao tpSol 
                       on tpSol.id_tipo_solicitacao = ped.id_tipo_solicitacao 
                    inner join
                       fin_empenho emp 
                       on ped.id_pedido = emp.id_pedido 
                    left join
                       con_liquidacao liq 
                       on emp.id_empenho = liq.id_empenho 
                       and liq.id_liquidacao_situacao <> 4 
                 where
                    ped.id_pedido = :id_pedido 
                 group by
                    ped.id_pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function retornaStatusPedido(PDO $pdo){
        $this->sucesso = false;
        $sql = "SELECT 
                    P.id_pedido, P.nr_pedido, P.id_tipo_solicitacao
                    , P.id_fornecedor, P.dt_pedido, P.st_pedido, P.id_pedido_situacao
                    , E.id_empenho as id_pedido_empenho
                    , O.id_pedido AS id_pedido_ordem
                    , SALORDEM.id_pedido AS id_pedido_ordem
                    , DF.id_pedido AS id_pedido_doc
                    , L.id_pedido AS id_pedido_liquidacao
                    , SALLIQUIDACAO.id_pedido AS id_pedido_saldo_liquidacao
                    , PAG.id_pedido AS id_pedido_pagamento
                    , SALPAG.id_pedido AS id_pedido_saldo_pagamento

                    , CASE
                            /*
                             * Pedido Não possui Empenho
                             * Deve ser Aguardando Empenho
                             */
                            WHEN (			
                                            E.id_pedido IS NULL				
                                    ) THEN 15
                            /*
                             * Pedido Possui Empenho, não possui Ordem e Tipo Administrativo Por Licitação
                             * Deve ser Aguardando Ordem
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL			
                                            AND O.id_pedido IS NULL
                                            AND E.id_pedido IS NOT NULL	
                                            AND P.id_tipo_solicitacao = 2
                                    ) THEN 16
                            /*
                             * Pedido Possui Empenho, não possui Ordem e Tipo Administrativo
                             * Deve ser Aguardando Liquidação
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL				
                                            AND O.id_pedido IS NULL
                                            AND E.id_pedido IS NOT NULL	
                                            AND (P.id_tipo_solicitacao = 1 OR P.id_tipo_solicitacao = 3 OR P.id_tipo_solicitacao = 4)		
                                    ) THEN 21	
                            /*
                             * Pedido Possui Empenho, possui Ordem e Tipo Administrativo Por Licitação	 
                             * Precisa Verificar os Valores das Ordens
                             * Pode ser Aguardando Finalizar Ordenado Ou Aguardando Liquidação
                             * O Pedido não tem mais Saldo de Acordo com as Ordens então ele é Aguardando Liquidação
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL			
                                            AND O.id_pedido IS NOT NULL
                                            AND E.id_pedido IS NOT NULL	
                                            AND P.id_tipo_solicitacao = 2
                                            AND SALORDEM.id_pedido IS NULL
                                    ) THEN 21	
                            /*
                             * O Pedido possui Saldo de Acordo com as Ordens então ele é Aguardando Finaliza Ordenado 
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL				
                                            AND O.id_pedido IS NOT NULL
                                            AND E.id_pedido IS NOT NULL	
                                            AND P.id_tipo_solicitacao = 2	
                                            AND SALORDEM.id_pedido IS NOT NULL			
                                    ) THEN 24

                            /*
                             * Pedido Possui Liquidação e Não possui Pagamento
                             * Precisa Verificar os Valores da Liquidação desse Pedido 
                             * Pode ser Aguardando Finalizar Liquidação ou Aguardando Pagamento
                             * O Pedido não tem mais Saldo de Acordo com as Liquidações então ele é Aguardando Pagamento
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALLIQUIDACAO.id_pedido IS NULL
                                    ) THEN 22
                            /*
                             * O Pedido possui Saldo de Acordo com as Liquidações então ele é Aguardando Finalizar Liquidação 
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALLIQUIDACAO.id_pedido IS NOT NULL
                                    ) THEN 25

                            /*
                             * Pedido Possui Pagamento 
                             * Precisa Verificar os Valores da Pagamento desse Pedido 
                             * Pode ser Aguardando Finalizar Pagamento ou Finalizado
                             * O Pedido não tem mais Saldo de Acordo com os Pagamentos então ele é Finalizado
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALPAG.id_pedido IS NULL
                                    ) THEN 23
                            /*
                             * O Pedido possui Saldo de Acordo com os Pagamentos então ele é Aguardando Finalizar Pagamento
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALPAG.id_pedido IS NOT NULL
                                    ) THEN 26

                            ELSE null
                    END AS status_oficial	

                    /*
                     * Situação do Pedido
                     */
                    , CASE
                            /*
                             * Pedido Não possui Empenho
                             * Deve ser Autorizado
                             */
                            WHEN (			
                                            E.id_pedido IS NULL				
                                    ) THEN 2
                            /*
                             * Pedido Possui Empenho, não possui Ordem nem Liquidação
                             * Deve ser Empenhado
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL			
                                            AND O.id_pedido IS NULL
                                            AND E.id_pedido IS NOT NULL				
                                    ) THEN 3	
                            /*
                             * Pedido Possui Empenho, possui Ordem e Tipo Administrativo Por Licitação	 
                             * Precisa Verificar os Valores das Ordens
                             * Pode ser Ordenado Parcial Ou Ordenado Total
                             * O Pedido não tem mais Saldo de Acordo com as Ordens então ele é Ordenado Total
                             */
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL			
                                            AND O.id_pedido IS NOT NULL
                                            AND E.id_pedido IS NOT NULL	
                                            AND P.id_tipo_solicitacao = 2
                                            AND SALORDEM.id_pedido IS NULL
                                    ) THEN 5	
                            /*
                             * O Pedido possui Saldo de Acordo com as Ordens então ele é Ordenado Parcial
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NULL				
                                            AND O.id_pedido IS NOT NULL
                                            AND E.id_pedido IS NOT NULL	
                                            AND P.id_tipo_solicitacao = 2	
                                            AND SALORDEM.id_pedido IS NOT NULL			
                                    ) THEN 4

                            /*
                             * Pedido Possui Liquidação e Não possui Pagamento
                             * Precisa Verificar os Valores da Liquidação desse Pedido 
                             * Pode ser Liquidado Parcial ou Liquidado Total
                             * O Pedido não tem mais Saldo de Acordo com as Liquidações então ele é Liquidado Total
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALLIQUIDACAO.id_pedido IS NULL
                                    ) THEN 7
                            /*
                             * O Pedido possui Saldo de Acordo com as Liquidações então ele é Liquidado Parcial
                             */		
                            WHEN (
                                            PAG.id_pedido IS NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALLIQUIDACAO.id_pedido IS NOT NULL
                                    ) THEN 6

                            /*
                             * Pedido Possui Pagamento 
                             * Precisa Verificar os Valores da Pagamento desse Pedido 
                             * Pode ser Pago Parcial ou Pago Total
                             * O Pedido não tem mais Saldo de Acordo com os Pagamentos então ele é Pago Total
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL	
                                            AND SALPAG.id_pedido IS NULL
                                    ) THEN 9
                            /*
                             * O Pedido possui Saldo de Acordo com os Pagamentos então ele é Pago Parcial
                             */		
                            WHEN (
                                            PAG.id_pedido IS NOT NULL
                                            AND L.id_pedido IS NOT NULL							
                                            AND E.id_pedido IS NOT NULL			
                                            AND SALPAG.id_pedido IS NOT NULL
                                    ) THEN 8

                            ELSE null
                    END AS situacao_oficial

                    FROM fin_pedido P
                    LEFT JOIN fin_empenho E ON E.id_pedido = P.id_pedido AND E.sit_empenho <> '6'

                    LEFT JOIN (
                                            SELECT distinct on(id_pedido) id_pedido
                                            FROM fin_ordem
                                            WHERE sit_ordem <> '0'
                                            ) AS O ON O.id_pedido = P.id_pedido

                    LEFT JOIN (
                                            SELECT distinct on (id_pedido) id_pedido
                                            FROM fin_documento_fiscal
                                            WHERE id_documento_situacao <> 7
                                            ) AS DF ON DF.id_pedido = P.id_pedido

                    LEFT JOIN (
                                            SELECT distinct on (P.id_pedido) P.id_pedido
                                            FROM fin_pedido P
                                            INNER JOIN fin_empenho E ON E.id_pedido = P.id_pedido AND E.sit_empenho <> '6'
                                            INNER JOIN con_liquidacao L ON L.id_empenho = E.id_empenho AND L.id_liquidacao_situacao <> 4
                                            ) AS L ON L.id_pedido = P.id_pedido

                    LEFT JOIN (
                                            SELECT distinct on (P.id_pedido) P.id_pedido
                                            FROM fin_pedido P
                                            INNER JOIN fin_empenho E ON E.id_pedido = P.id_pedido AND E.sit_empenho <> '6'
                                            INNER JOIN con_liquidacao L ON L.id_empenho = E.id_empenho AND L.id_liquidacao_situacao <> 4
                                            INNER JOIN con_pagamento PAG ON PAG.id_liquidacao = L.id_liquidacao AND PAG.id_pagamento_situacao <> 2
                                            ) AS PAG ON PAG.id_pedido = P.id_pedido


                    LEFT JOIN (SELECT distinct on (id_pedido) id_pedido 

                                            FROM (SELECT id_pedido, saldo
                                                            FROM view_pedido_saldo				
                                            ) t
                                            where t.saldo > 0
                                            ) AS SALORDEM ON SALORDEM.id_pedido = P.id_pedido


                    LEFT JOIN (SELECT * 
                                            FROM (
                                            select
                                                ped.id_pedido,                    
                                                coalesce(sum(vl_liquidacao), 0) as valor_liquidado,                                       
                                                vl_pedido as valor_pedido     
                                                , (vl_pedido - coalesce(sum(vl_liquidacao), 0)) AS saldo 
                                             from
                                                fin_pedido ped                     
                                                inner join
                                                   fin_empenho emp 
                                                   on ped.id_pedido = emp.id_pedido AND emp.sit_empenho <> '6'
                                                left join
                                                   con_liquidacao liq 
                                                   on emp.id_empenho = liq.id_empenho 
                                                   and liq.id_liquidacao_situacao <> 4 
                                             group by ped.id_pedido ) t2  
                                             where t2.saldo > 0
                                            ) AS SALLIQUIDACAO ON SALLIQUIDACAO.id_pedido = P.id_pedido

                    LEFT JOIN (SELECT *
                                            FROM (
                                            select
                                                ped.id_pedido,                    
                                                coalesce(sum(vl_pagamento), 0) as valor_pago,                                       
                                                vl_pedido as valor_pedido     
                                                , (vl_pedido - coalesce(sum(vl_pagamento), 0)) AS saldo 
                                             from
                                                fin_pedido ped                     
                                                inner join
                                                   fin_empenho emp 
                                                   on ped.id_pedido = emp.id_pedido AND emp.sit_empenho <> '6'
                                                left join
                                                   con_liquidacao liq 
                                                   on emp.id_empenho = liq.id_empenho 
                                                   and liq.id_liquidacao_situacao <> 4
                                                 left join
                                                   con_pagamento pag 
                                                   on pag.id_liquidacao = liq.id_liquidacao 
                                                   and pag.id_pagamento_situacao <> 2
                                             group by ped.id_pedido ) t2  
                                             where t2.saldo > 0
                                            ) AS SALPAG ON SALPAG.id_pedido = P.id_pedido


                    WHERE P.st_pedido != '0'
                    AND P.st_pedido != '9'
                    AND P.st_pedido != '10'
                    AND P.st_pedido != '11'
                    AND P.st_pedido != '12'
                    AND P.st_pedido != '13'
                    AND P.st_pedido != '14'
                    AND P.id_pedido = :id_pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }

    public function retornaDadosPedidoContratoAccordion(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    cont.nr_contrato,
                    cont.nr_contrato,
                    processo.cd_pregao,
                    tp.nm_tipo_gasto,
                    obj.nm_objeto,
                    central.nm_lotacao,
                    cont.id_contrato,
                    mod.nm_modalidade,
                    p.nm_pessoa,
                    cont_itens.vl_contrato,
                    case
                            when pf.nr_cpf is not null then pf.nr_cpf
                            when pf.nr_cpf is null then pj.nr_cnpj
                    end as cpfCnpj
                from
                    fin_pedido as pedido 
                inner join fin_fornecedor as f on
                    f.id_fornecedor = pedido.id_fornecedor
                inner join fin_contrato as cont on
                    cont.id_contrato = f.id_contrato
                inner join fin_cont_central as cont_central on
                    cont_central.id_contrato = cont.id_contrato
                left join ses_lotacao as central on
                    central.id_lotacao = cont_central.id_lotacao
                inner join (
                    select
                        id_fornecedor,
                        round(sum(qt_itens * vl_itens), 4) as vl_contrato
                    from
                        fin_cont_itens
                    group by
                        id_fornecedor) as cont_itens on
                    cont_itens.id_fornecedor = f.id_fornecedor
                inner join gco_processo as processo on
                    processo.id_processo = cont.id_processo
                inner join gco_objeto as obj on
                    obj.id_objeto = processo.id_objeto
                inner join pla_tipo_gasto as tp on
                    tp.id_tipo_gasto = cont.id_tipo_gasto
                inner join gco_modalidade as mod on
                    mod.id_modalidade = processo.id_modalidade
                inner join ses_pessoa as p on
                    p.id_pessoa = f.id_pessoa
                left join ses_pessoa_fisica as pf on
                    pf.id_pessoa = p.id_pessoa
                left join ses_pessoa_juridica as pj on
                    pj.id_pessoa = p.id_pessoa
                where
                    pedido.id_pedido = :pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosPedidoAccordion(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    p.nr_pedido,
                    p.id_lotacao,
                    central.nm_lotacao ,
                    p.ds_pedido,
                    f.nr_fonte,
                    p.id_tipo_solicitacao,
                    p.id_pedido,
                    programa.cd_programa_trabalho,
                    programa.ds_programa_trabalho,
                    despesa.cd_despesa,
                    despesa.ds_despesa,
                    tpSol.nm_tipo_solicitacao,
                    despesa_elemento.cd_despesa_elemento,
                    despesa_elemento.ds_despesa_elemento,
                    p.vl_pedido,
                    to_char(p.dt_pedido,
                    'yyyy') as ano,
                    pedido_saldo.saldo
                from
                    fin_pedido as p
                inner join fin_fonte as f on
                    f.id_fonte = p.id_fonte
                inner join view_programa_trabalho as programa on
                    programa.id_programa_trabalho = p.id_programa_trabalho
                inner join ses_lotacao as central on
                    central.id_lotacao = p.id_lotacao
                inner join view_despesa as despesa on
                    despesa.id_despesa = p.id_despesa
                inner join view_despesa_elemento as despesa_elemento on
                    despesa_elemento.id_despesa_elemento = p.id_despesa_elemento
                left join (
                    select
                        id_pedido,
                        sum(saldo) as saldo
                    from
                        view_pedido_saldo
                    group by
                        id_pedido ) as pedido_saldo on
                    pedido_saldo.id_pedido = p.id_pedido
                left join fin_tipo_solicitacao as tpSol on
                    tpSol.id_tipo_solicitacao = p.id_tipo_solicitacao
                where
                    p.id_pedido = :pedido";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaDadosPedidoDiariaAccordion(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    diaria.id_diaria,
                    diaria.nr_protocolo,
                    pes_proponente.nm_pessoa as nm_proponente,
                    lot_proponente.nm_lotacao as lt_proponente,
                    fn_proponente.nm_funcao as fn_proponente,
                    pes_proposto.nm_pessoa as nm_proposto,
                    lot_proposto.nm_lotacao as lt_proposto,
                    fn_proposto.nm_funcao as fn_proposto,
                    cid_ini.nm_cidade as nm_cidade_origem,
                    est_ini.nm_sigla as uf_cidade_origem,
                    trim(to_char(dest.dh_inicio,'dd/mm/yyyy hh24:mi')) as dh_inicio,
                    cid_fim.nm_cidade as nm_cidade_destino,
                    est_fim.nm_sigla as uf_cidade_destino,
                    trim(to_char(dest.dh_fim,'dd/mm/yyyy hh24:mi')) as dh_fim,
                    dest.qt_diaria_destino,
                    dest.vl_diaria_destino
                 from
                    dia_diaria diaria,
                    dia_diaria_destino dest,
                    ses_lotacao lot_proponente,
                    ses_lotacao lot_proposto,
                    ses_pessoa pes_proponente,
                    ses_pessoa pes_proposto,
                    ses_funcao fn_proponente,
                    ses_funcao fn_proposto,
                    ses_cidade cid_ini,
                    ses_estado est_ini,
                    ses_cidade cid_fim,
                    ses_estado est_fim
                 where
                    diaria.id_pedido = :pedido
                    and diaria.id_diaria = dest.id_diaria 
                    and diaria.id_lotacao_proponente = lot_proponente.id_lotacao 
                    and diaria.id_pessoa_proponente = pes_proponente.id_pessoa 
                    and diaria.id_funcao_proponente = fn_proponente.id_funcao 
                    and diaria.id_lotacao_proposto = lot_proposto.id_lotacao 
                    and diaria.id_pessoa_proposto = pes_proposto.id_pessoa 
                    and diaria.id_funcao_proposto = fn_proposto.id_funcao 
                    and dest.id_cidade_inicio = cid_ini.id_cidade 
                    and dest.id_cidade_fim = cid_fim.id_cidade 
                    and cid_ini.id_estado = est_ini.id_estado
                    and cid_fim.id_estado = est_fim.id_estado
                 order by
                    diaria.id_diaria, dest.id_diaria_destino";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
    
    public function retornaPedidoItens(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    itens.nr_item,
                    material.nm_material,
                    material.cd_desc_material,
                    material.nm_desc_material,
                    material.tp_material,
                    pedItens.qt_itens_pre,
                    pedItens.vl_itens_pre
                from
                    fin_pre_ordem pedItens
                inner join fin_cont_itens itens on
                    itens.id_cont_itens = pedItens.id_cont_itens
                inner join pla_material material on
                    itens.id_material = material.id_material
                where pedItens.id_pedido = :pedido
                order by itens.nr_item";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $ex) {
            $this->msgRetorno = $ex->getMessage();
        }
    }
}
