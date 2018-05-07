<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaRelatorioAnexo.class.php";

class DaoDiaRelatorioAnexo extends DiaRelatorioAnexo {
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
                $sql = "select id_relatorio,id_relatorio_anexo,nm_relatorio_anexo,aq_relatorio_anexo ,nm_mime_type from dia_relatorio_anexo relanx ". $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
                if (!empty($this->getIdRelatorio())) {
                    $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
                }
                
                if (!empty($this->getIdRelatorioAnexo())) {
                    $stmt->bindValue(":id_relatorio_anexo",$this->getIdRelatorioAnexo(), PDO::PARAM_INT);
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
                $sql = "insert into dia_relatorio_anexo (id_relatorio, nm_relatorio_anexo, aq_relatorio_anexo, nm_mime_type) 
                    values (:id_relatorio,:nm_relatorio_anexo, :aq_relatorio_anexo, :nm_mime_type)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_relatorio", $this->getIdRelatorio(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_relatorio_anexo", $this->getNmRelatorioAnexo(), PDO::PARAM_STR);
                $stmt->bindValue(":aq_relatorio_anexo", $this->getAqRelatorioAnexo(), PDO::PARAM_LOB);
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
                $sql = "set id_relatorio = :id_relatorio,
                            nm_relatorio_anexo = :nm_relatorio_anexo,
                            aq_relatorio_anexo = :aq_relatorio_anexo
                        where id_relatorio_anexo = :id_relatorio_anexo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_relatorio", $this->getIdRelatorio(), PDO::PARAM_INT);
                $stmt->bindValue(":nm_relatorio_anexo", $this->getNmRelatorioAnexo(), PDO::PARAM_STR);
                $stmt->bindValue(":aq_relatorio_anexo", $this->getAqRelatorioAnexo(), PDO::PARAM_LOB);
                $stmt->bindValue(":id_relatorio_anexo", $this->getIdRelatorioAnexo(), PDO::PARAM_INT);
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
                $sql = "delete from dia_relatorio_anexo where id_relatorio_anexo = :id_relatorio_anexo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_relatorio_anexo", $this->getIdRelatorioAnexo(), PDO::PARAM_INT);
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
        //relanx - DiaRelatorioAnexo
        if (!empty($this->getIdRelatorio())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " relanx.id_relatorio = :id_relatorio";
        }
        
        if (!empty($this->getIdRelatorioAnexo())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " relanx.id_relatorio_anexo = :id_relatorio_anexo";
        }

        return $filtro_sql;
    }
    
    
}