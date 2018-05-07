<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaDecretoValor.class.php";

class DaoDiaDecretoValor extends DiaDecretoValor {
    
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
                $sql = "insert into dia_decreto_valor (id_decreto,id_classe,tp_decreto_valor, vl_decreto_valor) "
                        . "values (:id_decreto, :id_classe, :tp_decreto_valor , :vl_decreto_valor )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_decreto", $this->getIdDecreto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_classe", $this->getIdClasse(), PDO::PARAM_INT);
                $stmt->bindValue(":tp_decreto_valor", $this->getTpDecretoValor(), PDO::PARAM_INT);
                $stmt->bindValue(":vl_decreto_valor", $this->getVlDecretoValor(), PDO::PARAM_INT);
           
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
                $sql = "update dia_decreto_valor "
                        . "set "
                            . "id_decreto = :id_decreto , "
                            . "id_classe = :id_classe "
                            . "tp_decreto_valor = :tp_decreto_valor "
                            . "vl_decreto_valor = :vl_decreto_valor "
                        . " where id_decreto_valor = :id_decreto_valor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_decreto", $this->getIdDecreto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_classe", $this->getIdClasse(), PDO::PARAM_INT);
                $stmt->bindValue(":tp_decreto_valor", $this->getTpDecretoValor(), PDO::PARAM_INT);
                $stmt->bindValue(":vl_decreto_valor", $this->getVlDecretoValor(), PDO::PARAM_INT);
                $stmt->bindValue(":id_decreto_valor", $this->getIdDecretoValor(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_decreto_valor where id_decreto_valor = :id_decreto_valor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_decreto_valor",$this->getIdDecretoValor(), PDO::PARAM_INT);
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
                $sql = "select dv.id_decreto_valor ,dv.id_decreto, dv.id_classe, dc.nm_classe, dc.cd_classe "
                        . "from dia_decreto_valor dv, dia_classe dc "
                        . "where dv.id_classe = dc.id_classe "
                        . $this->montaFiltro();
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdDecreto())) {
                    $stmt->bindValue(":id_decreto",$this->getIdDecreto(), PDO::PARAM_INT);
                }
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
        //dv - DiaDecretoValor
        if (!empty($this->getIdDecreto())) {
            $filtro_sql .= " and dv.id_decreto = :id_decreto";
        }
        if (!empty($this->getIdClasse())) {
            $filtro_sql .= " and dv.id_classe = :id_classe";
        }

        return $filtro_sql;
    }
    
}



