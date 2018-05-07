<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaCondicao.class.php";

class DaoChaCondicao extends ChaCondicao {
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

    function insert(ChaCondicao $con, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_condicao  (nm_condicao)
                                    VALUES (:nmCondicao)");
            $result->bindValue(":nmCondicao", $con->getNmCondicao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update(ChaCondicao $con, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_condicao SET nm_condicao = :nmCondicao "
                    . " WHERE id_condicao = :idCondicao ");
            $result->bindValue(":idCondicao", $con->getIdCondicao(), PDO::PARAM_INT);
            $result->bindValue(":nmCondicao", $con->getNmCondicao(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete(ChaCondicao $con, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_condicao WHERE id_condicao = :idCondicao");
            $result->bindValue(":idCondicao", $con->getIdCondicao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa(ChaCondicao $con, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_condicao
                                    SET st_ativo = 0 "
                    . "WHERE id_condicao = :idCondicao ");
            $result->bindValue(":idCondicao", $con->getIdCondicao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function ativa(ChaCondicao $con, $pdo) {
        try {
            $result = $pdo->prepare('UPDATE cha_condicao
                                  SET st_ativo = 1
                                  WHERE id_condicao =:idCondicao');
            $result->bindValue(':idCondicao', $this->getIdCondicao(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaCondicoes($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_condicao"
                . " ORDER BY nm_condicao";
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

    function listaCondicao($pdo) {

        try {
            $sql = $pdo->prepare("SELECT *"
                    . " FROM cha_condicao"
                    . " WHERE st_ativo IN (:ativado, :desativado)"
                    . " ORDER BY nm_condicao");
            $sql->bindValue(':ativado', 1, PDO::PARAM_STR);
            $sql->bindValue(':desativado', 0, PDO::PARAM_STR);
            $sql->execute();
            if ($sql->rowCount() >= 0) {
                $this->sucesso = TRUE;
                $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $this->sucesso = FALSE;
            $this->msgRetorno = $e->getMessage();
        }
    }

    function retornaCondicao($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_condicao"
                . " WHERE id_condicao = :idCondicao";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idCondicao", $this->getIdCondicao(), PDO::PARAM_INT);
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetch(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return $retorno;
        }
    }

    function buscaCondicao(ChaCondicao $con, $pdo) {
        $retorno = false;
        $semCondicao = "";
        if ($con->getIdCondicao() != NULL || $con->getIdCondicao() != "") {
            $semCondicao = " AND id_condicao <> :idCondicao";
        }
        $sql = " SELECT "
                . " id_condicao, nm_condicao"
                . " FROM cha_condicao"
                . " WHERE nm_condicao = :nmCondicao"
                . $semCondicao
                . "";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmCondicao", $con->getNmCondicao(), PDO::PARAM_STR);
            if ($con->getIdCondicao() != NULL || $con->getIdCondicao() != "") {
                $sth->bindValue(":idCondicao", $con->getIdCondicao(), PDO::PARAM_INT);
            }
            $sth->execute();
            if ($sth->rowCount() >= 1) {
                return $sth->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return $retorno;
            }
            return $retorno;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return $retorno;
        }
    }

    function retornaCondicoesSelect($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_condicao"
                . " ORDER BY nm_condicao";
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

    function verificaCondicao($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_condicao
                                  FROM cha_condicao
                                  WHERE id_condicao = :idCondicao');
            $sql->bindValue(':idCondicao', $this->getIdCondicao(), PDO::PARAM_INT);
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

}
