<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaDiariaDestino.class.php";

class DaoDiaDiariaDestino extends DiaDiariaDestino {
    
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
                $sql = "insert into dia_diaria_destino "
                        . "(id_diaria, id_cidade_inicio, id_cidade_fim, dh_inicio,"
                        . " dh_fim ,id_transporte, id_decreto, id_classe, fl_pernoite,"
                        . " qt_diaria_destino ,vl_diaria_destino) "
                        . "values (:id_diaria, :id_cidade_inicio, :id_cidade_fim, :dh_inicio, "
                        . "        :dh_fim, :id_transporte, :id_decreto, :id_classe, :fl_pernoite, "
                        . "        :qt_diaria_destino, :vl_diaria_destino)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":id_cidade_inicio", $this->getIdCidadeInicio(), PDO::PARAM_INT);
                $stmt->bindValue(":id_cidade_fim", $this->getIdCidadeFim(), PDO::PARAM_INT);
                $stmt->bindValue(":dh_inicio", $this->getDhInicio(), PDO::PARAM_STR);
                $stmt->bindValue(":dh_fim", $this->getDhFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_transporte", $this->getIdTransporte(), PDO::PARAM_INT);
                $stmt->bindValue(":id_decreto", $this->getIdDecreto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_classe", $this->getIdClasse(),PDO::PARAM_INT);
                $stmt->bindValue(":fl_pernoite", $this->getFlPernoite(),PDO::PARAM_STR);
                $stmt->bindValue(":qt_diaria_destino", $this->getQtDiariaDestino(),PDO::PARAM_INT);
                $stmt->bindValue(":vl_diaria_destino", $this->getVlDiariaDestino(), PDO::PARAM_INT);
                
           
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
                $sql = "update dia_diaria_destino "
                        . "set "
                            . "id_cidade_inicio = :id_cidade_inicio , "
                            . "id_cidade_fim = :id_cidade_fim , "
                            . "dh_inicio = :dh_inicio , "
                            . "dh_fim = :dh_fim , "
                            . "id_transporte = :id_transporte , "
                            . "id_decreto = :id_decreto , "
                            . "id_classe = :id_classe , "
                            . "fl_pernoite = :fl_pernoite , "
                            . "qt_diaria_destino = :qt_diaria_destino , "
                            . "vl_diaria_destino = :vl_diaria_destino  "
                        . " where id_diaria = :id_diaria and id_diaria_destino = :id_diaria_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria", $this->getIdDiaria(), PDO::PARAM_INT);
                $stmt->bindValue(":id_diaria_destino", $this->getIdDiariaDestino(), PDO::PARAM_INT);
                $stmt->bindValue(":id_cidade_inicio", $this->getIdCidadeInicio(), PDO::PARAM_INT);
                $stmt->bindValue(":id_cidade_fim", $this->getIdCidadeFim(), PDO::PARAM_INT);
                $stmt->bindValue(":dh_inicio", $this->getDhInicio(), PDO::PARAM_STR);
                $stmt->bindValue(":dh_fim", $this->getDhFim(), PDO::PARAM_STR);
                $stmt->bindValue(":id_transporte", $this->getIdTransporte(), PDO::PARAM_INT);
                $stmt->bindValue(":id_decreto", $this->getIdDecreto(), PDO::PARAM_INT);
                $stmt->bindValue(":id_classe", $this->getIdClasse(),PDO::PARAM_STR);
                $stmt->bindValue(":fl_pernoite", $this->getFlPernoite(),PDO::PARAM_STR);
                $stmt->bindValue(":qt_diaria_destino", $this->getQtDiariaDestino(),PDO::PARAM_INT);
                $stmt->bindValue(":vl_diaria_destino", $this->getVlDiariaDestino(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_diaria_destino where id_diaria_destino = :id_diaria_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria_destino",$this->getIdDiariaDestino(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            $this->msgRetorno = $exc->getMessage();
        }
    }
    
    public function selectLinha(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from dia_diaria_destino where id_diaria_destino = :id_diaria_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_diaria_destino",$this->getIdDiariaDestino(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }
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
                $sql = "SELECT dest.id_diaria_destino, 
                                (cid_ori.nm_cidade || ' - ' || est_ori.nm_sigla )as ds_cidade_inicio,
                                dest.id_cidade_inicio, 
                                to_char(dest.dh_inicio,'dd/mm/yyyy hh24:mi')     as dh_inicio, 
                                (cid_dest.nm_cidade || ' - ' || est_dest.nm_sigla )as ds_cidade_fim,
                                dest.id_cidade_fim, 
                                to_char(dest.dh_fim,'dd/mm/yyyy hh24:mi') as dh_fim,
                                dest.fl_pernoite, 
                                dest.id_transporte, 
                                dest.id_decreto, 
                                dest.id_classe, 
                                dest.qt_diaria_destino, 
                                dest.vl_diaria_destino,
                                round((dest.qt_diaria_destino * dest.vl_diaria_destino) ,2) as vl_total 
                         FROM   dia_diaria_destino dest 
                                JOIN ses_cidade cid_ori 
                                  ON cid_ori.id_cidade = dest.id_cidade_inicio 
                                JOIN ses_estado est_ori 
                                  ON est_ori.id_estado = cid_ori.id_estado 
                                JOIN ses_cidade cid_dest 
                                  ON cid_dest.id_cidade = dest.id_cidade_fim 
                                JOIN ses_estado est_dest 
                                  ON est_dest.id_estado = cid_dest.id_estado "
                        . $this->montaFiltro();
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdDiaria())) {
                    $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                }
                
                if (!empty($this->getIdDiariaDestino())) {
                    $stmt->bindValue(":id_diaria_destino",$this->getIdDiariaDestino(), PDO::PARAM_INT);
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
    
    function selectDiariaDestinos(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select
                            destino.qt_diaria_destino,
                            destino.vl_diaria_destino,
                            round((destino.qt_diaria_destino * destino.vl_diaria_destino),2) as vl_total,
                            to_char(destino.dh_inicio, 'dd/mm/yyyy hh24:mi') as dh_inicio,
                            to_char(destino.dh_fim, 'dd/mm/yyyy hh24:mi') as dh_fim,
                            (
                               select
                                  co.nm_cidade || ' - ' || eo.nm_sigla 
                               from
                                  ses_cidade co,
                                  ses_estado eo 
                               where
                                  co.id_estado = eo.id_estado 
                                  and co.id_cidade = destino.id_cidade_inicio
                            )
                            as origem,
                            (
                               select
                                  cf.nm_cidade || ' - ' || ef.nm_sigla 
                               from
                                  ses_cidade cf,
                                  ses_estado ef 
                               where
                                  cf.id_estado = ef.id_estado 
                                  and cf.id_cidade = destino.id_cidade_fim
                            )
                            as destino 
                         from
                            dia_diaria_destino destino 
                         where
                            destino.id_diaria = :id_diaria 
                         order by
                            dh_inicio";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                 
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    function selectDestinosResumo(PDO $pdo = null) {
        try{
            if (!empty($pdo)) {
                $sql = "select to_char(max(dh_fim),'dd/mm/yyyy') as dt_fim,
                                to_char(max(dh_fim),'hh24:mi') as hr_fim,
                                to_char(min(dh_inicio),'dd/mm/yyyy') as dt_ini,
                                to_char(min(dh_inicio),'hh24:mi') as hr_ini,
                                round(sum((qt_diaria_destino * vl_diaria_destino)),2) as soma_total 
                         from dia_diaria_destino  
                         where id_diaria = :id_diaria;";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_diaria",$this->getIdDiaria(), PDO::PARAM_INT);
                 
                $stmt->execute();
                if ($stmt->rowCount() > 0) { 
                    $this->msgRetorno = $stmt->fetch(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    private function montaFiltro(){
        $filtro_sql = "";
        //dest - DiaDiariaDestino
        if (!empty($this->getIdDiaria())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dest.id_diaria = :id_diaria";
        }
        
        if (!empty($this->getIdDiariaDestino())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dest.id_diaria_destino = :id_diaria_destino";
        }

        return $filtro_sql;
    }
    
}



