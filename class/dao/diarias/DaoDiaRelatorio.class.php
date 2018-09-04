<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/diarias/DiaRelatorio.class.php";

class DaoDiaRelatorio extends DiaRelatorio {
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
                $sql = "insert into dia_relatorio (ds_servico_executado,ds_locais_executado,dt_relatorio_destino, fl_retorno) "
                        . "values (:ds_servico_executado, :ds_locais_executado, :dt_relatorio_destino, :fl_retorno )";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":ds_servico_executado", $this->getDsServicoExecutado(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_locais_executado", $this->getDsLocaisExecutado(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_relatorio_destino", $this->getDtRelatorioDestino(), PDO::PARAM_STR);
                $stmt->bindValue(":fl_retorno", $this->getFlRetorno(), PDO::PARAM_STR);
           
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
                $sql = "update dia_relatorio "
                        . "set "
                            . "ds_servico_executado = :ds_servico_executado, "
                            . "ds_locais_executado  = :ds_locais_executado,"
                            . "dt_relatorio_destino = :dt_relatorio_destino, "
                            . "fl_retorno = :fl_retorno"
                        . " where id_relatorio = :id_relatorio";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindValue(":ds_servico_executado", $this->getDsServicoExecutado(), PDO::PARAM_STR);
                $stmt->bindValue(":ds_locais_executado", $this->getDsLocaisExecutado(), PDO::PARAM_STR);
                $stmt->bindValue(":dt_relatorio_destino", $this->getDtRelatorioDestino(), PDO::PARAM_STR);
                $stmt->bindValue(":fl_retorno", $this->getFlRetorno(), PDO::PARAM_STR);
                $stmt->bindValue(":id_relatorio", $this->getIdRelatorio(), PDO::PARAM_INT);
                
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
                $sql = "delete from dia_relatorio where id_relatorio = :id_relatorio";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
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
                $sql = "select dr.id_relatorio ,dr.ds_servico_executado, dr.ds_locais_executado , to_char(dr.dt_relatorio_destino,'dd/mm/yyyy') as dt_relatorio_destino , dr.fl_retorno from dia_relatorio dr " . $this->montaFiltro();
                
                $stmt = $pdo->prepare($sql);
               
                if (!empty($this->getIdRelatorio())) {
                    $stmt->bindValue(":id_relatorio",$this->getIdRelatorio(), PDO::PARAM_INT);
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
    
    public function infoProposto(PDO $pdo = null){
        try {
            if (!empty($pdo)) {
                $sql = "select rel.id_relatorio, (select nm_pessoa from ses_pessoa p where p.id_pessoa = dia.id_pessoa_proposto) as nm_proposto, 
                            (select nm_funcao from ses_funcao f where f.id_funcao = dia.id_funcao_proposto) as fn_proposto, 
                            (select nm_lotacao from ses_lotacao l where l.id_lotacao = dia.id_lotacao_proposto) as lt_proposto,
                            (SELECT c.nr_matricula
                             FROM ses_pessoa p,
                                  ses_pessoa_fisica pf,
                                  ses_contrato c
                             WHERE p.id_pessoa = pf.id_pessoa
                               AND pf.id_pessoa_fisica = c.id_pessoa_fisica
                               AND p.id_pessoa = dia.id_pessoa_proposto) as mt_proposto,
                            rel.ds_servico_executado,
                            rel.ds_locais_executado,
                            dia.nr_protocolo
                     from dia_relatorio rel, dia_diaria dia 
                     where dia.id_relatorio = rel.id_relatorio
                     and rel.id_relatorio = :id_relatorio";
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
            $this->msgRetorno = $exc->getMessage();
        }
    }
     
    private function montaFiltro(){
        $filtro_sql = "";
        //dd - DiaDiaria
        if (!empty($this->getIdRelatorio())) {
            $filtro_sql .= (empty($filtro_sql) ? " where" : " and");
            $filtro_sql .= " dr.id_relatorio = :id_relatorio";
        }

        return $filtro_sql;
    }
}
