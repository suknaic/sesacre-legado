<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinAutorizaOrcamento.class.php";


class DaoFinAutorizaOrcamento extends FinAutorizaOrcamento {
    
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
                $sql = "insert into fin_autoriza_orcamento (dt_ini,dt_fim,id_pessoa) "
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
                $sql = "update fin_autoriza_orcamento "
                        . "set "
                            . "dt_ini = :dt_ini, "
                            . "dt_fim = :dt_fim, "
                            . "id_pessoa = :id_pessoa "
                        . "where id_autoriza_orcamento = :id_autoriza_orcamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_autoriza_orcamento", $this->getIdAutorizaOrcamento(), PDO::PARAM_INT);
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
                $sql = "delete from fin_autoriza_orcamento where id_autoriza_orcamento = :id_autoriza_orcamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_autoriza_orcamento",$this->getIdAutorizaOrcamento(), PDO::PARAM_INT);
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
                $sql = "select fao.id_autoriza_orcamento"
                        . " ,to_char(fao.dt_ini,'dd/mm/yyyy') as dt_ini"
                        . " ,to_char(fao.dt_fim, 'dd/mm/yyyy') as dt_fim"
                        . " ,sp.nm_pessoa, fao.st_ativo"
                        . " from fin_autoriza_orcamento fao"
                        . " inner join ses_pessoa sp on sp.id_pessoa = fao.id_pessoa"
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
                $sql = "select fao.id_autoriza_orcamento as id_autorizacao, "
                        . "to_char(fao.dt_ini,'dd/mm/yyyy') as dt_ini, "
                        . "to_char(fao.dt_fim,'dd/mm/yyyy') as dt_fim, "
                        . "fao.st_ativo, fao.id_pessoa , 3 as tipo_autorizacao "
                        . "from fin_autoriza_orcamento fao "
                        . "where id_autoriza_orcamento = :id_autoriza_orcamento";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_autoriza_orcamento', $this->getIdAutorizaOrcamento(),PDO::PARAM_INT);
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
            $filtro_sql .= " fao.id_pessoa = :id_pessoa";
        }
        
        return $filtro_sql;
    }
    
}


