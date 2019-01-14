<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/recurso/RecGrupoRecurso.class.php";

class DaoRecGrupoRecurso extends RecGrupoRecurso {

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
            $result = $pdo->prepare("INSERT INTO rec_grupo_recurso (nm_grupo_recurso)"
                    . " VALUES (:nm_grupo_recurso);");            
            $result->bindValue(":nm_grupo_recurso", $this->getNmGrupoRecurso(), PDO::PARAM_STR);                        
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE rec_grupo_recurso SET nm_grupo_recurso = :nm_grupo_recurso"                    
                    . " WHERE id_grupo_recurso = :id_grupo_recurso");
            $result->bindValue(":id_grupo_recurso", $this->getIdGrupoRecurso(), PDO::PARAM_INT);
            $result->bindValue(":nm_grupo_recurso", $this->getNmGrupoRecurso(), PDO::PARAM_STR);            
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
                $sql = "DELETE from rec_grupo_recurso where id_grupo_recurso = :id_grupo_recurso";
                $result = $pdo->prepare($sql);
                $result->bindValue(":id_grupo_recurso", $this->getIdGrupoRecurso(), PDO::PARAM_INT);
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

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE rec_grupo_recurso SET st_ativo = '0'"
                    . " WHERE id_grupo_recurso = :id_grupo_recurso");
            $result->bindValue(":id_grupo_recurso", $this->getIdGrupoRecurso(), PDO::PARAM_INT);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }
        
    function retorna($pdo) {
        $this->sucesso = false;
        $sql = " SELECT *"
                . " FROM rec_grupo_recurso"
                . " WHERE id_grupo_recurso = :id_grupo_recurso";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_grupo_recurso", $this->getIdGrupoRecurso(), PDO::PARAM_INT);
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

    function retornaTodosGrupoRecurso($pdo) {
        $this->sucesso = false;
        
        $sql = "SELECT GR.id_grupo_recurso, GR.nm_grupo_recurso, GR.st_ativo"
                . " FROM rec_grupo_recurso GR";                
        try {
            $result = $pdo->prepare($sql);            
            $result->execute();
            if ($result->rowCount() >= 1) {
                $this->sucesso = true;
                $this->msgRetorno = $result->fetchAll(PDO::FETCH_ASSOC);
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
