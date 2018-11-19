<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/recurso/RecPessoaGrupoPessoa.class.php";

class DaoRecPessoaGrupoPessoa extends RecPessoaGrupoPessoa {

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO rec_pessoa_grupo_pessoa (id_pessoa, id_grupo_pessoa)"
                    . " VALUES (:id_pessoa, :id_grupo_pessoa);");
            $result->bindValue(":id_pessoa", $this->getIdPessoa(), PDO::PARAM_INT);
            $result->bindValue(":id_grupo_pessoa", $this->getIdGrupoPessoa(), PDO::PARAM_INT);            
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }   
    
    function delete(PDO $pdo = null) {
        try {
            if (!empty($pdo)) {
                $sql = "DELETE from rec_pessoa_grupo_pessoa where id_pessoa_grupo_pessoa = :id_pessoa_grupo_pessoa";
                $result = $pdo->prepare($sql);
                $result->bindValue(":id_pessoa_grupo_pessoa", $this->getIdPessoaGrupoPessoa(), PDO::PARAM_INT);
                $result->execute();
                $this->sucesso = true;
            }  else {
                $this->msgRetorno = 'Sem conexão com o banco de dados';
            }
        } catch (PDOException $exc) {
            $this->sucesso = false;
            $this->msgRetorno = $exc->getMessage();
        }
    }
            
    function retorna($pdo) {
        $this->sucesso = false;
        $sql = " SELECT *"
                . " FROM rec_pessoa_grupo_pessoa"
                . " WHERE id_pessoa_grupo_pessoa = :id_pessoa_grupo_pessoa";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_pessoa_grupo_pessoa", $this->getIdPessoaGrupoPessoa(), PDO::PARAM_INT);
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetch(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = false;
                $this->msgRetorno = "Não encontrou Registros";
            }
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    
    
}
