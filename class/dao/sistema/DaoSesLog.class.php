<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesLog.class.php";

class DaoSesLog extends SesLog{


    function insert(SesLog $log, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_log (ds_tabela, id_tabela_pk, tp_log, id_pessoa, ds_ip, ds_campos_atuais, ds_campos_antigos) "
                    . "VALUES (:dsTabela, :idTabelaPk, :tpLog, :idPessoa, :dsIp, :dsCamposAtuais, :dsCamposAntigos)");
            $result->bindValue(":dsTabela", $log->getDsTabela());
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    
    /**
     * Retorna os Logs por Usuario
     * @param int $idPessoa
     * @param string $dtInicio
     * @param string $dtFim
     * @param int $limite
     * @param array $acoes
     * @param type $pdo
     * @return boolean
     */
    function retornaLogsPorUsuario(int $idPessoa, string $dtInicio, string $dtFim, int $limite, array $acoes, $pdo){

        $retorno = FALSE;
                
        $sqlInAcoes = "";
        if (sizeof($acoes) > 0) {
            $sqlInAcoes = implode("','", $acoes);
            $sqlInAcoes = "'".$sqlInAcoes."'";
            $sqlInAcoes = " tp_log IN (" . $sqlInAcoes . ")";
        }else{
            return $retorno;
        }
                
        if($dtInicio != ""){
            $sqlInAcoes .= " AND CAST(dh_log AS DATE) >= '".$dtInicio."'";
        }
        if($dtFim != ""){
            $sqlInAcoes .= " AND CAST(dh_log AS DATE) <= '".$dtFim."'";
        }
                        
        $sql = " SELECT id_log, ds_tabela, id_tabela_pk, tp_log, id_pessoa"
                . " , ds_ip, to_char(dh_log, 'DD/MM/YYYY HH24:MI:SS' ) as dh_log_format"
                . " , ds_campos_atuais, ds_campos_antigos"
                . " FROM ses_log"
                . " WHERE"
                . $sqlInAcoes                       
                . " ORDER BY dh_log DESC"
                . " LIMIT :limite";
                        
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":limite", $limite, PDO::PARAM_INT);            
            $sth->execute();            
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

}
