<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinAutorizacaoFinanceiro.class.php";


class DaoFinAutorizacaoFinanceiro extends FinAutorizacaoFinanceiro {
    
    private $sucesso = false;
    private $msgRetorno = null;
    
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

    public function sucesso() {
        return $this->sucesso;
    }
    
    public function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into fin_autorizacao_financeiro (dt_ini,dt_fim,id_pessoa) "
                        . "values (:dt_ini, :dt_fim, :id_pessoa) ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
    
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }

    }
    
    public function update(PDO $pdo = null) {
        try {
            if(!empty($pdo)){
                $sql = "update fin_autorizacao_financeiro "
                        . "set "
                            . "dt_ini = :dt_ini, "
                            . "dt_fim = :dt_fim, "
                            . "id_pessoa = :id_pessoa "
                        . "where id_autorizacao_financeiro = :id_autorizacao_financeiro";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_autorizacao_financeiro", $this->getIdAutorizacaoFinanceiro(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_autorizacao_financeiro where id_autorizacao_financeiro = :id_autorizacao_financeiro";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_autorizacao_financeiro",$this->getIdAutorizacaoFinanceiro(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectAll(PDO $pdo = null) {
        
        try {
            if (!empty($pdo)) {
                $sql = "select faf.id_autorizacao_financeiro"
                        . " ,to_char(faf.dt_ini,'dd/mm/yyyy') as dt_ini"
                        . " ,to_char(faf.dt_fim, 'dd/mm/yyyy') as dt_fim"
                        . " ,sp.nm_pessoa, faf.st_ativo"
                        . " from fin_autorizacao_financeiro faf"
                        . " inner join ses_pessoa sp on sp.id_pessoa = faf.id_pessoa"
                        . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
                
                if (!empty($this->getIdPessoa())) {
                    $stmt->bindValue(":id_pessoa",$this->getIdPessoa(), PDO::PARAM_INT);
                }
                
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
            
    }
    
    public function selectAutorizacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select faf.id_autorizacao_financeiro as id_autorizacao, "
                        . "to_char(faf.dt_ini,'dd/mm/yyyy') as dt_ini, "
                        . "to_char(faf.dt_fim,'dd/mm/yyyy') as dt_fim, "
                        . "faf.st_ativo, faf.id_pessoa , 4 as tipo_autorizacao "
                        . "from fin_autorizacao_financeiro faf "
                        . "where id_autorizacao_financeiro = :id_autorizacao_financeiro";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_autorizacao_financeiro', $this->getIdAutorizacaoFinanceiro(),PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    private function montaFiltro(){
        $filtro_sql = "";
        //faa - FinAutorizaAtividade
        if (!empty($this->getIdPessoa())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " faf.id_pessoa = :id_pessoa";
        }
        
        return $filtro_sql;
    }
    
}


