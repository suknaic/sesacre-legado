<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaCategoriaTipo.class.php";

class DaoChaCategoriaTipo extends ChaCategoriaTipo {
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

    function cadastrarCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('INSERT INTO cha_categoria_tipo(id_categoria_principal, nm_categoria_tipo)
                                  VALUES(:idCategoriaPrincipal, :nmCategoriaTipo)');
            $sql->bindValue(':idCategoriaPrincipal', $this->getIdCategoriaPrincipal(), PDO::PARAM_INT);
            $sql->bindValue(':nmCategoriaTipo', $this->getNmCategoriaTipo() === '' ? null : $this->getNmCategoriaTipo(), PDO::PARAM_STR);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function editarCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_tipo
                                  SET nm_categoria_tipo=:nmCategoriaTipo, id_categoria_principal =:idCategoriaPrincipal
                                  WHERE id_categoria_tipo =:idCategoriaTipo');
            $sql->bindValue(':nmCategoriaTipo', $this->getNmCategoriaTipo(), PDO::PARAM_STR);
            $sql->bindValue(':idCategoriaPrincipal', $this->getIdCategoriaPrincipal(), PDO::PARAM_INT);
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function removerCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare("DELETE FROM cha_categoria_tipo WHERE id_categoria_tipo = :idCategoriaTipo");
            $sql->bindValue(":idCategoriaTipo", $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function desativarCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_tipo
                                  SET st_ativo = 0
                                  WHERE id_categoria_tipo =:idCategoriaTipo');
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function ativarCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('UPDATE cha_categoria_tipo
                                  SET st_ativo= 1
                                  WHERE id_categoria_tipo =:idCategoriaTipo');
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->execute();
            $this->sucesso = TRUE;
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function listarCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('SELECT tipo.id_categoria_tipo, principal.id_categoria_principal, principal.nm_categoria_principal, tipo.nm_categoria_tipo, tipo.st_ativo
                                  FROM cha_categoria_tipo as tipo
                                  INNER JOIN cha_categoria_principal as principal ON principal.id_categoria_principal=tipo.id_categoria_principal
                                  WHERE tipo.st_ativo IN (:ativado, :desativado)');
            $sql->bindValue(':ativado', 1, PDO::PARAM_STR);
            $sql->bindValue(':desativado', 0, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornarCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('SELECT *
                                        FROM cha_categoria_tipo
                                            WHERE id_categoria_tipo=:idCategoriaTipo');
            $sql->bindValue(':idCategoriaTipo', $this->getIdCategoriaTipo(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function verificaCategoriaTipo($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_categoria_tipo
                                  FROM cha_categoria_tipo
                                  WHERE nm_categoria_tipo=:nmCategoriaTipo AND id_categoria_principal=:idCategoriaPrincipal');
            $sql->bindValue(':nmCategoriaTipo', $this->getNmCategoriaTipo(), PDO::PARAM_STR);
            $sql->bindValue(':idCategoriaPrincipal', $this->getIdCategoriaPrincipal(), PDO::PARAM_INT);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
            } else {
                $this->sucesso = FALSE;
            }
        } catch (Exception $ex) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $ex->getMessage();
        }
    }

    function retornaCategoriaPrincipal($pdo) {
        try {
            $sql = $pdo->prepare('SELECT id_categoria_principal, nm_categoria_principal
                                  FROM cha_categoria_principal
                                  WHERE st_ativo=:stAtivo');
            $sql->bindValue(':stAtivo', 1, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $this->sucesso = FALSE;
                $this->msgRetorno = 'Não há Categorias Principais Cadastradas no Sistema.';
            }
        } catch (PDOException $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaCategoriasTipo($pdo) {

        $retorno = FALSE;
        try {
            if (empty($this->getIdCategoriaPrincipal())) {
                $sql = " SELECT t.*,P.nm_categoria_principal "
                        . " FROM cha_categoria_tipo t"
                        . " INNER JOIN cha_categoria_principal P"
                        . " ON t.id_categoria_principal = P.id_categoria_principal  "
                        . " ORDER BY t.nm_categoria_tipo";
            } else {
                $idCategoriaPrincipal = $this->getIdCategoriaPrincipal();
                $sql = " SELECT t.*,P.nm_categoria_principal "
                        . " FROM cha_categoria_tipo t"
                        . " INNER JOIN cha_categoria_principal P"
                        . " ON t.id_categoria_principal = P.id_categoria_principal "
                        . " where P.id_categoria_principal =  $idCategoriaPrincipal "
                        . " ORDER BY t.nm_categoria_tipo ";
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

    function retornaPrincipaisSelect($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_categoria_principal"
                . " ORDER BY nm_categoria_principal";
        try {
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
