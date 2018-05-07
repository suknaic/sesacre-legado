<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaAnexo.class.php";

class DaoDiaAnexo extends DiaAnexo {
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    function select(PDO $pdo = null){
        try {
            if(!empty($pdo)){
                $sql = "select id_anexo,id_diaria,aq_anexo,nm_anexo ,nm_mime_type from dia_anexo anx ". $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
                if (!empty($this->getIdAnexo())) {
                    $stmt->bindValue(":id_anexo",$this->getIdAnexo(), PDO::PARAM_INT);
                }
                
                if (!empty($this->getIdDiaria())) {
                    $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                }
                
                $stmt->execute();

                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } 
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }

    function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into dia_anexo (id_diaria, nm_anexo, aq_anexo, nm_mime_type) 
                    values (:id_diaria,:nm_anexo,:aq_anexo, :nm_mime_type)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_anexo", $this->getNmAnexo(), PDO::PARAM_STR);
                $stmt->bindValue(":aq_anexo", $this->getAqAnexo(), PDO::PARAM_LOB);
                $stmt->bindValue(":nm_mime_type", $this->getNmMimeType(), PDO::PARAM_STR);

                $stmt->execute();
                $this->sucesso = true;
            }  else {
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
                $sql = "set id_diaria = :id_diaria,
                            nm_anexo = :nm_anexo,
                            aq_anexo = :aq_anexo,
                            nm_mime_type = :nm_mime_type
                        where id_anexo = :id_anexo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_anexo", $this->getNmAnexo(), PDO::PARAM_STR);
                $stmt->bindValue(":nm_mime_type", $this->getNmMimeType(), PDO::PARAM_STR);
                $stmt->bindValue(":aq_anexo", $this->getAqAnexo(), PDO::PARAM_LOB);
                $stmt->bindValue(":id_anexo", $this->getIdAnexo(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }  else {
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
                $sql = "delete from dia_anexo where id_anexo = :id_anexo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_anexo", $this->getIdAnexo(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
     
    private function montaFiltro(){
        $filtro_sql = "";
        //anx - DiaAnexo
        if (!empty($this->getIdAnexo())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " anx.id_anexo = :id_anexo";
        }
        
        if (!empty($this->getIdDiaria())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " anx.id_diaria = :id_diaria";
        }

        return $filtro_sql;
    }
    
    
}