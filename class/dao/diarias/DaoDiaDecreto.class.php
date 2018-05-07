<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaDecreto.class.php";

class DaoDiaDecreto extends DiaDecreto {
    
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
                $sql = "insert into dia_decreto (nm_decreto,st_ativo) values (:nm_decreto, :st_ativo )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_decreto", $this->getNmDecreto(), PDO::PARAM_STR);
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
                $sql = "update dia_decreto "
                        . "set "
                            . "nm_decreto = :nm_decreto , "
                            . "st_ativo = :st_ativo "
                        . " where id_decreto = :id_decreto";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_decreto", $this->getNmDecreto(), PDO::PARAM_STR);
                $stmt->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_decreto", $this->getIdDecreto(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_decreto where id_decreto = :id_decreto";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_decreto",$this->getIdDecreto(), PDO::PARAM_INT);
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
                $sql = "select dct.id_decreto ,dct.nm_decreto, dct.st_ativo from dia_decreto dct " . $this->montaFiltro();
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdDecreto())) {
                    $stmt->bindValue(":id_decreto",$this->getIdDecreto(), PDO::PARAM_INT);
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
        //dct - DiaDecreto
        if (!empty($this->getIdDecreto())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dct.id_decreto = :id_decreto";
        }

        return $filtro_sql;
    }
    
}



