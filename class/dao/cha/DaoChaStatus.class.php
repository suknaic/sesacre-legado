<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/cha/ChaStatus.class.php";

class DaoChaStatus extends ChaStatus {
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

    function insert(ChaStatus $sta, $pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO cha_status  (nm_status)
                                    VALUES (:nmStatus)");
            $result->bindValue(":nmStatus", $sta->getNmStatus(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update(ChaStatus $sta, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_status SET nm_status = :nmStatus "
                    . " WHERE id_status = :idStatus ");
            $result->bindValue(":idStatus", $sta->getIdStatus(), PDO::PARAM_INT);
            $result->bindValue(":nmStatus", $sta->getNmStatus(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete(ChaStatus $sta, $pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM cha_status WHERE id_status = :idStatus");
            $result->bindValue(":idStatus", $sta->getIdStatus(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa(ChaStatus $sta, $pdo) {
        try {
            $result = $pdo->prepare("UPDATE cha_status
                                    SET st_ativo = 0 "
                    . "WHERE id_status = :idStatus ");
            $result->bindValue(":idStatus", $sta->getIdStatus(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function ativa(ChaStatus $sta, $pdo) {
        try {
            $result = $pdo->prepare('UPDATE cha_status
                                  SET st_ativo = 1
                                  WHERE id_status =:idStatus');
            $result->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function retornaStatuss($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_status"
                . " ORDER BY nm_status";
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

    function listaStatus($pdo) {

        try {
            $sql = $pdo->prepare("SELECT *"
                    . " FROM cha_status"
                    . " WHERE st_ativo IN (:ativado, :desativado)"
                    . " ORDER BY nm_status");
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

    function retornaStatus($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_status"
                . " WHERE id_status = :idStatus";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idStatus", $this->getIdStatus(), PDO::PARAM_INT);
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

    function buscaStatus(ChaStatus $sta, $pdo) {
        $retorno = false;
        $semStatus = "";
        if ($sta->getIdStatus() != NULL || $sta->getIdStatus() != "") {
            $semStatus = " AND id_status <> :idStatus";
        }
        $sql = " SELECT "
                . " id_status, nm_status"
                . " FROM cha_status"
                . " WHERE nm_status = :nmStatus"
                . $semStatus
                . "";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmStatus", $sta->getNmStatus(), PDO::PARAM_STR);
            if ($sta->getIdStatus() != NULL || $sta->getIdStatus() != "") {
                $sth->bindValue(":idStatus", $sta->getIdStatus(), PDO::PARAM_INT);
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

    function retornaStatussSelect($pdo) {

        $retorno = FALSE;

        $sql = " SELECT *"
                . " FROM cha_status"
                . " ORDER BY nm_status";
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

    function verificaStatus($pdo) {
        try {
            $sql = $pdo->prepare('SELECT nm_status
                                  FROM cha_status
                                  WHERE id_status=:idStatus');
            $sql->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
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
