<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/sistema/SesSistema.class.php";

class DaoSesSistema extends SesSistema{

    private $sucesso = false;
    private $msgRetorno = null;

    /**
     * Get the value of sucesso
     */ 
    public function getSucesso()
    {
        return $this->sucesso;
    }

    /**
     * Get the value of msgRetorno
     */ 
    public function getMsgRetorno()
    {
        return $this->msgRetorno;
    }

    function retornaTodos(PDO $pdo = null){
        $this->sucesso = false;
        $this->msgRetorno = null;
        $sql = "select * from ses_sistema";
        try {
            if (!empty($pdo)) {
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $this->sucesso = true;
                    $this->msgRetorno = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $this->msgRetorno = 'Nenhum registro encontrado';
                }
            } else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOExecption $e) {
            $this->msgRetorno = $e->getMessage();
        }
    }
}