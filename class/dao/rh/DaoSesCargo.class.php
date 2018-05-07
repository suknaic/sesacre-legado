<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/class/tabelas/rh/SesCargo.class.php";

class DaoSesCargo extends SesCargo {

    function insert($pdo) {
        try {
            $result = $pdo->prepare("INSERT INTO ses_cargo (nm_cargo) "
                    . "VALUES (:nmCargo)");
            $result->bindValue(":nmCargo", $this->getNm_cargo(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function update($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_cargo SET nm_cargo = :nmCargo "
                    . "WHERE id_cargo = :idCargo ");
            $result->bindValue(":idCargo", $this->getId_cargo(), PDO::PARAM_INT);
            $result->bindValue(":nmCargo", $this->getNm_cargo(), PDO::PARAM_STR);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function delete($pdo) {
        try {
            $result = $pdo->prepare("DELETE FROM ses_cargo WHERE Id_cargo = :idCargo");
            $result->bindValue(":idCargo", $this->getId_cargo(), PDO::PARAM_INT);
            $result->execute();

            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    function desativa($pdo) {
        try {
            $result = $pdo->prepare("UPDATE ses_cargo SET st_ativo = 0 "
                    . "WHERE Id_cargo = :idCargo ");
            $result->bindValue(":idCargo", $this->getId_cargo(), PDO::PARAM_INT);
            $result->execute();
            return "Sucesso";
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    /*
     * Retornar todas os dados das Lotações
     * Ainda aguardando o modulo de RH para melhorar isso.
     */

    function retornaCargos($pdo) {

        $retorno = FALSE;

        $sql = "SELECT id_cargo, nm_cargo"
                . " FROM ses_cargo"
                . " ORDER BY nm_cargo";
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

    /**
     * Retorna as informações de uma Lotação Especifico
     * @param type $pdo
     * @return boolean
     */
    function retornaCargo($pdo) {

        $retorno = FALSE;
        $sql = "SELECT id_cargo, nm_cargo
                 FROM ses_cargo
                 WHERE id_cargo = :idCargo";
        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":idCargo", $this->getId_cargo(), PDO::PARAM_INT);
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

    /**
     * Retorna Informação do Cargo caso o nome seja igual
     * Caso seja passado um ID Cargo, esse ID será desconsiderado na busca 
     * @param type $pdo
     * @return boolean/Object
     */
    function buscaCargoPorNome($pdo) {
        $retorno = false;
        $filtro = "";
        if ($this->getId_cargo() != NULL || $this->getId_cargo() != "") {
            $filtro = " AND id_cargo <> :idCargo";
        }
        $sql = " SELECT "
                . " id_cargo, nm_cargo"
                . " FROM ses_cargo"
                . " WHERE nm_cargo ilike :nmCargo"
                . $filtro
                . "";

        try {
            $sth = $pdo->prepare($sql);
            $sth->bindValue(":nmCargo", $this->getNm_cargo(), PDO::PARAM_STR);
            if ($this->getId_cargo() != NULL || $this->getId_cargo() != "") {
                $sth->bindValue(":idCargo", $this->getId_cargo(), PDO::PARAM_INT);
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

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

