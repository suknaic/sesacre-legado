<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaCategoriaSecundaria.class.php";

class DaoChaCategoriaSecundaria extends ChaCategoriaSecundaria {
    /* ========================== */

    private $sucesso = null;
    private $msgRetorno = null;

    function getMsgRetorno() {
        return $this->msgRetorno;
    }

    function Sucesso() {
        return $this->sucesso;
    }

    /* ========================== */

    function cadastrarCategoriaSecundaria($pdo) {
        try {
            $sql = $pdo->prepare('INSERT INTO cha_categoria_secundaria (id_categoria_primaria, nm_categoria_secundaria, vl_categoria_secundaria)
                                  VALUES(:idCategoriaPrimaria, :nmCategoriaSecundaria, :vlCategoriaSecundaria)');
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->bindValue(':nmCategoriaSecundaria', $this->getNmCategoriaSecundaria() === '' ? null : $this->getNmCategoriaSecundaria(), PDO::PARAM_STR);
            $sql->bindValue(':vlCategoriaSecundaria', $this->getVlCategoriaSecundaria(), PDO::PARAM_STR);

            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function editarCategoriaSecundaria($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_secundaria
                                  SET nm_categoria_secundaria = :nmCategoriaSecundaria, vl_categoria_secundaria = :vlCategoriaSecundaria, id_categoria_primaria = :idCategoriaPrimaria
                                  WHERE id_categoria_secundaria = :idCategoriaSecundaria');
            $sql->bindValue(':nmCategoriaSecundaria', $this->getNmCategoriaSecundaria(), PDO::PARAM_STR);
            $sql->bindValue(':vlCategoriaSecundaria', $this->getVlCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->bindValue(':idCategoriaSecundaria', $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);

            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function listarCategoriaSecundaria($pdo) {
        try {
            $sql = $pdo->prepare('SELECT secundaria.id_categoria_secundaria, primaria.id_categoria_primaria, primaria.nm_categoria_primaria, secundaria.nm_categoria_secundaria, secundaria.vl_categoria_secundaria, secundaria.st_ativo
                                  FROM cha_categoria_secundaria AS secundaria
                                  INNER JOIN cha_categoria_primaria AS primaria ON primaria.id_categoria_primaria = secundaria.id_categoria_primaria
                                  WHERE secundaria.st_ativo IN (:ativado, :desativado)');
            $sql->bindValue(':ativado', 1, PDO::PARAM_STR);
            $sql->bindValue(':desativado', 0, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() >= 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function desativarCategoriaSecundaria($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_secundaria
                                  SET st_ativo = 0
                                  WHERE id_categoria_secundaria = :idCategoriaSecundaria');
            $sql->bindValue(':idCategoriaSecundaria', $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function ativarCategoriaSecundaria($pdo){
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_secundaria
                                  SET st_ativo= 1
                                  WHERE id_categoria_secundaria = :idCategoriaSecundaria');
            $sql->bindValue(':idCategoriaSecundaria', $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function verificaCategoriaSecundaria($pdo){
        try {
            $sql = $pdo->prepare('SELECT nm_categoria_secundaria
                                  FROM cha_categoria_secundaria
                                  WHERE id_categoria_secundaria = :idCategoriaSecundaria AND id_categoria_primaria = :idCategoriaPrimaria AND nm_categoria_secundaria = :idCategoriaSecundaria AND vl_categoria_secundaria = :vlCategoriaSecundaria');
            $sql->bindValue(':nmCategoriaSecundaria', $this->getNmCategoriaSecundaria(), PDO::PARAM_STR);
            $sql->bindValue(':vlCategoriaSecundaria', $this->getVlCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->bindValue(':idCategoriaSecundaria', $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
            } else {
                $this->sucesso = FALSE;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    function removerCategoriaSecundaria($pdo) {
        try {
            $sql = $pdo->prepare("DELETE FROM cha_categoria_secundaria WHERE id_categoria_secundaria = :idCategoriaSecundaria");
            $sql->bindValue(":idCategoriaSecundaria", $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno=$e->getMessage();
        }
    }

    function retornaCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_categoria_primaria, nm_categoria_primaria
                                  FROM cha_categoria_primaria
                                  WHERE st_ativo = :stAtivo');
            $sql->bindValue(':stAtivo', 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = FALSE;
                $this->msgRetorno = 'Não Há Categorias Primárias Cadastradas no Sistema.';
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function retornaCategoriaSecundarias($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_categoria_secundaria, nm_categoria_secundaria
                                  FROM cha_categoria_secundaria
                                  WHERE st_ativo = :stAtivo');
            $sql->bindValue(':stAtivo', 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = FALSE;
                $this->msgRetorno = 'Não Há Categorias Secundárias Cadastradas no Sistema.';
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function retornarCategoriaSecundaria($pdo) {
        try {
            $sql = $pdo->prepare('SELECT *
                                        FROM cha_categoria_secundaria
                                            WHERE id_categoria_secundaria = :idCategoriaSecundaria');
            $sql->bindValue(':idCategoriaSecundaria', $this->getIdCategoriaSecundaria(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function retornaCategoriasSecundaria($pdo) {

        $retorno = FALSE;
        try {
            if (empty($this->getIdCategoriaPrimaria())) {
                $sql = " SELECT s.*,t.nm_categoria_primaria "
                        . " FROM cha_categoria_secundaria AS s"
                        . " INNER JOIN cha_categoria_primaria AS pr"
                        . " ON s.id_categoria_primaria = pr.id_categoria_primaria  "
                        . " ORDER BY s.nm_categoria_secundaria";
            } else {
                $idCategoriaPrimaria = $this->getIdCategoriaPrimaria();
                $sql = " SELECT s.*, pr.nm_categoria_primaria"
                        . " FROM cha_categoria_secundaria AS s"
                        . " INNER JOIN cha_categoria_primaria AS pr"
                        . " ON s.id_categoria_primaria= pr.id_categoria_primaria"
                        . " WHERE pr.id_categoria_primaria=  $idCategoriaPrimaria"
                        . " ORDER BY s.nm_categoria_secundaria";
            }
            $sth = $pdo->prepare($sql);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

}
