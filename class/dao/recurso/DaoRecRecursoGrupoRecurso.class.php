<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/recurso/RecRecursoGrupoRecurso.class.php";

class DaoRecRecursoGrupoRecurso extends RecRecursoGrupoRecurso {

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
            $result = $pdo->prepare("INSERT INTO rec_recurso_grupo_recurso (id_recurso, id_grupo_recurso"
                    . " , fl_cadastrar, fl_editar, fl_excluir)"
                    . " VALUES (:id_recurso, :id_grupo_recurso, :fl_cadastrar, :fl_editar, :fl_excluir);");
            $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
            $result->bindValue(":id_grupo_recurso", $this->getIdGrupoRecurso(), PDO::PARAM_INT);   
            $result->bindValue(":fl_cadastrar", $this->getFlCadastrar(), PDO::PARAM_STR);            
            $result->bindValue(":fl_editar", $this->getFlEditar(), PDO::PARAM_STR);
            $result->bindValue(":fl_excluir", $this->getFlExcluir(), PDO::PARAM_STR);
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }   
    
    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE rec_recurso_grupo_recurso SET id_recurso = :id_recurso"
                    . " , id_grupo_recurso = :id_grupo_recurso, fl_cadastrar = :fl_cadastrar, fl_editar = :fl_editar"
                    . " , fl_excluir = :fl_excluir"                    
                    . " WHERE id_recurso_grupo_recurso = :id_recurso_grupo_recurso");
            $result->bindValue(":id_recurso_grupo_recurso", $this->getIdRecursoGrupoRecurso(), PDO::PARAM_INT);
            $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
            $result->bindValue(":id_grupo_recurso", $this->getIdGrupoRecurso(), PDO::PARAM_INT);
            $result->bindValue(":fl_cadastrar", $this->getFlCadastrar(), PDO::PARAM_STR);            
            $result->bindValue(":fl_editar", $this->getFlEditar(), PDO::PARAM_STR);
            $result->bindValue(":fl_excluir", $this->getFlExcluir(), PDO::PARAM_STR);
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
                $sql = "DELETE from rec_recurso_grupo_recurso where id_recurso_grupo_recurso = :id_recurso_grupo_recurso";
                $result = $pdo->prepare($sql);
                $result->bindValue(":id_recurso_grupo_recurso", $this->getIdRecursoGrupoRecurso(), PDO::PARAM_INT);
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
                . " FROM rec_recurso_grupo_recurso"
                . " WHERE id_recurso_grupo_recurso = :id_recurso_grupo_recurso";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_recurso_grupo_recurso", $this->getIdRecursoGrupoRecurso(), PDO::PARAM_INT);
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
