<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/contabil/empenho/anulacao/ConEmpenhoAnulacao.class.php";

class DaoConEmpenhoAnulacao extends ConEmpenhoAnulacao {

    private $sucesso = null;
    private $msgRetorno = null;

    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function insert(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "insert into con_empenho_anulacao "
                . "(id_pedido,vl_empenho_anulacao, vl_empenho_antigo, id_empenho_anulacao_situacao, id_empenho_anulacao_status,id_pessoa,id_lotacao,id_doc_tipo_lotacao, vl_empenho_saldo) "
                . "values"
                . " (:id_pedido,:vl_empenho_anulacao,:vl_empenho_antigo,:id_empenho_anulacao_situacao,:id_empenho_anulacao_status,:id_pessoa,:id_lotacao,:id_doc_tipo_lotacao, :vl_empenho_saldo)";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":vl_empenho_anulacao", $this->getVlEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_empenho_antigo", $this->getVlEmpenhoAntigo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_empenho_anulacao_situacao", $this->getIdEmpenhoAnulacaoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_doc_tipo_lotacao", $this->getIdDocTipoLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":vl_empenho_saldo", $this->getVlEmpenhoSaldo(), PDO::PARAM_STR);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retorna(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select * from con_empenho_anulacao where id_empenho_anulacao = :id_empenho_anulacao";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDadosDaAnulacaoDoEmpenho(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select "
                . "to_char(dt_empenho_anulacao,'dd/mm/yyyy') as dt_empenho_anulacao, "
                . "trim(to_char(vl_empenho_anulacao,'999G999G990D9999')) as vl_empenho_anulacao, "
                . "nr_empenho_anulacao, id_empenho_anulacao, id_pedido "
                . "from con_empenho_anulacao "
                . "where id_empenho_anulacao = :id_empenho_anulacao ";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDadosEmpenhoDaAnulacao(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select emp.id_empenho,
                concat(substr(nr_empenho, 1, ((LENGTH(nr_empenho)-4)) ), '/',  substring(nr_empenho FROM '....$')) as nr_empenho,
                to_char(dt_empenho_safira,'dd/mm/yyyy') as dt_empenho ,
                tpEmp.nm_tipo_empenho,
                trim(to_char(anuEmp.vl_empenho_antigo,'999G999G990D9999')) as vl_empenho_antigo,
                trim(to_char(anuEmp.vl_empenho_saldo,'999G999G990D9999')) as vl_empenho_saldo,
                trim(to_char((vl_empenho_antigo - vl_empenho_anulacao),'999G999G990D9999')) as vl_empenho_atual
                from fin_empenho emp
                inner join fin_tipo_empenho tpEmp
                on tpEmp.id_tipo_empenho = emp.id_tipo_empenho
                inner join con_empenho_anulacao anuEmp
                on anuEmp.id_pedido = emp.id_pedido
                where anuEmp.id_empenho_anulacao = :id_empenho_anulacao and emp.sit_empenho <> '6'";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDadosPedidoDaAnulacao(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select p.nr_pedido, p.id_lotacao, p.ds_pedido, f.nr_fonte, p.id_tipo_solicitacao, p.id_pedido,
                programa.cd_programa_trabalho, programa.ds_programa_trabalho,
                despesa.cd_despesa, despesa.ds_despesa, tpSol.nm_tipo_solicitacao,
                p.vl_pedido, to_char(p.dt_pedido, 'yyyy') AS ano
                from fin_pedido as p
                inner join con_empenho_anulacao as anuEmp
                on anuEmp.id_pedido = p.id_pedido
                inner join fin_fonte as f
                on f.id_fonte = p.id_fonte
                inner join view_programa_trabalho as programa
                on programa.id_programa_trabalho = p.id_programa_trabalho
                inner join view_despesa as despesa
                on despesa.id_despesa = p.id_despesa
                left join fin_tipo_solicitacao as tpSol
                on tpSol.id_tipo_solicitacao = p.id_tipo_solicitacao
                where anuEmp.id_empenho_anulacao = :id_empenho_anulacao";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaDadosContratoDaAnulacao(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select cont.nr_contrato, processo.cd_pregao, tp.nm_tipo_gasto, obj.nm_objeto,
                mod.nm_modalidade, p.nm_pessoa,
                case 
                        when pf.nr_cpf is not null then pf.nr_cpf
                        when pf.nr_cpf is null then pj.nr_cnpj
                end as cpfCnpj

                from fin_pedido as pedido
                inner join con_empenho_anulacao empAnu
                on empAnu.id_pedido = pedido.id_pedido 
                inner join fin_fornecedor as f
                on f.id_fornecedor  =  pedido.id_fornecedor
                inner join fin_contrato as cont
                on cont.id_contrato = f.id_contrato
                inner join gco_processo as processo
                on processo.id_processo = cont.id_processo
                inner join gco_objeto as obj
                on obj.id_objeto = processo.id_objeto
                inner join pla_tipo_gasto as tp
                on tp.id_tipo_gasto = cont.id_tipo_gasto
                inner join gco_modalidade as mod
                on mod.id_modalidade = processo.id_modalidade
                inner join ses_pessoa as p
                on p.id_pessoa = f.id_pessoa 
                left join ses_pessoa_fisica as pf
                on pf.id_pessoa = p.id_pessoa
                left join ses_pessoa_juridica as pj
                on pj.id_pessoa = p.id_pessoa
                where empAnu.id_empenho_anulacao = :id_empenho_anulacao";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaItensDaAnulacaoDoEmpenho(PDO $pdo) {
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select
                    itens.nr_item,
                    mat.nm_material,
                    mat.cd_desc_material,
                    mat.nm_desc_material,
                    mat.tp_material,
                    itens.nr_lote,
                    anuEmpItem.qt_item,
                    anuEmpItem.vl_item,
                    anuEmpItem.qt_anulado,
                    anuEmpItem.vl_anulado,
                    anuEmpItem.vl_saldo,
                    anuEmpItem.vl_utilizado,
                    anuEmpItem.qt_utilizado,
                    itens.fl_valor_variavel
                 from
                    con_empenho_anulacao_item anuEmpItem 
                    inner join
                       fin_pre_ordem preOrdem 
                       on preOrdem.id_pre_ordem = anuEmpItem.id_pre_ordem 
                    inner join
                       fin_cont_itens itens 
                       on itens.id_cont_itens = preOrdem.id_cont_itens 
                    inner join
                       pla_material as mat 
                       on mat.id_material = itens.id_material 
                 where
                    anuEmpItem.id_empenho_anulacao = :id_empenho_anulacao
                 order by itens.nr_item";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_empenho_anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }

    function retornaPesquisaEmpenhoAnulacao(PDO $pdo, array $filtroSql = []) {

        $this->sucesso = false;
        $this->msgRetorno = null;

        $str_filtro = '';
        if (!empty($filtroSql)) {
            foreach ($filtroSql as $filtro) {
                $str_filtro .= $filtro['sql'];
            }
        }

        $sql = "select
                    anulacaoEmp.id_empenho_anulacao,
                    --anulacaoEmp.nr_empenho_anulacao,
                    CASE 
                    WHEN nr_empenho_anulacao is not null then 
                        concat(substr(anulacaoEmp.nr_empenho_anulacao, 1, ((LENGTH(anulacaoEmp.nr_empenho_anulacao)-4)) ), '/', substring(anulacaoEmp.nr_empenho_anulacao from '....$')) 
                    ELSE
                        ''
                    END as nr_empenho_anulacao,
                    --emp.nr_empenho,
                    concat(substr(emp.nr_empenho, 1, ((LENGTH(emp.nr_empenho)-4)) ), '/', substring(emp.nr_empenho from '....$')) as nr_empenho,
                    (
                       ped.nr_pedido || '/' || to_char(ped.dt_pedido, 'YYYY')
                    )
                    as nr_pedido,
                    tpGasto.nm_tipo_gasto,
                    central.nm_lotacao,
                    coalesce(nm_fantasia, nm_civil) as nm_fornecedor,
                    coalesce(pj.nr_cnpj, pf.nr_cpf) as doc_fornecedor,
                    trim(to_char(anulacaoEmp.vl_empenho_anulacao, '999G999G999G990D9999')) as vl_empenho_anulacao,
                    to_char(anulacaoEmp.dt_empenho_anulacao, 'dd/mm/yyyy') as dt_empenho_anulacao,
                    anulacaoSit.nm_empenho_anulacao_situacao,
                    anulacaoSit.id_empenho_anulacao_situacao
                 from
                    con_empenho_anulacao anulacaoEmp 
                    inner join
                       fin_empenho emp 
                       on emp.id_pedido = anulacaoEmp.id_pedido 
                    inner join
                       fin_pedido ped 
                       on ped.id_pedido = anulacaoEmp.id_pedido 
                    inner join
                       pla_tipo_gasto tpGasto 
                       on ped.id_tipo_gasto = tpGasto.id_tipo_gasto 
                    inner join
                       ses_lotacao central 
                       on central.id_lotacao = ped.id_lotacao 
                    inner join
                       con_empenho_anulacao_situacao anulacaoSit 
                       on anulacaoSit.id_empenho_anulacao_situacao = anulacaoEmp.id_empenho_anulacao_situacao 
                    left join
                       fin_fornecedor fornecedor 
                       on fornecedor.id_fornecedor = ped.id_fornecedor 
                    left join
                       ses_pessoa_juridica pj 
                       on pj.id_pessoa = fornecedor.id_pessoa 
                    left join
                       ses_pessoa_fisica pf 
                       on pf.id_pessoa = fornecedor.id_pessoa
                    left join
                       fin_contrato cnt
                       on cnt.id_contrato = fornecedor.id_contrato " . $str_filtro;

        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);

                if (!empty($filtroSql)) {
                    foreach ($filtroSql as $filtro) {
                        $stmt->bindValue($filtro['bind'], $filtro['valor'], $filtro['pdo_param']);
                    }
                }

                $stmt->execute();
                if ($stmt->rowCount() >= 1) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = "Não encontrou Registros";
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function atualizaStatusSituacaoEmpenhoAnulacao(PDO $pdo = null) {
        try {
            if (empty(!$pdo)) {
                $sql = "update con_empenho_anulacao set id_empenho_anulacao_situacao = :situacao, id_empenho_anulacao_status = :status 
                        where id_empenho_anulacao = :anulacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":situacao", $this->getIdEmpenhoAnulacaoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    public function atualizaNumeroEdataAnulacaoEmpenho(PDO $pdo = null) {
        try {
            if (empty(!$pdo)) {
                $sql = "update con_empenho_anulacao set nr_empenho_anulacao = :numero, dt_empenho_anulacao = :data 
                        where id_empenho_anulacao = :anulacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":numero", $this->getNrEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->bindValue(":data", $this->getDtEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->bindValue(":anulacao", $this->getIdEmpenhoAnulacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }
        } catch (Exception $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

}
