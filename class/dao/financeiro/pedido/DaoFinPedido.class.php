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
                $sql = "select p.nr_pedido, p.id_lotacao, p.ds_pedido, f.nr_fonte,
                        programa.cd_programa_trabalho, programa.ds_programa_trabalho,
                        despesa.cd_despesa_elemento, despesa.ds_despesa_elemento,
                        p.vl_pedido
                        from fin_pedido as p
                        inner join fin_fonte as f
                        on f.id_fonte = p.id_fonte
                        inner join view_programa_trabalho as programa
                        on programa.id_programa_trabalho = p.id_programa_trabalho
                        inner join view_despesa_elemento as despesa
                        on despesa.id_despesa_elemento = p.id_despesa_elemento
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
                        tp.nm_tipo_gasto, font.nr_fonte, desp.ds_despesa_elemento, p.vl_pedido,
                        concat(concat(cont.nr_contrato,'/') , to_char(cont.dt_ini_vigencia_contrato, 'yyyy'))  as contrato, cont.tp_contrato,
                        modalidade.nm_modalidade, pt.cd_programa_trabalho, pt.ds_programa_trabalho, emp.nr_empenho
                        from fin_pedido p 
                        inner join fin_ordem as ordem
                        on ordem.id_pedido = p.id_pedido
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
                        where p.nr_pedido = :numero";
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

}
