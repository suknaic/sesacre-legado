<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaTipo.class.php";

class DaoDiaTipo extends DiaTipo {
    
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
                $sql = "insert into dia_tipo (nm_tipo,st_ativo) values (:nm_tipo, :st_ativo )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_tipo", $this->getNmTipo(), PDO::PARAM_STR);
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
                $sql = "update dia_tipo "
                        . "set "
                            . "nm_tipo = :nm_tipo , "
                            . "st_ativo = :st_ativo "
                        . " where id_tipo = :id_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_tipo", $this->getNmTipo(), PDO::PARAM_STR);
                $stmt->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_tipo", $this->getIdTipo(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_tipo where id_tipo = :id_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_tipo",$this->getIdTipo(), PDO::PARAM_INT);
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
                $sql = "select dt.id_tipo ,dt.nm_tipo, dt.st_ativo from dia_tipo dt " . $this->montaFiltro();
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdTipo())) {
                    $stmt->bindValue(":id_tipo",$this->getIdTipo(), PDO::PARAM_INT);
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
        //dd - DiaDiaria
        if (!empty($this->getIdTipo())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dt.id_tipo = :id_tipo";
        }

        return $filtro_sql;
    }
    
}



