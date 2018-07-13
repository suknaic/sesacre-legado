<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinCentraisTb.class.php";

class DaoFinCentrais extends FinCentraisTb {

    private $sucesso = false;
    private $msgRetorno = null;

    function __construct() {
        
    }

    /**
     * @return mixed
     */
    public function sucesso() {
        return $this->sucesso;
    }

    /**
     * @return mixed
     */
    public function getMsgRetorno() {
        return $this->msgRetorno;
    }

  

    public function insertCentralAta($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_ata_central (id_ata, id_lotacao) VALUES (:id, :lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id", $this->getIdAta(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    public function insertCentralContrato($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_cont_central (id_contrato, id_lotacao) VALUES (:id, :lotacao)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":id", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }
    
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM fin_cont_central WHERE id_cont_central = :idContCentral");
            $result->bindValue(":idContCentral", $this->getIdContCentral(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true; 
        } catch (PDOException $e) {
            $this->sucesso = false;  
            $this->msgRetorno = $e->getMessage(); 
            if($e->getCode() == "23503"){
                $this->msgRetorno = "FKViolation";                
            }            
        }
    }

    public function retornaCentrais(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select central.id_central_demanda, l.id_lotacao, l.nm_lotacao
				from fin_central_demanda as central
				inner join ses_lotacao as l
				on l.id_lotacao = central.id_lotacao
                                ORDER BY l.nm_lotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function removeCentral($pdo = null) {
        if (!empty($pdo)) {
            try {
                $sql = "delete from fin_cont_central where id_contrato = :idContrato AND id_lotacao = :idLotacao";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":idLotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                $this->sucesso = true;
            } catch (PDOException $e) {
                $this->sucesso = false;
                $this->msgRetorno = $e->getMessage();
            }
        } else {
            $this->sucesso = false;
            $this->msgRetorno = 'Sem conexão com o banco de dados';
        }
    }

    public function retornaCentraisPorFornecedor(PDO $pdo = null, int $idFornecedor = null) {
        try {
            if (!empty($pdo) && !empty($idFornecedor)) {
                $sql = "select l.id_lotacao, l.nm_lotacao
                        from fin_fornecedor as f
                        inner join fin_contrato as cont
                        on cont.id_contrato = f.id_contrato 
                        inner join fin_cont_central as central
                        on central.id_contrato =  cont.id_contrato
                        inner join ses_lotacao as l
                        on l.id_lotacao =  central.id_lotacao
                        where f.id_fornecedor = :idFornecedor";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idFornecedor", $idFornecedor, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }

    public function verificarCentralBanco(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "select *
                        from fin_cont_central as central
                        where central.id_contrato = :contrato
                        and central.id_lotacao = :lotacao
                        and central.st_ativo = '1'";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":contrato", $this->getIdContrato(), PDO::PARAM_INT);
                $stmt->bindValue(":lotacao", $this->getIdLotacao(), PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }
    
    public function retornaCentraisPorContrato(PDO $pdo = null, int $idContrato = null) {
        try {
            if (!empty($pdo) && !empty($idContrato)) {
                $sql = "SELECT id_cont_central, id_contrato, id_lotacao"
                        . " FROM fin_cont_central"
                        . " WHERE id_contrato = :idContrato";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":idContrato", $idContrato, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $this->sucesso = true;
                } else {
                    $this->sucesso = false;
                }
            } else {
                $this->sucesso = false;
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (Error $e) {
            $this->msgRetorno = $e->getMessage();
            $this->sucesso = false;
        }
    }
    
    function retorna($pdo){
        
        $retorno = FALSE;
        
        $sql = "SELECT *"
                . " FROM fin_cont_central"
                . " WHERE id_cont_central = :idContCentral";
        try {
            
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idContCentral", $this->getIdContCentral(), PDO::PARAM_INT);       
            $sth->execute();           
            if($sth->rowCount() >= 1){
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetch(PDO::FETCH_ASSOC);
                return;                 
            }else{
                $this->sucesso = false;
                $this->msgRetorno = "Não achou o registro";
                return;
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
            return;
        }
    }

}
