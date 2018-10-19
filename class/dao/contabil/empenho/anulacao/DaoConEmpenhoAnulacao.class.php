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

    function insert(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "insert into con_empenho_anulacao "
                . "(id_pedido,nr_empenho_anulacao,dt_empenho_anulacao,vl_empenho_anulacao,vl_empenho_antigo,"
                . "id_empenho_anulacao_situacao,id_empenho_anulacao_status,id_pessoa) "
                . "values"
                . " (:id_pedido,:nr_empenho_anulacao,:dt_empenho_anulacao,:vl_empenho_anulacao,:vl_empenho_antigo,"
                . ":id_empenho_anulacao_situacao,:id_empenho_anulacao_status,:id_pessoa)";
        try {
            if(!empty($pdo)){
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_pedido", $this->getIdPedido(), PDO::PARAM_INT);
                $stmt->bindValue(":nr_empenho_anulacao", $this->getNrEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_empenho_anulacao", $this->getDtEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_empenho_anulacao", $this->getVlEmpenhoAnulacao(), PDO::PARAM_STR);
                $stmt->bindValue(":vl_empenho_antigo", $this->getVlEmpenhoAntigo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_empenho_anulacao_situacao", $this->getIdEmpenhoAnulacaoSituacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_empenho_anulacao_status", $this->getIdEmpenhoAnulacaoStatus(), PDO::PARAM_INT);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados.';
            }
        } catch (PDOException $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function retorna(PDO $pdo){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select * from con_empenho_anulacao where id_empenho_anulacao = :id_empenho_anulacao";
        try {
            if(!empty($pdo)){
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
    
    function retornaPesquisaEmpenhoAnulacao(PDO $pdo, array $filtroSql = []){
        $this->sucesso = false;
        $this->msgRetorno = null;
        
        $str_filtro = '';
        if (!empty($filtroSql)) {
            foreach ($filtroSql as $filtro) {
                $str_filtro .= $filtro['sql'];
            }
        }
        
        $sql = "select
                    anulacaoEmp.nr_empenho_anulacao,
                    emp.nr_empenho,
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
                    anulacaoSit.nm_empenho_anulacao_situacao 
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
            if(!empty($pdo)){
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

}