<?php


require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/financeiro/fin/FinAutorizaAtividade.class.php";


class DaoFinAutorizaAtividade extends FinAutorizaAtividade {
    
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
                $sql = "insert into fin_autoriza_atividade (dt_ini,dt_fim,id_pessoa,id_lotacao) "
                        . "values (:dt_ini, :dt_fim, :id_pessoa, :id_lotacao) ";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
           
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
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
                $sql = "update fin_autoriza_atividade "
                        . "set "
                            . "dt_ini = :dt_ini , "
                            . "dt_fim = :dt_fim, "
                            . "id_pessoa = :id_pessoa, "
                            . "id_lotacao = :id_lotacao "
                        . " where id_autoriza_atividade = :id_autoriza_atividade";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":dt_ini", $this->getDtIni(),PDO::PARAM_STR);
                $stmt->bindValue(":dt_fim", $this->getDtFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":id_lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->bindValue(":id_autoriza_atividade", $this->getIdAutorizaAtividade(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from fin_autoriza_atividade where id_autoriza_atividade = :id_autoriza_atividade";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_autoriza_atividade",$this->getIdAutorizaAtividade(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectAll(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                
                $sql = "select faa.id_autoriza_atividade"
                        . " ,to_char(faa.dt_ini,'dd/mm/yyyy') as dt_ini"
                        . " ,to_char(faa.dt_fim, 'dd/mm/yyyy') as dt_fim"
                        . " ,sp.nm_pessoa, sl.nm_lotacao, faa.sit_ativo "
                        . " from fin_autoriza_atividade faa"
                        . " inner join ses_pessoa sp on sp.id_pessoa = faa.id_pessoa"
                        . " inner join ses_lotacao sl on sl.id_lotacao = faa.id_lotacao"
                        . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
                
                if (!empty($this->getIdPessoa())) {
                    $stmt->bindValue(":id_pessoa",$this->getIdPessoa(), PDO::PARAM_INT);
                }
                if (!empty($this->getIdLotacao())) {
                    $stmt->bindValue(":id_lotacao",$this->getIdLotacao(), PDO::PARAM_INT);
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
                $this->sucesso = false;
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
            
    }
    
    public function selectAutorizacao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select faa.id_autoriza_atividade as id_autorizacao, "
                        . "to_char(faa.dt_ini,'dd/mm/yyyy') as dt_ini, "
                        . "to_char(faa.dt_fim,'dd/mm/yyyy') as dt_fim, "
                        . "faa.sit_ativo, faa.id_pessoa, faa.id_lotacao , 1 as tipo_autorizacao "
                        . "from fin_autoriza_atividade faa "
                        . "where id_autoriza_atividade = :id_autoriza_atividade";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_autoriza_atividade', $this->getIdAutorizaAtividade(),PDO::PARAM_INT);
                $stmt->execute();
//                $stmt->fetch(PDO::FETCH_ASSOC)
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
            $filtro_sql .= " faa.id_pessoa = :id_pessoa";
        }
        if (!empty($this->getIdLotacao())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " faa.id_lotacao = :id_lotacao";
        }
        
        return $filtro_sql;
    }
    
}


