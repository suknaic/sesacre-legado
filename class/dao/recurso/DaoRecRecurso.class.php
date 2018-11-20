<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/recurso/RecRecurso.class.php";

class DaoRecRecurso extends RecRecurso {

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
            $result = $pdo->prepare("INSERT INTO rec_recurso (id_sistema, nm_recurso"
                    . " , lk_recurso, ds_recurso)"
                    . " VALUES (:id_sistema, :nm_recurso, :lk_recurso, :ds_recurso);");
            $result->bindValue(":id_sistema", $this->getIdSistema(), PDO::PARAM_INT);
            $result->bindValue(":nm_recurso", $this->getNmRecurso(), PDO::PARAM_STR);
            $result->bindValue(":lk_recurso", $this->getLkRecurso(), PDO::PARAM_STR);
            $result->bindValue(":ds_recurso", !empty($this->getDsRecurso()) ?  $this->getDsRecurso() : null, PDO::PARAM_STR);            
            $result->execute();
            $this->sucesso = true;
        } catch (PDOException $e) {
            $this->sucesso = false;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE rec_recurso SET id_sistema = :id_sistema"
                    . " , nm_recurso = :nm_recurso, lk_recurso = :lk_recurso, ds_recurso = :ds_recurso"                    
                    . " WHERE id_recurso = :id_recurso");
            $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
            $result->bindValue(":id_sistema", $this->getIdSistema(), PDO::PARAM_INT);
            $result->bindValue(":nm_recurso", $this->getNmRecurso(), PDO::PARAM_STR);
            $result->bindValue(":lk_recurso", $this->getLkRecurso(), PDO::PARAM_STR);
            $result->bindValue(":ds_recurso", !empty($this->getDsRecurso()) ?  $this->getDsRecurso() : null, PDO::PARAM_STR);            
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
                $sql = "DELETE from rec_recurso where id_recurso = :id_recurso";
                $result = $pdo->prepare($sql);
                $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
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
            $result = $pdo->prepare("UPDATE rec_recurso SET st_ativo = '0'"
                    . " WHERE id_recurso = :id_recurso");
            $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
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
                . " FROM rec_recurso"
                . " WHERE id_recurso = :id_recurso";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
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
    
    function retornaPorLkRecurso($pdo) {
        $this->sucesso = false;
        $sql = " SELECT *"
                . " FROM rec_recurso"
                . " WHERE lk_recurso = :lk_recurso and st_ativo = '1'";
        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":lk_recurso", $this->getLkRecurso(), PDO::PARAM_STR);
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
    
    
    function retornaTudoPorUsuarioRecurso(int $idPessoa, $pdo) {
        $this->sucesso = false;
        
        $sql = "SELECT R.id_recurso, PR.fl_cadastrar, PR.fl_editar, PR.fl_excluir"
                . " FROM rec_recurso R"
                . " INNER JOIN rec_pessoa_recurso PR ON PR.id_pessoa = :id_pessoa"
                    . " AND PR.id_recurso = R.id_recurso"
                . " WHERE R.id_recurso = :id_recurso AND R.st_ativo = '1'"
                . " UNION ALL"
                . " SELECT R.id_recurso, GPR.fl_cadastrar, GPR.fl_editar, GPR.fl_excluir"
                . " FROM rec_recurso R"
                . " INNER JOIN rec_grupo_pessoa_recurso GPR ON GPR.id_recurso = R.id_recurso"
                . " INNER JOIN rec_pessoa_grupo_pessoa PGP ON PGP.id_pessoa = :id_pessoa"
                    . " AND PGP.id_grupo_pessoa = GPR.id_grupo_pessoa"
                . " WHERE R.id_recurso = :id_recurso AND R.st_ativo = '1'"
                . " UNION ALL"
                . " SELECT R.id_recurso, RGR.fl_cadastrar, RGR.fl_editar, RGR.fl_excluir"
                . " FROM rec_recurso R"
                . " INNER JOIN rec_recurso_grupo_recurso RGR ON RGR.id_recurso = R.id_recurso"
                . " INNER JOIN rec_pessoa_grupo_recurso PGR ON PGR.id_grupo_recurso = RGR.id_grupo_recurso"
                . " AND PGR.id_pessoa = :id_pessoa"
                . " WHERE R.id_recurso = :id_recurso AND R.st_ativo = '1' "
                . " UNION ALL"
                . " SELECT R.id_recurso, RGR.fl_cadastrar, RGR.fl_editar, RGR.fl_excluir"
                . " FROM rec_recurso R"
                . " INNER JOIN rec_recurso_grupo_recurso RGR ON RGR.id_recurso = R.id_recurso"
                . " INNER JOIN rec_pessoa_grupo_pessoa PGP ON PGP.id_pessoa = :id_pessoa"
                . " INNER JOIN rec_grupo_pessoa_grupo_recurso GPGR ON GPGR.id_grupo_pessoa = RGR.id_grupo_recurso"
                . " AND GPGR.id_grupo_pessoa = PGP.id_grupo_pessoa"
                . " WHERE R.id_recurso = :id_pessoa AND R.st_ativo = '1' ";

        try {
            $result = $pdo->prepare($sql);
            $result->bindValue(":id_recurso", $this->getIdRecurso(), PDO::PARAM_INT);
            $result->bindValue(":id_pessoa", $idPessoa, PDO::PARAM_INT);
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
    
    function retornaTodosRecurso($pdo) {
        $this->sucesso = false;
        
        $sql = "SELECT R.id_recurso, R.id_sistema, R.nm_recurso, R.lk_recurso, R.ds_recurso, R.st_ativo"
                . " , S.nm_sistema"
                . " FROM rec_recurso R"
                . " LEFT JOIN ses_sistema S ON S.id_sistema = R.id_sistema"
                . " ORDER BY S.nm_sistema, R.lk_recurso, R.nm_recurso";                
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
