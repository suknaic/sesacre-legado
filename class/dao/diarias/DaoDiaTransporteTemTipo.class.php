<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaTransporteTemTipo.class.php";

class DaoDiaTransporteTemTipo extends DiaTransporteTemTipo {

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
                $sql = "insert into dia_transporte_tem_tipo (id_transporte, id_transporte_tipo) values (:id_transporte, :id_transporte_tipo)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_transporte", $this->getIdTransporte(), PDO::PARAM_INT);
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
    
    function update(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "update dia_transporte_tem_tipo "
                        . "set "
                            . "id_transporte = :id_transporte , "
                            . "id_transporte_tipo = :id_transporte_tipo "
                        . " where id_transporte_tem_tipo = :id_transporte_tem_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_transporte", $this->getIdTransporte(), PDO::PARAM_INT);
                $stmt->bindValue(":id_transporte_tipo", $this->getIdTransporteTipo(), PDO::PARAM_INT);
                $stmt->bindValue(":id_transporte_tem_tipo", $this->getIdTransporteTemTipo(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_transporte_tem_tipo where id_transporte_tem_tipo = :id_transporte_tem_tipo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_transporte_tem_tipo",$this->getIdTransporteTemTipo(), PDO::PARAM_INT);
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
                $sql = "select dtp.id_transporte_tipo,
                                dttp.id_transporte,
                                dtp.nm_transporte_tipo, 
                                dtp.st_ativo 
                         from dia_transporte_tipo dtp ,dia_transporte_tem_tipo dttp
                         where dtp.id_transporte_tipo = dttp.id_transporte_tipo
                         and dttp.id_transporte = :id_transporte";
                
                $stmt = $pdo->prepare($sql);
               
                $stmt->bindValue(":id_transporte",$this->getIdTransporte(), PDO::PARAM_INT);

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
    
    function infoLocomocao(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT t.id_transporte,
                                id_transporte_tipo,
                                nm_transporte,
                           (SELECT nm_transporte_tipo
                            FROM dia_transporte_tipo tt
                            WHERE tt.id_transporte_tipo = ttt.id_transporte_tipo ) AS nm_transporte_tipo
                         FROM dia_transporte t
                         LEFT JOIN dia_transporte_tem_tipo ttt ON ttt.id_transporte = t.id_transporte
                         ORDER BY t.id_transporte";
                $stmt = $pdo->prepare($sql);
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
    

}

