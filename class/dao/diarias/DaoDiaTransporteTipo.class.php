<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaTransporteTipo.class.php";

class DaoDiaTransporteTipo extends DiaTransporteTipo {

    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into dia_transporte_tipo (nm_transporte_tipo) values (:nm_transporte_tipo)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_transporte_tipo", $this->getNmTransporteTipo(), PDO::PARAM_STR);
           
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
    
    function update(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update dia_transporte_tipo "
                        . "set "
                            . "nm_transporte = :nm_transporte_tipo , "
                            . "st_ativo = :st_ativo "
                        . " where id_transporte_tipo = :id_transporte_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_transporte_tipo", $this->getNmTransporteTipo(), PDO::PARAM_STR);
                $stmt->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_transporte_tipo", $this->getIdTransporteTipo(), PDO::PARAM_INT);
                
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
    
    function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "delete from dia_transporte_tipo where id_transporte_tipo = :id_transporte_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_transporte_tipo",$this->getIdTransporteTipo(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    function select(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select dtp.id_transporte_tipo ,dtp.nm_transporte_tipo, dtp.st_ativo from dia_transporte_tipo dtp " . $this->montaFiltro();
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdTransporteTipo())) {
                    $stmt->bindValue(":id_transporte_tipo",$this->getIdTransporteTipo(), PDO::PARAM_INT);
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
        //dtp - DiaTransporteTipo
        if (!empty($this->getIdTransporteTipo())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dtp.id_transporte_tipo = :id_transporte_tipo";
        }

        return $filtro_sql;
    }

}