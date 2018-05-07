<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaCategoriaPrincipal.class.php";

class DaoChaCategoriaPrincipal extends ChaCategoriaPrincipal {
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

    function insert(ChaCategoriaPrincipal $prin, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_categoria_principal (nm_categoria_principal)
                                    VALUES (:nmCategoriaPrincipal)");
            $result->bindValue(":nmCategoriaPrincipal", $prin->getNm_categoria_principal(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update(ChaCategoriaPrincipal $prin, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_categoria_principal SET nm_categoria_principal = :nmCategoriaPrincipal "
                    . " WHERE id_categoria_principal = :idCategoriaPrincipal ");
            $result->bindValue(":idCategoriaPrincipal", $prin->getId_categoria_principal(), PDO::PARAM_INT);
            $result->bindValue(":nmCategoriaPrincipal", $prin->getNm_categoria_principal(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete(ChaCategoriaPrincipal $prin, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_categoria_principal WHERE id_categoria_principal = :idCategoriaPrincipal");
            $result->bindValue(":idCategoriaPrincipal", $prin->getId_categoria_principal(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa(ChaCategoriaPrincipal $prin, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_categoria_principal
                                    SET st_ativo = 0 "
                    . "WHERE id_categoria_principal = :idCategoriaPrincipal ");
            $result->bindValue(":idCategoriaPrincipal", $prin->getId_categoria_principal(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function ativa(ChaCategoriaPrincipal $prin, $pdo) {
        try {
            $result = $pdo->prepare('UPDATE cha_categoria_principal
                                  SET st_ativo = 1
                                  WHERE id_categoria_principal =:idCategoriaPrincipal');
            $result->bindValue(':idCategoriaPrincipal', $this->getId_categoria_principal(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaPrincipais($pdo) {
         try {
           $sql = $pdo->prepare("SELECT * FROM cha_categoria_principal WHERE st_ativo IN (:ativado, :desativado) ORDER BY nm_categoria_principal");
           $sql->bindValue(':ativado', '1', PDO::PARAM_STR);
               $sql->bindValue(':desativado', '0', PDO::PARAM_STR);
               $sql->execute();
               if($sql->rowCount() >= 0){
                   $this->sucesso = TRUE;
                   $this->msgRetorno = $sql->fetchAll(PDO::FETCH_ASSOC);
               }
        
       } catch (Exception $e) {
           $this->sucesso = FALSE;
               $this->msgRetorno = $e->getMessage();
         }
    }

    function listaPrincipal($pdo) {

        try {
            $sql = $pdo->prepare("SELECT *"
                    . " FROM cha_categoria_principal"
                    . " WHERE st_ativo IN (:ativado, :desativado)"
                    . " ORDER BY nm_categoria_principal");
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

    function retornaPrincipal($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_categoria_principal"
                . " WHERE id_categoria_principal = :idCategoriaPrincipal";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idCategoriaPrincipal", $this->getId_categoria_principal(), PDO::PARAM_INT);
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

    function buscaPrincipal(ChaCategoriaPrincipal $prin, $pdo) {
        $retorno = false;
        $semPrincipal = "";
        if ($prin->getId_categoria_principal() != NULL || $prin->getId_categoria_principal() != "") {
            $semPrincipal = " AND id_categoria_principal <> :idCategoriaPrincipal";
        }
        $sql = " SELECT "
                . " id_categoria_principal, nm_categoria_principal"
                . " FROM cha_categoria_principal"
                . " WHERE nm_categoria_principal = :nmCategoriaPrincipal"
                . $semPrincipal
                . "";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmCategoriaPrincipal", $prin->getNm_categoria_principal(), PDO::PARAM_STR);
            if ($prin->getId_categoria_principal() != NULL || $prin->getId_categoria_principal() != "") {
                $sth->bindValue(":idCategoriaPrincipal", $prin->getId_categoria_principal(), PDO::PARAM_INT);
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

    function verificaCategoriaPrincipal($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_categoria_principal
                                  FROM cha_categoria_principal
                                  WHERE id_categoria_principal=:idCategoriaPrincipal');
            $sql->bindValue(':idCategoriaPrincipal', $this->getId_categoria_principal(), PDO::PARAM_INT);
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
