<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/compras/FinSubFiscalTb.class.php";

class DaoFinSubFiscal extends FinSubFiscalTb{
    
    private $sucesso = false;
    private $msgRetorno = null;

    public function __construct() {

    }

    public function sucesso() {
        return $this->sucesso;
    }

    public function getMsgRetorno() {
        return $this->msgRetorno;
    }
    
    public function insertSubFiscal($pdo = null){
        if (!empty($pdo)) {
            try {
                $sql = "INSERT INTO fin_sub_fiscal (id_pessoa, id_contrato, tp_sub_fiscal, dt_ini_sub_fiscal, dt_fim_sub_fiscal)
                VALUES (:pessoa, :contrato, :tipo, :dataIni, :dataFim)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(":pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
                $stmt->bindValue(":contrato", $this->getIdContrato() === '' ? null : $this->getIdContrato(), PDO::PARAM_INT);                
                $stmt->bindValue(":tipo", $this->getTpSubFiscal() , PDO::PARAM_INT);
                $stmt->bindValue(":dataIni", $this->getDtIniSubFiscal(), PDO::PARAM_STR);
                $stmt->bindValue(":dataFim", $this->getDtFimSubFiscal() === '' ? null : $this->getDtFimSubFiscal(), PDO::PARAM_STR);
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
}