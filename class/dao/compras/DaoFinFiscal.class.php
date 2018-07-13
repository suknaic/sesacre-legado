<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinFiscaisTb.class.php";

class DaoFinFiscal extends FinFiscaisModelTb {

	private $sucesso = false;
	private $msgRetorno = null;

	public function __construct() {

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

	public function insertFiscal($pdo = null) {
		if (!empty($pdo)) {
			try {
				$sql = "INSERT INTO fin_fiscal (id_pessoa, id_contrato, tp_fiscal, dt_ini_fiscal, dt_fim_fiscal)
                VALUES (:pessoa, :contrato, :tipo, :dataIni, :dataFim)";
				$stmt = $pdo->prepare($sql);
				$stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
				$stmt->bindValue(":contrato", $this->getIdContrato() === '' ? null : $this->getIdContrato(), PDO::PARAM_INT);
				$stmt->bindValue(":tipo", $this->getTpFiscal(), PDO::PARAM_INT);
				$stmt->bindValue(":dataIni", $this->getDtIniFiscal(), PDO::PARAM_STR);
				$stmt->bindValue(":dataFim", $this->getDtFimFiscal() === '' ? null : $this->getDtFimFiscal(), PDO::PARAM_STR);
				$stmt->execute();
				$this->sucesso = true;
			} catch (PDOException $e) {
				$this->sucesso = false;

				if ($e->getCode() == "23505") {
					$this->msgRetorno = 'Alguns itens já ser encontra salvo no sistema';
				} else {
					$this->msgRetorno = $e->getMessage();
				}
			}
		} else {
			$this->sucesso = false;
			$this->msgRetorno = 'Sem conexão com o banco de dados';
		}
	}
        
        
    function delete($pdo){
        try {
            $result = $pdo->prepare("DELETE FROM fin_fiscal WHERE id_fiscal = :idFiscal");
            $result->bindValue(":idFiscal", $this->getIdFiscal(), PDO::PARAM_INT);
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
    
    function retorna($pdo){
        
        $retorno = FALSE;
        
        $sql = "SELECT *"
                . " FROM fin_fiscal"
                . " WHERE id_fiscal = :idFiscal";
        try {
            
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idFiscal", $this->getIdFiscal(), PDO::PARAM_INT);       
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
    
    function retornaTodosPorContrato($pdo){
        
        $retorno = FALSE;
        
        $sql = "SELECT id_fiscal, tp_fiscal, id_contrato, id_pessoa, dt_ini_fiscal"
                . " , dt_fim_fiscal"
                . " FROM fin_fiscal"
                . " WHERE id_contrato = :idContrato ";
        try {            
            $sth = $pdo->prepare($sql);  
            $sth->bindValue(":idContrato", $this->getIdContrato(), PDO::PARAM_INT);       
            $sth->execute();           
            if($sth->rowCount() >= 1){
                $this->sucesso = true;
                $this->msgRetorno = $sth->fetchAll(PDO::FETCH_ASSOC);
                return;                 
            }else{
                $this->sucesso = true;
                $this->msgRetorno = "";
                return;
            }            
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
            return;
        }
    }

}
