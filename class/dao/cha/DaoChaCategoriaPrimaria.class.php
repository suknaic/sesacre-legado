<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaCategoriaPrimaria.class.php";

class DaoChaCategoriaPrimaria extends ChaCategoriaPrimaria {
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

    function cadastrarCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare('INSERT INTO cha_categoria_primaria(id_categoria_tipo, nm_categoria_primaria)
                                  VALUES(:idCategoriaTipo, :nmCategoriaPrimaria)');
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->bindValue(':nmCategoriaPrimaria', $this->getNmCategoriaPrimaria() === '' ? null : $this->getNmCategoriaPrimaria(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function editarCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_primaria
                                  SET nm_categoria_primaria = :nmCategoriaPrimaria, id_categoria_tipo = :idCategoriaTipo
                                  WHERE id_categoria_primaria = :idCategoriaPrimaria');
            $sql->bindValue(':nmCategoriaPrimaria', $this->getNmCategoriaPrimaria(), PDO::PARAM_STR);
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function desativarCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_primaria
                                  SET st_ativo = 0
                                  WHERE id_categoria_primaria = :idCategoriaPrimaria');
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function ativarCategoriaPrimaria($pdo){
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_primaria
                                  SET st_ativo= 1
                                  WHERE id_categoria_primaria = :idCategoriaPrimaria');
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function listarCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare('SELECT primaria.id_categoria_primaria, tipo.id_categoria_tipo, tipo.nm_categoria_tipo, primaria.nm_categoria_primaria, primaria.st_ativo
                                  FROM cha_categoria_primaria as primaria
                                  INNER JOIN cha_categoria_tipo as tipo ON tipo.id_categoria_tipo = primaria.id_categoria_tipo
                                  WHERE primaria.st_ativo IN (:ativado, :desativado)');
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

    function retornarCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare('SELECT *
                                        FROM cha_categoria_primaria
                                            WHERE id_categoria_primaria = :idCategoriaPrimaria');
            $sql->bindValue(':idCategoriaPrimaria', $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
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
    
    function verificaCategoriaPrimaria($pdo){
        try {
            $sql = $pdo->prepare('SELECT nm_categoria_primaria
                                  FROM cha_categoria_primaria
                                  WHERE nm_categoria_primaria = :nmCategoriaPrimaria AND id_categoria_tipo = :idCategoriaTipo');
            $sql->bindValue(':nmCategoriaPrimaria', $this->getNmCategoriaPrimaria(), PDO::PARAM_STR);
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
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

    function removerCategoriaPrimaria($pdo) {
        try {
            $sql = $pdo->prepare("DELETE FROM cha_categoria_primaria WHERE id_categoria_primaria = :idCategoriaPrimaria");
            $sql->bindValue(":idCategoriaPrimaria", $this->getIdCategoriaPrimaria(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno=$e->getMessage();
        }
    }

    function retornaCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_categoria_tipo, nm_categoria_tipo
                                  FROM cha_categoria_tipo
                                  WHERE st_ativo = :stAtivo');
            $sql->bindValue(':stAtivo', 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0){
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = FALSE;
                $this->msgRetorno = 'Não Há Categorias Tipo Cadastradas no Sistema.';
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }
    
    function retornaCategoriasPrimaria($pdo) {

        $retorno = FALSE;
        try {
            if (empty($this->getIdCategoriaTipo())) {
                $sql = " SELECT pr.*,t.nm_categoria_tipo "
                        . " FROM cha_categoria_primaria AS pr"
                        . " INNER JOIN cha_categoria_tipo t"
                        . " ON pr.id_categoria_tipo = t.id_categoria_tipo  "
                        . " ORDER BY pr.nm_categoria_primaria";
            } else {
                $idCategoriaTipo = $this->getIdCategoriaTipo();
                $sql = " SELECT pr.*, t.nm_categoria_tipo"
                        . " FROM cha_categoria_primaria AS pr"
                        . " INNER JOIN cha_categoria_tipo AS t"
                        . " ON pr.id_categoria_tipo = t.id_categoria_tipo"
                        . " WHERE t.id_categoria_tipo=  $idCategoriaTipo"
                        . " ORDER BY pr.nm_categoria_primaria ";
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
