<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaClasse.class.php";

class DaoDiaClasse extends DiaClasse {
    
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
                $sql = "insert into dia_classe (nm_classe,cd_classe,st_ativo) values (:nm_classe, :cd_classe, :st_ativo )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_classe", $this->getNmClasse(), PDO::PARAM_STR);
                $stmt->bindValue(":cd_classe", $this->getCdClasse(), PDO::PARAM_STR);
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
                $sql = "update dia_classe "
                        . "set "
                            . "nm_classe = :nm_classe, "
                            . "cd_classe = :cd_classe, "
                            . "st_ativo = :st_ativo "
                        . " where id_classe = :id_classe";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":nm_classe", $this->getNmClasse(), PDO::PARAM_STR);
                $stmt->bindValue(":cd_classe", $this->getCdClasse(), PDO::PARAM_STR);
                $stmt->bindValue(":st_ativo", $this->getStAtivo(), PDO::PARAM_STR);
                $stmt->bindValue(":id_tipo", $this->getIdClasse(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_classe where id_classe = :id_classe";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_classe",$this->getIdClasse(), PDO::PARAM_INT);
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
                "select dc.id_classe ,dc.nm_classe,dc.cd_classe, dc.st_ativo from dia_classe dc " . $this->montaFiltro();
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdClasse())) {
                    $stmt->bindValue(":id_classe",$this->getIdClasse(), PDO::PARAM_INT);
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
        //dc - DiaClasse
        if (!empty($this->getIdTipo())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dc.id_classe = :id_classe";
        }

        return $filtro_sql;
    }
    
}



