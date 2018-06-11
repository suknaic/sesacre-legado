<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaTransporte.class.php";

class DaoDiaTransporte extends DiaTransporte {
    
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }


    public function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into dia_transporte (nm_transporte,st_ativo) values (:nm_transporte, :st_ativo )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_transporte", $this->getNmTransporte(), PDO::PARAM_STR);
                $stmt->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
           
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
            if (!empty($pdo)) {
                $sql = "update dia_transporte "
                        . "set "
                            . "nm_transporte = :nm_transporte , "
                            . "st_ativo = :st_ativo "
                        . " where id_transporte = :id_transporte";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_transporte", $this->getNmTransporte(), PDO::PARAM_STR);
                $stmt->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_transporte", $this->getIdTransporte(), PDO::PARAM_INT);
                
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
    
    public function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from dia_transporte where id_transporte = :id_transporte";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_transporte",$this->getIdTransporte(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function select(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select dtr.id_transporte ,dtr.nm_transporte, dtr.st_ativo from dia_transporte dtr " . $this->montaFiltro() . " order by dtr.nm_transporte";
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdTransporte())) {
                    $stmt->bindValue(":id_transporte",$this->getIdTransporte(), PDO::PARAM_INT);
                }
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } 
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    private function montaFiltro(){
        $filtro_sql = "";
        //dtr - DiaTransporte
        if (!empty($this->getIdTransporte())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dtr.id_transporte = :id_transporte";
        }

        return $filtro_sql;
    }
    
}



