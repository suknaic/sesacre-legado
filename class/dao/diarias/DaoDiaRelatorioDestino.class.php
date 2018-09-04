<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaRelatorioDestino.class.php";

class DaoDiaRelatorioDestino extends DiaRelatorioDestino {
    
    private $sucesso = false;
    private $msgRetorno = null;
    
    function getSucesso() {
        return $this->sucesso;
    }

    function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    public function selectLinha(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select * from dia_relatorio_destino where id_relatorio_destino = :id_relatorio_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_relatorio_destino",$this->getIdRelatorioDestino(), PDO::PARAM_INT);
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
    
    function select(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "SELECT dest.id_relatorio_destino, 
                                dest.id_cidade_inicio, 
                                (cid_ori.nm_cidade || ' - ' || est_ori.nm_sigla )as ds_cidade_inicio,
                                (cid_dest.nm_cidade || ' - ' || est_dest.nm_sigla )as ds_cidade_fim,
                                dest.id_cidade_fim, 
                                to_char(dest.dh_inicio,'dd/mm/yyyy hh24:mi') as dh_inicio, 
                                to_char(dest.dh_fim,'dd/mm/yyyy hh24:mi') as dh_fim,
                                dest.id_transporte, 
                                dest.id_transporte_tipo, 
                                dest.ds_transporte_tipo
                         FROM   dia_relatorio_destino dest 
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
               
                if (!empty($this->getIdRelatorio())) {
                    $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
                }
                
                if (!empty($this->getIdRelatorioDestino())) {
                    $stmt->bindValue(":id_relatorio_destino",$this->getIdRelatorioDestino(), PDO::PARAM_INT);
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
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
            
    }
    
    function insert(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "insert into dia_relatorio_destino 
                        (id_relatorio,id_cidade_inicio,id_cidade_fim,dh_inicio,dh_fim,id_transporte, id_transporte_tipo, ds_transporte_tipo) 
                        values
                        (:id_relatorio,:id_cidade_inicio,:id_cidade_fim,:dh_inicio,:dh_fim,:id_transporte, :id_transporte_tipo, :ds_transporte_tipo)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_relatorio', $this->getIdRelatorio(), PDO::PARAM_INT);
                $stmt->bindValue(':id_cidade_inicio', $this->getIdCidadeInicio(), PDO::PARAM_INT);
                $stmt->bindValue(':id_cidade_fim', $this->getIdCidadeFim(), PDO::PARAM_INT);
                $stmt->bindValue(':dh_inicio', $this->getDhInicio(), PDO::PARAM_STR);
                $stmt->bindValue(':dh_fim', $this->getDhFim(), PDO::PARAM_STR);
                $stmt->bindValue(':id_transporte', $this->getIdTransporte(), PDO::PARAM_INT);
                $stmt->bindValue(':id_transporte_tipo', $this->getIdTransporteTipo(), PDO::PARAM_INT);
                $stmt->bindValue(':ds_transporte_tipo', $this->getDsTransporteTipo(), PDO::PARAM_STR);
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
                $sql = "update dia_relatorio_destino
                        set id_cidade_inicio = :id_cidade_inicio,
                            id_cidade_fim = :id_cidade_fim,
                            dh_inicio = :dh_inicio,
                            dh_fim = :dh_fim,
                            id_transporte = :id_transporte,
                            id_transporte_tipo = :id_transporte_tipo,
                            ds_transporte_tipo = :ds_transporte_tipo
                        where id_relatorio_destino = :id_relatorio_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_cidade_inicio', $this->getIdCidadeInicio(), PDO::PARAM_INT);
                $stmt->bindValue(':id_cidade_fim', $this->getIdCidadeFim(), PDO::PARAM_INT);
                $stmt->bindValue(':dh_inicio', $this->getDhInicio(), PDO::PARAM_STR);
                $stmt->bindValue(':dh_fim', $this->getDhFim(), PDO::PARAM_STR);
                $stmt->bindValue(':id_transporte', $this->getIdTransporte(), PDO::PARAM_INT);
                $stmt->bindValue(':id_transporte_tipo', $this->getIdTransporteTipo(), PDO::PARAM_INT);
                $stmt->bindValue(':ds_transporte_tipo', $this->getDsTransporteTipo(), PDO::PARAM_STR);
                $stmt->bindValue(':id_relatorio_destino', $this->getIdRelatorioDestino(), PDO::PARAM_INT);
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
                $sql = "delete from dia_relatorio_destino where id_relatorio_destino = :id_relatorio_destino";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':id_relatorio_destino', $this->getIdRelatorioDestino(), PDO::PARAM_INT);
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
    
    function selectDestinosResumo(PDO $pdo = null) {
        try{
            if (!empty($pdo)) {
                $sql = "select to_char(dh_fim,'dd/mm/yyyy') as dt_fim,
                        to_char(dh_fim,'hh24:mi') as hr_fim,
                        to_char(dh_inicio,'dd/mm/yyyy') as dt_ini,
                        to_char(dh_inicio,'hh24:mi') as hr_ini
                        from dia_relatorio_destino  
                        where id_relatorio = :id_relatorio
                        order by dh_inicio, dh_fim";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
                 
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
        //dest - DiaRelatorioDestino
        if (!empty($this->getIdRelatorio())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dest.id_relatorio = :id_relatorio";
        }
        
        if (!empty($this->getIdRelatorioDestino())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dest.id_relatorio_destino = :id_relatorio_destino";
        }

        return $filtro_sql;
    }
}


